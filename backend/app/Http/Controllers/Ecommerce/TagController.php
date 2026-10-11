<?php

namespace App\Http\Controllers\Ecommerce;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagController
{
    public function index(Request $request)
    {
        $perPage = (int) $request->get('per_page', 15);

        $query = Tag::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->get('search') . '%');
        }

        $tags = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $tags->items(),
            'meta' => [
                'current_page' => $tags->currentPage(),
                'last_page' => $tags->lastPage(),
                'per_page' => $tags->perPage(),
                'total' => $tags->total(),
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:tags,slug',
            'description' => 'nullable|string',
        ]);

        $validator->validate();

        $tag = Tag::create($validator->validated());

        return response()->json([
            'success' => true,
            'data' => $tag,
            'message' => 'Tag created successfully',
        ], 201);
    }

    public function show(int $id)
    {
        $tag = Tag::query()->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $tag,
        ]);
    }

    public function update(Request $request, int $id)
    {
        $tag = Tag::query()->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:tags,slug,' . $id,
            'description' => 'nullable|string',
        ]);

        $validator->validate();

        $tag->update($validator->validated());

        return response()->json([
            'success' => true,
            'data' => $tag,
            'message' => 'Tag updated successfully',
        ]);
    }

    public function destroy(int $id)
    {
        $tag = Tag::query()->findOrFail($id);
        $tag->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tag deleted successfully',
        ]);
    }
}
