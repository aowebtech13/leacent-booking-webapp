<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::query()->whereNotNull('id')->get();
        if ($categories->isEmpty()) {
            return;
        }

        $tags = Tag::query()->whereNotNull('id')->get();
        $tagMap = $tags->keyBy(fn ($t) => $t->slug);

        $byCategory = $categories->keyBy(fn ($c) => $c->slug);

        $catalog = [
            // Men's Clothing
            ['name' => 'Classic White Shirt', 'slug' => 'classic-white-shirt', 'sku' => 'MEN-SHIRT-001', 'price' => 12500.00, 'cost_price' => 7500.00, 'category' => 'mens-clothing', 'tags' => ['casual', 'cotton', 'new-arrival'], 'description' => 'A timeless classic white shirt crafted from premium cotton. Perfect for both formal and casual occasions, featuring a comfortable regular fit and durable construction.'],
            ['name' => 'Slim Fit Chinos', 'slug' => 'slim-fit-chinos', 'sku' => 'MEN-CHINO-001', 'price' => 18500.00, 'cost_price' => 11000.00, 'category' => 'mens-clothing', 'tags' => ['casual', 'premium'], 'description' => 'Modern slim fit chinos made from stretch cotton twill. These versatile pants offer a sharp silhouette with all-day comfort, ideal for office or weekend wear.'],
            ['name' => 'Denim Jacket', 'slug' => 'denim-jacket', 'sku' => 'MEN-JACKET-001', 'price' => 35000.00, 'cost_price' => 21000.00, 'category' => 'mens-clothing', 'tags' => ['denim', 'casual', 'premium'], 'description' => 'A classic denim jacket with a contemporary twist. Made from heavyweight cotton denim with a soft wash finish, featuring button closure and multiple pockets.'],
            ['name' => 'Formal Blazer', 'slug' => 'formal-blazer', 'sku' => 'MEN-BLAZER-001', 'price' => 55000.00, 'cost_price' => 33000.00, 'category' => 'mens-clothing', 'tags' => ['formal', 'premium'], 'description' => 'An elegant formal blazer tailored for a refined look. Constructed from premium wool blend fabric with satin lining, perfect for business meetings and special occasions.'],
            ['name' => 'Casual Hoodie', 'slug' => 'casual-hoodie', 'sku' => 'MEN-HOODIE-001', 'price' => 22000.00, 'cost_price' => 13000.00, 'category' => 'mens-clothing', 'tags' => ['casual', 'cotton', 'winter'], 'description' => 'A cozy casual hoodie made from brushed fleece cotton. Features a kangaroo pocket, adjustable drawstring hood, and ribbed cuffs for ultimate comfort.'],

            // Women's Clothing
            ['name' => 'Floral Maxi Dress', 'slug' => 'floral-maxi-dress', 'sku' => 'WOM-DRESS-001', 'price' => 28000.00, 'cost_price' => 16800.00, 'category' => 'womens-clothing', 'tags' => ['summer', 'new-arrival', 'premium'], 'description' => 'A stunning floral maxi dress that flows beautifully with every step. Made from lightweight, breathable fabric with a flattering empire waistline and adjustable straps.'],
            ['name' => 'Elegant Blouse', 'slug' => 'elegant-blouse', 'sku' => 'WOM-BLOUSE-001', 'price' => 15000.00, 'cost_price' => 9000.00, 'category' => 'womens-clothing', 'tags' => ['formal', 'cotton'], 'description' => 'An elegant blouse designed for sophistication. Crafted from soft, breathable cotton with delicate pleating details and a relaxed fit that transitions seamlessly from day to evening.'],
            ['name' => 'High-Waist Jeans', 'slug' => 'high-waist-jeans', 'sku' => 'WOM-JEANS-001', 'price' => 24000.00, 'cost_price' => 14400.00, 'category' => 'womens-clothing', 'tags' => ['denim', 'casual', 'sale'], 'description' => 'Trendy high-waist jeans with a vintage-inspired fit. Made from premium stretch denim that sculpts and supports, featuring a classic five-pocket design.'],
            ['name' => 'Knit Sweater', 'slug' => 'knit-sweater', 'sku' => 'WOM-SWEATER-001', 'price' => 20000.00, 'cost_price' => 12000.00, 'category' => 'womens-clothing', 'tags' => ['winter', 'cotton', 'casual'], 'description' => 'A luxuriously soft knit sweater perfect for cooler days. Features a relaxed fit, ribbed trim, and a cozy crew neckline in a versatile neutral tone.'],
            ['name' => 'Summer Midi Skirt', 'slug' => 'summer-midi-skirt', 'sku' => 'WOM-SKIRT-001', 'price' => 18000.00, 'cost_price' => 10800.00, 'category' => 'womens-clothing', 'tags' => ['summer', 'new-arrival'], 'description' => 'A breezy summer midi skirt with a flattering A-line silhouette. Made from flowy, lightweight fabric that moves gracefully, perfect for sunny days and beach outings.'],

            // Kids' Clothing
            ['name' => 'Boys Graphic T-Shirt', 'slug' => 'boys-graphic-tshirt', 'sku' => 'KID-TSHIRT-001', 'price' => 8500.00, 'cost_price' => 5100.00, 'category' => 'kids-clothing', 'tags' => ['casual', 'cotton', 'new-arrival'], 'description' => 'A fun and comfortable graphic t-shirt for boys. Made from 100% soft cotton with a playful print, designed for active kids who love to express their style.'],
            ['name' => 'Girls Party Dress', 'slug' => 'girls-party-dress', 'sku' => 'KID-DRESS-001', 'price' => 16000.00, 'cost_price' => 9600.00, 'category' => 'kids-clothing', 'tags' => ['formal', 'premium', 'sale'], 'description' => 'A magical party dress that makes every little girl feel special. Features a tulle overlay, satin bow detail, and a comfortable lined bodice for all-day wear.'],
            ['name' => 'Kids Denim Overalls', 'slug' => 'kids-denim-overalls', 'sku' => 'KID-OVERALL-001', 'price' => 14000.00, 'cost_price' => 8400.00, 'category' => 'kids-clothing', 'tags' => ['denim', 'casual'], 'description' => 'Durable and stylish denim overalls for kids. Features adjustable shoulder straps, a fun pocket detail, and reinforced knees for playground-ready durability.'],
            ['name' => 'Winter Jacket for Kids', 'slug' => 'winter-jacket-kids', 'sku' => 'KID-JACKET-001', 'price' => 25000.00, 'cost_price' => 15000.00, 'category' => 'kids-clothing', 'tags' => ['winter', 'premium'], 'description' => 'A warm and waterproof winter jacket designed for kids. Features a cozy fleece lining, adjustable hood, and reflective details for safety during dark winter days.'],
            ['name' => 'Kids Cotton Shorts', 'slug' => 'kids-cotton-shorts', 'sku' => 'KID-SHORTS-001', 'price' => 7500.00, 'cost_price' => 4500.00, 'category' => 'kids-clothing', 'tags' => ['summer', 'cotton', 'sale'], 'description' => 'Lightweight and breathable cotton shorts for kids. Features an elastic waistband for easy on-and-off, perfect for playground adventures and sunny summer days.'],

            // Accessories
            ['name' => 'Leather Belt', 'slug' => 'leather-belt', 'sku' => 'ACC-BELT-001', 'price' => 12000.00, 'cost_price' => 7200.00, 'category' => 'accessories', 'tags' => ['premium', 'formal'], 'description' => 'A premium leather belt with a polished metal buckle. Crafted from full-grain leather that develops a beautiful patina over time, a timeless accessory for any wardrobe.'],
            ['name' => 'Silk Scarf', 'slug' => 'silk-scarf', 'sku' => 'ACC-SCARF-001', 'price' => 18000.00, 'cost_price' => 10800.00, 'category' => 'accessories', 'tags' => ['premium', 'winter', 'new-arrival'], 'description' => 'An luxurious silk scarf with an elegant print. Made from 100% pure silk with hand-rolled edges, adding a touch of sophistication to any outfit.'],
            ['name' => 'Canvas Backpack', 'slug' => 'canvas-backpack', 'sku' => 'ACC-BAG-001', 'price' => 22000.00, 'cost_price' => 13200.00, 'category' => 'accessories', 'tags' => ['casual', 'cotton', 'limited-edition'], 'description' => 'A rugged canvas backpack built for everyday adventures. Features a padded laptop compartment, multiple organizer pockets, and adjustable padded straps for comfort.'],
            ['name' => 'Aviator Sunglasses', 'slug' => 'aviator-sunglasses', 'sku' => 'ACC-SUN-001', 'price' => 15000.00, 'cost_price' => 9000.00, 'category' => 'accessories', 'tags' => ['summer', 'sale'], 'description' => 'Classic aviator sunglasses with UV400 protection. Features a lightweight metal frame and gradient lenses that provide both style and eye protection.'],
            ['name' => 'Wool Beanie', 'slug' => 'wool-beanie', 'sku' => 'ACC-BEANIE-001', 'price' => 9000.00, 'cost_price' => 5400.00, 'category' => 'accessories', 'tags' => ['winter', 'casual'], 'description' => 'A soft and warm wool beanie for cold weather. Made from merino wool blend that regulates temperature, with a stretchy fit that suits most head sizes.'],

            // Footwear
            ['name' => 'Leather Oxford Shoes', 'slug' => 'leather-oxford-shoes', 'sku' => 'FOOT-OXFORD-001', 'price' => 45000.00, 'cost_price' => 27000.00, 'category' => 'footwear', 'tags' => ['formal', 'premium', 'new-arrival'], 'description' => 'Handcrafted leather Oxford shoes with a classic brogue design. Features a Goodyear welted sole for durability and a leather-lined interior for all-day comfort.'],
            ['name' => 'White Sneakers', 'slug' => 'white-sneakers', 'sku' => 'FOOT-SNEAKER-001', 'price' => 32000.00, 'cost_price' => 19200.00, 'category' => 'footwear', 'tags' => ['casual', 'sale'], 'description' => 'Clean and minimalist white sneakers that go with everything. Made from premium leather with a cushioned insole and durable rubber outsole for everyday wear.'],
            ['name' => 'Ankle Boots', 'slug' => 'ankle-boots', 'sku' => 'FOOT-BOOT-001', 'price' => 38000.00, 'cost_price' => 22800.00, 'category' => 'footwear', 'tags' => ['winter', 'formal', 'premium'], 'description' => 'Stylish ankle boots with a sleek pointed toe. Crafted from premium suede with a comfortable block heel, perfect for elevating any autumn or winter outfit.'],
            ['name' => 'Canvas Slip-Ons', 'slug' => 'canvas-slip-ons', 'sku' => 'FOOT-SLIPON-001', 'price' => 16000.00, 'cost_price' => 9600.00, 'category' => 'footwear', 'tags' => ['casual', 'summer', 'cotton'], 'description' => 'Effortless canvas slip-on shoes for casual days. Features a flexible rubber sole and breathable canvas upper, ideal for travel, beach trips, or lazy weekends.'],
            ['name' => 'Running Shoes', 'slug' => 'running-shoes', 'sku' => 'FOOT-RUN-001', 'price' => 28000.00, 'cost_price' => 16800.00, 'category' => 'footwear', 'tags' => ['casual', 'new-arrival', 'limited-edition'], 'description' => 'High-performance running shoes with responsive cushioning. Features a breathable mesh upper, supportive midsole, and grippy outsole for a smooth ride on any surface.'],

        ];

        foreach ($catalog as $idx => $p) {
            $cat = $byCategory->get($p['category']);
            if (!$cat) {
                continue;
            }

            $slug = $p['slug'] ?: Str::slug($p['name']);
            $salePrice = (float) ($p['sale_price'] ?? $p['price']);
            $costPrice = (float) $p['cost_price'];

            $productData = [
                'category_id' => $cat->id,
                'name' => $p['name'],
                'slug' => $slug,
                'description' => $p['description'] ?? 'Quality product crafted with care.',
                'sku' => $p['sku'],
                'price' => (float) ($p['price'] ?? $salePrice),
                'cost_price' => $costPrice,
                'sale_price' => $salePrice,
                'stock' => $p['stock'] ?? 100,
                'low_stock_threshold' => 10,
                'is_active' => $p['is_active'] ?? true,
            ];

            // Add storefront fields if provided
            if (isset($p['size'])) {
                $productData['size'] = $p['size'];
            }
            if (isset($p['color'])) {
                $productData['color'] = $p['color'];
            }
            if (isset($p['product_type'])) {
                $productData['product_type'] = $p['product_type'];
            }
            if (isset($p['brand'])) {
                $productData['brand'] = $p['brand'];
            }
            if (isset($p['reviews_count'])) {
                $productData['reviews_count'] = $p['reviews_count'];
            }
            if (isset($p['sold_count'])) {
                $productData['sold_count'] = $p['sold_count'];
            }
            if (isset($p['is_bestseller'])) {
                $productData['is_bestseller'] = $p['is_bestseller'];
            }
            if (isset($p['is_featured'])) {
                $productData['is_featured'] = $p['is_featured'];
            }

            $product = Product::firstOrCreate(
                ['sku' => $p['sku']],
                $productData
            );

            // Attach tags
            if (!empty($p['tags'])) {
                $tagIds = [];
                foreach ($p['tags'] as $tagSlug) {
                    if ($tagMap->has($tagSlug)) {
                        $tagIds[] = $tagMap->get($tagSlug)->id;
                    }
                }
                if (!empty($tagIds)) {
                    $product->tags()->sync($tagIds);
                }
            }
        }

        // Backfill missing sale_price values for any existing products.
        Product::query()
            ->where(function ($q) {
                $q->whereNull('sale_price')->orWhere('sale_price', 0);
            })
            ->update(['sale_price' => Product::raw('COALESCE(sale_price, price)')]);
    }
}
