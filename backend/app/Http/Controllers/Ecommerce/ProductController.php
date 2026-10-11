<?php

namespace App\Http\Controllers\Ecommerce;

use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Arr;

class ProductController
{
    public function index(Request $request)
    {
        $perPage = (int) $request->get('per_page', 15);

        // Build eager load array conditionally to avoid errors if tables are missing
        $with = ['category', 'categories', 'images', 'videos'];
        if (Schema::hasTable('tags') && Schema::hasTable('product_tag')) {
            $with[] = 'tags';
        }

        $query = Product::query()->with($with)
            ->where('is_active', true);


        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->get('search') . '%')
                    ->orWhere('slug', 'like', '%' . $request->get('search') . '%');
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', (int) $request->get('category_id'));
        }

        if ($request->filled('tag_id')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('tags.id', (int) $request->get('tag_id'));
            });
        }

        $products = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $products,
        ]);
    }

    // GET /api/products/total
    // Returns the total number of products in the system.
    public function total()
    {
        $total = Product::count();

        return response()->json([
            'success' => true,
            'data' => [
                'total' => $total,
            ],
        ]);
    }

    public function show(int $id)
    {
        $with = ['category', 'categories', 'images', 'videos'];
        if (Schema::hasTable('tags') && Schema::hasTable('product_tag')) {
            $with[] = 'tags';
        }

        $product = Product::query()->with($with)->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $product,
        ]);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'integer|exists:categories,id',

            'category_id' => 'nullable|integer|exists:categories,id',

            'tag_ids' => 'nullable|array',
            'tag_ids.*' => 'integer|exists:tags,id',

            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug',
            'description' => 'nullable|string',

            'sku' => 'required|string|max:255|unique:products,sku',
            'cost_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',

            // quantity is alias for stock
            'quantity' => 'required|integer|min:0',
            'low_stock_threshold' => 'nullable|integer|min:0',

            'is_active' => 'sometimes|boolean',

            'video_links' => 'nullable|string',

            'images' => 'nullable|array',
        ]);


        $validator->validate();

        $data = $validator->validated();
        $data['is_active'] = $data['is_active'] ?? true;

        // quantity is alias for stock
        $data['stock'] = $data['quantity'];
        unset($data['quantity']);

        // price is the regular/original price; sale_price is the discounted price
        // Do NOT overwrite price with sale_price — preserve the original price
        if (!isset($data['price']) || $data['price'] == 0) {
            $data['price'] = $data['sale_price'];
        }

        $product = Product::create($data);

        // Categories (multi-select) - only sync if category_ids is present
        if ($request->has('category_ids')) {
            $categoryIds = $request->input('category_ids', []);
            if (is_array($categoryIds) && count($categoryIds) > 0) {
                $product->categories()->sync($categoryIds);
            }
        }

        // Tags (multi-select) - only sync if tag_ids is present
        if ($request->has('tag_ids')) {
            $tagIds = $request->input('tag_ids', []);
            if (Schema::hasTable('product_tag') && is_array($tagIds) && count($tagIds) > 0) {
                $product->tags()->sync($tagIds);
            }
        }

        // Images
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            $sort = 0;
            foreach ($images as $file) {
                if (! $file) {
                    continue;
                }

                $path = $file->store('product_images', 'public');

                $product->images()->create([
                    'image_path' => $path,
                    'sort_order' => $sort,
                ]);
                $sort++;
            }
        }

        // Video links (textarea with one URL per line)
        $videoLinks = $request->input('video_links', '');
        if (is_string($videoLinks) && trim($videoLinks) !== '') {
            $urls = array_filter(array_map('trim', explode("\n", $videoLinks)));
            $sort = 0;
            foreach ($urls as $url) {
                $product->videos()->create([
                    'video_url' => $url,
                    'sort_order' => $sort,
                ]);
                $sort++;
            }
        }

        $load = ['category', 'categories', 'images', 'videos'];
        if (Schema::hasTable('tags') && Schema::hasTable('product_tag')) {
            $load[] = 'tags';
        }

        return response()->json([
            'success' => true,
            'data' => $product->load($load),
            'message' => 'Product created successfully',
        ], 201);

    }

    public function update(Request $request, int $id)
    {
        $product = Product::query()->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'integer|exists:categories,id',

            'category_id' => 'nullable|integer|exists:categories,id',

            'tag_ids' => 'nullable|array',
            'tag_ids.*' => 'integer|exists:tags,id',

            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug,' . $id,
            'description' => 'nullable|string',

            'sku' => 'required|string|max:255|unique:products,sku,' . $id,
            'cost_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',

            'quantity' => 'required|integer|min:0',
            'low_stock_threshold' => 'nullable|integer|min:0',

            'is_active' => 'sometimes|boolean',

            'video_links' => 'nullable|string',

            'images' => 'nullable|array',
        ]);


        $validator->validate();

        $data = $validator->validated();
        if (! array_key_exists('is_active', $data)) {
            $data['is_active'] = $product->is_active;
        }

        // quantity is alias for stock
        $data['stock'] = $data['quantity'];
        unset($data['quantity']);

        // price is the regular/original price; sale_price is the discounted price
        // Do NOT overwrite price with sale_price — preserve the original price
        if (!isset($data['price']) || $data['price'] == 0) {
            $data['price'] = $data['sale_price'];
        }

        $product->update($data);

        // Categories - only sync if category_ids is present in request (partial save safety)
        if ($request->has('category_ids')) {
            $categoryIds = $request->input('category_ids', []);
            if (is_array($categoryIds)) {
                $product->categories()->sync($categoryIds);
            }
        }

        // Tags - only sync if tag_ids is present in request (partial save safety)
        if ($request->has('tag_ids')) {
            $tagIds = $request->input('tag_ids', []);
            if (Schema::hasTable('product_tag') && is_array($tagIds)) {
                $product->tags()->sync($tagIds);
            }
        }

        // Handle image removal
        $imagesToRemove = $request->input('images_to_remove', []);
        if (!empty($imagesToRemove)) {
            $product->images()->whereIn('id', $imagesToRemove)->delete();
        }

        // Add new images if provided
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            $sort = $product->images()->max('sort_order') ?? -1;
            foreach ($images as $file) {
                if (! $file) {
                    continue;
                }

                $path = $file->store('product_images', 'public');
                $sort++;

                $product->images()->create([
                    'image_path' => $path,
                    'sort_order' => $sort,
                ]);
            }
        }

        // Video links: replace all if provided (textarea with one URL per line)
        if ($request->has('video_links')) {
            $product->videos()->delete();

            $videoLinks = $request->input('video_links', '');
            if (is_string($videoLinks) && trim($videoLinks) !== '') {
                $urls = array_filter(array_map('trim', explode("\n", $videoLinks)));
                $sort = 0;
                foreach ($urls as $url) {
                    $product->videos()->create([
                        'video_url' => $url,
                        'sort_order' => $sort,
                    ]);
                    $sort++;
                }
            }
        }

        $load = ['category', 'categories', 'images', 'videos'];
        if (Schema::hasTable('tags') && Schema::hasTable('product_tag')) {
            $load[] = 'tags';
        }

        return response()->json([
            'success' => true,
            'data' => $product->load($load),
            'message' => 'Product updated successfully',
        ]);

    }

    // Returns products related by shared categories and tags.
    // GET /api/products/{id}/related
    public function related(Request $request, int $id)
    {
        $with = ['category', 'categories'];
        if (Schema::hasTable('tags') && Schema::hasTable('product_tag')) {
            $with[] = 'tags';
        }

        $product = Product::query()->with($with)->findOrFail($id);

        $categoryIds = collect([]);
        if ($product->category_id) {
            $categoryIds->push((int) $product->category_id);
        }

        if ($product->categories && $product->categories->count() > 0) {
            $categoryIds = $categoryIds->merge($product->categories->pluck('id'));
        }

        $categoryIds = $categoryIds->unique()->values();

        $tagIds = collect([]);
        if (Schema::hasTable('tags') && Schema::hasTable('product_tag') && $product->tags && $product->tags->count() > 0) {
            $tagIds = $tagIds->merge($product->tags->pluck('id'));
        }

        $tagIds = $tagIds->unique()->values();

        $limit = (int) $request->get('limit', 12);

        $with = ['category', 'categories', 'images', 'videos'];
        if (Schema::hasTable('tags') && Schema::hasTable('product_tag')) {
            $with[] = 'tags';
        }

        $related = Product::query()
            ->with($with)
            ->where('is_active', true)
            ->where('id', '!=', $id)
            ->where(function ($q) use ($categoryIds, $tagIds) {
                $q->where(function ($qc) use ($categoryIds) {
                    if ($categoryIds->isNotEmpty()) {
                        $qc->whereIn('category_id', $categoryIds)
                            ->orWhereHas('categories', function ($qcc) use ($categoryIds) {
                                $qcc->whereIn('categories.id', $categoryIds);
                            });
                    }
                })
                ->orWhere(function ($qt) use ($tagIds) {
                    if ($tagIds->isNotEmpty()) {
                        $qt->whereHas('tags', function ($qtt) use ($tagIds) {
                            $qtt->whereIn('tags.id', $tagIds);
                        });
                    }
                });
            })
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $related,
        ]);
    }

    public function destroy(int $id)
    {
        $product = Product::query()->findOrFail($id);

        // Clean up related records to satisfy foreign key constraints
        $product->cartItems()->delete();
        $product->images()->delete();
        $product->videos()->delete();
        $product->categories()->detach();
        if (Schema::hasTable('product_tag')) {
            $product->tags()->detach();
        }
        $product->orderItems()->delete();

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully',
        ]);
    }

}

