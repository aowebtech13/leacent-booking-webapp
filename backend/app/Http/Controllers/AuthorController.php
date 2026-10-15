<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthorController extends Controller
{
    /**
     * GET /api/admin/authors
     * List all authors with optional search and pagination.
     */
    public function index(Request $request)
    {
        $query = Author::query()->withCount('books');

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('bio', 'like', "%{$search}%");
            });
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', filter_var($request->get('is_active'), FILTER_VALIDATE_BOOLEAN));
        }

        $authors = $query->orderBy('created_at', 'desc')->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $authors,
        ]);
    }

    /**
     * POST /api/admin/authors
     * Create a new author.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:authors',
            'bio' => 'nullable|string',
            'email' => 'nullable|email|max:255|unique:authors',
            'phone' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'avatar' => 'nullable|string|max:255',
            'is_active' => 'sometimes|boolean',
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $author = Author::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Author created successfully.',
            'data' => $author,
        ], 201);
    }

    /**
     * GET /api/admin/authors/{id}
     * Get a single author.
     */
    public function show($id)
    {
        $author = Author::with('books')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $author,
        ]);
    }

    /**
     * PUT/PATCH /api/admin/authors/{id}
     * Update an author.
     */
    public function update(Request $request, $id)
    {
        $author = Author::findOrFail($id);

        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'slug' => 'sometimes|string|max:255|unique:authors,slug,' . $author->id,
            'bio' => 'sometimes|nullable|string',
            'email' => 'sometimes|nullable|email|max:255|unique:authors,email,' . $author->id,
            'phone' => 'sometimes|nullable|string|max:255',
            'website' => 'sometimes|nullable|url|max:255',
            'avatar' => 'sometimes|nullable|string|max:255',
            'is_active' => 'sometimes|boolean',
        ]);

        $author->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Author updated successfully.',
            'data' => $author,
        ]);
    }

    /**
     * DELETE /api/admin/authors/{id}
     * Delete an author. Books referencing the author keep their author_id nulled.
     */
    public function destroy($id)
    {
        $author = Author::findOrFail($id);

        $author->books()->update(['author_id' => null]);

        $author->delete();

        return response()->json([
            'success' => true,
            'message' => 'Author deleted successfully.',
        ]);
    }
}
