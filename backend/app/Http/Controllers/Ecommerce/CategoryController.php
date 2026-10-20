<?php

namespace App\Http\Controllers\Ecommerce;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController
{
    public function index(Request $request)
    {
        $perPage = (int) $request->get('per_page', 15);

        // Books reference their category by name (or slug) in a free text
        // column, so the count is resolved with a sub-query.
        $query = Category::query()
            ->select('categories.*')
            ->addSelect([
                'products_count' => Book::query()
                    ->selectRaw('count(*)')
                    ->where(function ($q) {
                        $q->whereColumn('books.category', 'categories.name')
                            ->orWhereColumn('books.category', 'categories.slug');
                    }),
            ]);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->get('search') . '%');
        }

        $categories = $query->orderBy('created_at', 'desc')->paginate($perPage);

        // Public API: return JSON so the storefront can list categories
        // managed in the Laravel admin area.
        return response()->json([
            'success' => true,
            'data' => $categories->items(),
            'meta' => [
                'current_page' => $categories->currentPage(),
                'last_page' => $categories->lastPage(),
                'per_page' => $categories->perPage(),
                'total' => $categories->total(),
            ],
        ]);
    }

    /**
     * Show a single category by ID (public read).
     */
    public function show($id)
    {
        $category = Category::query()->with('childs')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $category,
        ]);
    }


    public function create()
    {
        return view('admin.categories.create');
    }

    public function edit(int $id)
    {
        $category = Category::query()->findOrFail($id);

        return view('admin.categories.edit', compact('category'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug',
            'description' => 'nullable|string',
        ]);

        $validator->validate();

        $category = Category::create($validator->validated());

        return response()->json([
            'success' => true,
            'data' => $category,
            'message' => 'Category created successfully',
        ], 201);
    }

    public function update(Request $request, int $id)
    {
        $category = Category::query()->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug,' . $id,
            'description' => 'nullable|string',
        ]);

        $validator->validate();

        $category->update($validator->validated());

        return response()->json([
            'success' => true,
            'data' => $category,
            'message' => 'Category updated successfully',
        ]);
    }

    public function destroy(int $id)
    {
        $category = Category::query()->findOrFail($id);
        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully',
        ]);
    }
}