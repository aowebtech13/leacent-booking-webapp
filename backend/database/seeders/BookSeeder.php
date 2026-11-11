<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Index authors by slug so books can link to them via author_id.
        $authors = Author::query()->pluck('id', 'slug')->all();

        $authorSlugFor = function (string $authorName) use ($authors): ?int {
            $slug = Str::slug(explode(',', $authorName)[0]);
            return $authors[$slug] ?? null;
        };

        $books = [
            [
                'title' => 'The Art of Programming',
                'slug' => 'the-art-of-programming',
                'description' => 'A comprehensive guide to mastering software development, from fundamentals to advanced patterns.',
                'author' => 'Jane McCode',
                'author_id' => $authorSlugFor('Jane McCode'),
                'publisher' => 'TechPress',
                'language' => 'en',
                'category' => "Men's Clothing",
                'publication_year' => 2023,
                'page_count' => 420,
                'format' => 'pdf',
                'points' => 0,
                'is_premium' => false,
                'is_active' => true,
                'is_featured' => true,
                'read_count' => 0,
                'download_count' => 0,
                'rating' => 4.8,
                'reviews_count' => 12,
                'tags' => ['programming', 'software', 'guide'],
            ],
            [
                'title' => 'Clean Architecture',
                'slug' => 'clean-architecture',
                'description' => 'Master the principles of clean software architecture and design scalable systems.',
                'author' => 'Robert C. Martin',
                'author_id' => $authorSlugFor('Robert C. Martin'),
                'publisher' => 'Prentice Hall',
                'language' => 'en',
                'category' => "Women's Clothing",
                'publication_year' => 2017,
                'page_count' => 432,
                'format' => 'pdf',
                'points' => 50,
                'is_premium' => false,
                'is_active' => true,
                'is_featured' => true,
                'read_count' => 0,
                'download_count' => 0,
                'rating' => 4.7,
                'reviews_count' => 8,
                'tags' => ['architecture', 'software-design', 'patterns'],
            ],
            [
                'title' => 'Refactoring to Patterns',
                'slug' => 'refactoring-to-patterns',
                'description' => 'Learn how to improve existing code using proven design patterns.',
                'author' => 'Joshua Kerievsky',
                'author_id' => $authorSlugFor('Joshua Kerievsky'),
                'publisher' => 'Addison-Wesley',
                'language' => 'en',
                'category' => "Kids' Clothing",
                'publication_year' => 2004,
                'page_count' => 384,
                'format' => 'pdf',
                'points' => 75,
                'is_premium' => false,
                'is_active' => true,
                'is_featured' => false,
                'read_count' => 0,
                'download_count' => 0,
                'rating' => 4.6,
                'reviews_count' => 6,
                'tags' => ['refactoring', 'patterns', 'code-quality'],
            ],
            [
                'title' => 'Domain-Driven Design',
                'slug' => 'domain-driven-design',
                'description' => 'Tackling complexity in the heart of software with strategic design.',
                'author' => 'Eric Evans',
                'author_id' => $authorSlugFor('Eric Evans'),
                'publisher' => 'Addison-Wesley',
                'language' => 'en',
                'category' => 'Accessories',
                'publication_year' => 2003,
                'page_count' => 560,
                'format' => 'pdf',
                'points' => 100,
                'is_premium' => false,
                'is_active' => true,
                'is_featured' => false,
                'read_count' => 0,
                'download_count' => 0,
                'rating' => 4.9,
                'reviews_count' => 15,
                'tags' => ['ddd', 'design', 'software'],
            ],
            [
                'title' => 'Introduction to Algorithms',
                'slug' => 'introduction-to-algorithms',
                'description' => 'The definitive textbook on algorithms and data structures.',
                'author' => 'Thomas H. Cormen',
                'author_id' => $authorSlugFor('Thomas H. Cormen'),
                'publisher' => 'MIT Press',
                'language' => 'en',
                'category' => "Men's Clothing",
                'publication_year' => 2009,
                'page_count' => 1312,
                'format' => 'pdf',
                'points' => 120,
                'is_premium' => false,
                'is_active' => true,
                'is_featured' => false,
                'read_count' => 0,
                'download_count' => 0,
                'rating' => 4.8,
                'reviews_count' => 20,
                'tags' => ['algorithms', 'data-structures', 'computer-science'],
            ],
            [
                'title' => 'The Pragmatic Programmer',
                'slug' => 'the-pragmatic-programmer',
                'description' => 'Your journey to mastery, from journeyman to master programmer.',
                'author' => 'Andrew Hunt, David Thomas',
                'author_id' => $authorSlugFor('Andrew Hunt, David Thomas'),
                'publisher' => 'Addison-Wesley',
                'language' => 'en',
                'category' => "Women's Clothing",
                'publication_year' => 1999,
                'page_count' => 352,
                'format' => 'pdf',
                'points' => 60,
                'is_premium' => false,
                'is_active' => true,
                'is_featured' => false,
                'read_count' => 0,
                'download_count' => 0,
                'rating' => 4.8,
                'reviews_count' => 14,
                'tags' => ['programming', 'career', 'craftsmanship'],
            ],
        ];

        foreach ($books as $book) {
            Book::updateOrCreate(['slug' => $book['slug']], $book);
        }
    }
}
