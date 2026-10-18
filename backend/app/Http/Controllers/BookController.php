<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
class BookController extends Controller
{
    /**
     * GET /api/books
     * Public catalog listing with optional filters.
     */
    public function index(Request $request)
    {
        $perPage = (int) $request->get('per_page', 15);

        $query = Book::query()->where('is_active', true);

        if ($request->filled('search')) {
            $query->search($request->get('search'));
        }

        if ($request->filled('category')) {
            $query->byCategory($request->get('category'));
        }

        if ($request->filled('premium')) {
            $isPremium = filter_var($request->get('premium'), FILTER_VALIDATE_BOOLEAN);
            $isPremium ? $query->premium() : $query->free();
        }

        if ($request->filled('featured') && filter_var($request->get('featured'), FILTER_VALIDATE_BOOLEAN)) {
            $query->featured();
        }

        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');
        $query->orderBy($sort, $direction);

        $books = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $books,
        ]);
    }

    /**
     * GET /api/books/total
     */
    public function total()
    {
        return response()->json([
            'success' => true,
            'data' => [
                'total' => Book::where('is_active', true)->count(),
                'premium' => Book::where('is_active', true)->where('is_premium', true)->count(),
                'free' => Book::where('is_active', true)->where('is_premium', false)->count(),
            ],
        ]);
    }

    /**
     * GET /api/books/{id}
     * Public book details. Includes access status for authenticated users.
     */
    public function show(Request $request, int $id)
    {
        $book = Book::query()->where('is_active', true)->findOrFail($id);

        $data = $book->toArray();
        $data['can_access'] = false;
        $data['access_type'] = null;

        if ($request->user()) {
            $access = BookAccess::query()
                ->where('user_id', $request->user()->id)
                ->where('book_id', $book->id)
                ->active()
                ->first();

            if ($access) {
                $data['can_access'] = true;
                $data['access_type'] = $access->access_type;
                $data['access_expires_at'] = $access->expires_at;
            }
        } elseif (! $book->is_premium) {
            // Free books are accessible to everyone.
            $data['can_access'] = true;
            $data['access_type'] = 'free';
        }

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    /**
     * GET /api/books/{id}/read
     * Returns the book file URL for an authenticated user with active access.
     */
    public function read(Request $request, int $id)
    {
        $book = Book::where('is_active', true)->findOrFail($id);

        $access = BookAccess::query()
            ->where('user_id', $request->user()->id)
            ->where('book_id', $book->id)
            ->active()
            ->first();

        if (! $access) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have access to this book. Please subscribe or purchase it.',
            ], 403);
        }

        if (! $book->file_path) {
            return response()->json([
                'success' => false,
                'message' => 'Book file is not available yet.',
            ], 404);
        }

        // Increment read counter
        $book->increment('read_count');

        return response()->json([
            'success' => true,
            'data' => [
                'book' => $book,
                'file_url' => Storage::disk('public')->url($book->file_path),
                'access' => $access,
            ],
        ]);
    }

    /**
     * GET /api/books/{id}/preview
     * Public preview access (first few pages / sample).
     */
    public function preview(Request $request, int $id)
    {
        $book = Book::where('is_active', true)->findOrFail($id);

        if (! $book->preview_path) {
            return response()->json([
                'success' => false,
                'message' => 'Preview is not available for this book.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'preview_url' => Storage::disk('public')->url($book->preview_path),
            ],
        ]);
    }

    /**
     * GET /api/admin/books
     * Admin: list all books (including inactive) with pagination and search.
     */
    public function adminIndex(Request $request)
    {
        $query = Book::query()->with('author');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->get('search')}%")
                    ->orWhere('author', 'like', "%{$request->get('search')}%");
            });
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', filter_var($request->get('is_active'), FILTER_VALIDATE_BOOLEAN));
        }

        $books = $query->orderBy('created_at', 'desc')->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $books,
        ]);
    }

    /**
     * GET /api/admin/books/{id}
     * Admin: get a single book.
     */
    public function adminShow(int $id)
    {
        $book = Book::with('author')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $book,
        ]);
    }

    /**
     * POST /api/admin/books
     * Admin: create a new book (PDF upload only).
     */
    public function adminStore(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:books',
            'author' => 'nullable|string|max:255',
            'author_id' => 'nullable|exists:authors,id',
            'publisher' => 'nullable|string|max:255',
            'language' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'publication_year' => 'nullable|integer|min:1000|max:9999',
            'page_count' => 'nullable|integer|min:1',
            'format' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'file' => 'required|file|mimes:pdf|max:20480',
            'price' => 'nullable|numeric|min:0',
            'is_premium' => 'sometimes|boolean',
            'is_active' => 'sometimes|boolean',
            'is_featured' => 'sometimes|boolean',
            'tags' => 'sometimes|array',
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $data['price'] = $data['price'] ?? 0;
        $data['is_premium'] = $data['is_premium'] ?? false;
        $data['is_active'] = $data['is_active'] ?? true;
        $data['is_featured'] = $data['is_featured'] ?? false;

        // Upload the PDF file and store its path
        $filePath = $request->file('file')->store('books', 'public');
        $data['file_path'] = $filePath;

        $book = Book::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Book created successfully.',
            'data' => $book->load('author'),
        ], 201);
    }

    /**
     * PUT/PATCH /api/admin/books/{id}
     * Admin: update a book.
     */
    public function adminUpdate(Request $request, int $id)
    {
        $book = Book::findOrFail($id);

        $data = $request->validate([
            'title' => 'sometimes|string|max:255',
            'slug' => 'sometimes|string|max:255|unique:books,slug,' . $book->id,
            'author' => 'sometimes|nullable|string|max:255',
            'author_id' => 'sometimes|nullable|exists:authors,id',
            'publisher' => 'sometimes|nullable|string|max:255',
            'language' => 'sometimes|nullable|string|max:255',
            'category' => 'sometimes|nullable|string|max:255',
            'publication_year' => 'sometimes|nullable|integer|min:1000|max:9999',
            'page_count' => 'sometimes|nullable|integer|min:1',
            'format' => 'sometimes|nullable|string|max:50',
            'description' => 'sometimes|nullable|string',
            'file' => 'sometimes|nullable|file|mimes:pdf|max:20480',
            'price' => 'sometimes|nullable|numeric|min:0',
            'is_premium' => 'sometimes|boolean',
            'is_active' => 'sometimes|boolean',
            'is_featured' => 'sometimes|boolean',
            'tags' => 'sometimes|array',
        ]);

        if (isset($data['slug']) && empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title'] ?? $book->title);
        }

        // Handle PDF file upload
        if ($request->hasFile('file')) {
            if ($book->file_path) {
                Storage::disk('public')->delete($book->file_path);
            }
            $data['file_path'] = $request->file('file')->store('books', 'public');
        }

        unset($data['file']);

        $book->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Book updated successfully.',
            'data' => $book->load('author'),
        ]);
    }

    /**
     * DELETE /api/admin/books/{id}
     * Admin: delete a book.
     */
    public function adminDestroy(int $id)
    {
        $book = Book::findOrFail($id);

        if ($book->file_path) {
            Storage::disk('public')->delete($book->file_path);
        }

        $book->delete();

        return response()->json([
            'success' => true,
            'message' => 'Book deleted successfully.',
        ]);
    }
}