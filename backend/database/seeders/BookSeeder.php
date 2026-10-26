<?php
namespace Database\Seeders;
use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            ['title'=>'The Great Gatsby','author'=>'F. Scott Fitzgerald','description'=>'A classic American novel.','category'=>'Fiction','format'=>'epub','page_count'=>180,'is_premium'=>false,'is_active'=>true,'is_featured'=>true],
            ['title'=>'1984','author'=>'George Orwell','description'=>'Dystopian novel.','category'=>'Fiction','format'=>'pdf','page_count'=>328,'is_premium'=>true,'is_active'=>true,'is_featured'=>true],
            ['title'=>'Clean Code','author'=>'Robert C. Martin','description'=>'Software craftsmanship.','category'=>'Technology','format'=>'pdf','page_count'=>464,'is_premium'=>false,'is_active'=>true,'is_featured'=>false],
            ['title'=>'Atomic Habits','author'=>'James Clear','description'=>'Build good habits.','category'=>'Self-Help','format'=>'epub','page_count'=>320,'is_premium'=>false,'is_active'=>true,'is_featured'=>true],
            ['title'=>'Sapiens','author'=>'Yuval Noah Harari','description'=>'Brief history of humankind.','category'=>'History','format'=>'mobi','page_count'=>443,'is_premium'=>true,'is_active'=>true,'is_featured'=>false],
            ['title'=>'The Pragmatic Programmer','author'=>'Andrew Hunt','description'=>'Programming best practices.','category'=>'Technology','format'=>'pdf','page_count'=>352,'is_premium'=>false,'is_active'=>true,'is_featured'=>false],
        ];
        foreach ($books as $b) {
            Book::create(array_merge($b, ['slug'=>\Illuminate\Support\Str::slug($b['title'])]));
        }
    }
}
