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
}