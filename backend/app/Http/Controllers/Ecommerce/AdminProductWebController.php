<?php

namespace App\Http\Controllers\Ecommerce;

use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AdminProductWebController
{
    public function create(Request $request)
    {
        $categories = Category::query()->orderBy('name')->get();
        $tags = Tag::query()->orderBy('name')->get();

        return view('ecommerce.products.add_products', [
            'categories' => $categories,
            'tags' => $tags,
        ]);
    }

    public function index(Request $request)
    {
        $query = Product::query()->orderBy('created_at', 'desc');

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('sku', 'like', '%' . $search . '%')
                    ->orWhere('slug', 'like', '%' . $search . '%');
            });
        }

        $products = $query->paginate((int) $request->get('per_page', 15));

        return view('ecommerce.products.list_products', [
            'products' => $products,
        ]);
    }

    public function grid(Request $request)
    {
        $query = Product::query()->orderBy('created_at', 'desc');

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('sku', 'like', '%' . $search . '%')
                    ->orWhere('slug', 'like', '%' . $search . '%');
            });
        }

        $products = $query->paginate((int) $request->get('per_page', 12));

        return view('ecommerce.products.products_grid', [
            'products' => $products,
        ]);
    }

    public function details(int $id = null)
    {
        if ($id === null) {
            return redirect()->route('admin.products_grid');
        }

        $product = Product::query()
            ->with(['images', 'categories', 'tags'])
            ->findOrFail($id);

        return view('ecommerce.products.products_details', [
            'product' => $product,
        ]);
    }

    public function edit(int $id)
    {
        $categories = Category::query()->orderBy('name')->get();
        $tags = Tag::query()->orderBy('name')->get();

        $product = Product::query()
            ->with(['categories', 'tags', 'images', 'videos'])
            ->findOrFail($id);

        return view('ecommerce.products.add_products', [
            'product' => $product,
            'categories' => $categories,
            'tags' => $tags,
        ]);
    }

    public function store(Request $request, ProductController $productController)
    {
        // Reuse existing API-ish store() logic.
        // It returns JSON; we map errors to session flash for Blade UX.
        $response = $productController->store($request);

        if ($request->ajax() || $request->wantsJson()) {
            return $response;
        }

        if (method_exists($response, 'getStatusCode') && $response->getStatusCode() >= 400) {
            $data = $response->getData(true);

            return Redirect::back()
                ->withInput()
                ->with('error', $data['message'] ?? 'Failed to create product');
        }

        $productData = $response->getData(true);

        return Redirect::to(route('admin.products_grid'))
            ->with('status', $productData['message'] ?? 'Product created successfully');
    }

    public function update(Request $request, int $id, ProductController $productController)
    {
        $response = $productController->update($request, $id);

        if ($request->ajax() || $request->wantsJson()) {
            return $response;
        }

        if (method_exists($response, 'getStatusCode') && $response->getStatusCode() >= 400) {
            $data = $response->getData(true);

            return Redirect::back()
                ->withInput()
                ->with('error', $data['message'] ?? 'Failed to update product');
        }

        $productData = $response->getData(true);

        return Redirect::to(route('admin.products_grid'))
            ->with('status', $productData['message'] ?? 'Product updated successfully');
    }

    public function destroy(int $id, ProductController $productController, Request $request)
    {
        $response = $productController->destroy($id);

        if (method_exists($response, 'getStatusCode') && $response->getStatusCode() >= 400) {
            $data = $response->getData(true);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $data['message'] ?? 'Failed to delete product',
                ], 400);
            }

            return Redirect::to(route('admin.products.index'))
                ->with('error', $data['message'] ?? 'Failed to delete product');
        }

        $data = $response->getData(true);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $data['message'] ?? 'Product deleted successfully',
            ]);
        }

        return Redirect::to(route('admin.products.index'))
            ->with('status', $data['message'] ?? 'Product deleted successfully');
    }
}







