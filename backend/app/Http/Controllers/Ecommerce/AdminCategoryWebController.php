<?php

namespace App\Http\Controllers\Ecommerce;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AdminCategoryWebController
{
    public function index(Request $request)
    {
        $perPage = (int) $request->get('per_page', 15);

        $query = Category::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->get('search') . '%');
        }

        $categories = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $categories = Category::whereNull('parent_id')->orderBy('order')->get();
        $parent = Category::whereNull('parent_id')->orderBy('order')->get()->pluck('name', 'id')->toArray();

        return view('admin.categories.create', compact('categories', 'parent'));
    }

    public function edit(int $id)
    {
        $cat = Category::query()->findOrFail($id);
        $categories = Category::whereNull('parent_id')->orderBy('order')->get();
        $parent = Category::whereNull('parent_id')->orderBy('order')->get()->pluck('name', 'id')->toArray();

        return view('admin.categories.edit', compact('cat', 'categories', 'parent'));
    }

    public function store(Request $request, CategoryController $categoryController)
    {
        $response = $categoryController->store($request);

        if (method_exists($response, 'getStatusCode') && $response->getStatusCode() >= 400) {
            $data = $response->getData(true);

            return Redirect::back()
                ->withInput()
                ->with('error', $data['message'] ?? 'Failed to create category');
        }

        $categoryData = $response->getData(true);

        return Redirect::to(route('admin.categories.index'))
            ->with('status', $categoryData['message'] ?? 'Category created successfully');
    }

    public function update(Request $request, int $id, CategoryController $categoryController)
    {
        $response = $categoryController->update($request, $id);

        if (method_exists($response, 'getStatusCode') && $response->getStatusCode() >= 400) {
            $data = $response->getData(true);

            return Redirect::back()
                ->withInput()
                ->with('error', $data['message'] ?? 'Failed to update category');
        }

        $categoryData = $response->getData(true);

        return Redirect::to(route('admin.categories.index'))
            ->with('status', $categoryData['message'] ?? 'Category updated successfully');
    }

    public function destroy(int $id, CategoryController $categoryController)
    {
        $response = $categoryController->destroy($id);

        if (method_exists($response, 'getStatusCode') && $response->getStatusCode() >= 400) {
            $data = $response->getData(true);

            return Redirect::to(route('admin.categories.index'))
                ->with('error', $data['message'] ?? 'Failed to delete category');
        }

        $data = $response->getData(true);

        return Redirect::to(route('admin.categories.index'))
            ->with('status', $data['message'] ?? 'Category deleted successfully');
    }

    public function updateOrders(Request $request)
    {
        $orders = $request->input('categories', []);

        foreach ($orders as $order => $item) {
            Category::query()->where('id', $item['id'])->update(['order' => $order]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Category orders updated successfully',
        ]);
    }
}