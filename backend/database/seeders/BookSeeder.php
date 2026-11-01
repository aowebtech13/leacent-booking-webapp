<?php
namespace Database\Seeders;
use App\Models\Book;
use Illuminate\Database\Seeders\Seeders;

class BookSeeder extends Seeders
{
    public function run(): void
    {
        $books = [
            ['title'=>'The Great Gatsby','author'=>'F. Scott Fitzgerald','description'=>'A classic American novel.','category'=>'Fiction','format'=>'epub','page_count'=>180,'is_premium'=>false,'points'=>0,'is_active'=>true,'is_featured'=>true],
            ['title'=>'1984','author'=>'George Orwell','description'=>'Dystopian novel.','category'=>'Fiction','format'=>'pdf','page_count'=>328,'is_premium'=>true,'points'=>5,'is_active'=>true,'is_featured'=>true],
            ['title'=>'Clean Code','author'=>'Robert C. Martin','description'=>'Software craftsmanship.','category'=>'Technology','format'=>'pdf','page_count'=>464,'is_premium'=>false,'points'=>0,'is_active'=>true,'is_featured'=>false],
            ['title'=>'Atomic Habits','author'=>'James Clear','description'=>'Build good habits.','category'=>'Self-Help','format'=>'epub','page_count'=>320,'is_premium'=>false,'points'=>0,'is_active'=>true,'is_featured'=>true],
            ['title'=>'Sapiens','author'=>'Yuval Noah Harari','description'=>'Brief history of humankind.','category'=>'History','format'=>'mobi','page_count'=>443,'is_premium'=>true,'points'=>8,'is_active'=>true,'is_featured'=>false],
            ['title'=>'The Pragmatic Programmer','author'=>'Andrew Hunt','description'=>'Programming best practices.','category'=>'Technology','format'=>'pdf','page_count'=>352,'is_premium'=>false,'points'=>0,'is_active'=>true,'is_featured'=>false],
            ['title'=>'To Kill a Mockingbird','author'=>'Harper Lee','description'=>'A novel of racial injustice.','category'=>'Fiction','format'=>'epub','page_count'=>281,'is_premium'=>true,'points'=>6,'is_active'=>true,'is_featured'=>true],
            ['title'=>'The Hobbit','author'=>'J.R.R. Tolkien','description'=>'A fantasy adventure.','category'=>'Fantasy','format'=>'epub','page_count'=>310,'is_premium'=>true,'points'=>7,'is_active'=>true,'is_featured'=>false],
            ['title'=>'Brief History of Time','author'=>'Stephen Hawking','description'=>'A short history of the universe.','category'=>'Science','format'=>'pdf','page_count'=>212,'is_premium'=>true,'points'=>5,'is_active'=>true,'is_featured'=>false],
            ['title'=>'The Lean Startup','author'=>'Eric Ries','description'=>'How today’s entrepreneurs use continuous innovation.','category'=>'Business','format'=>'epub','page_count'=>336,'is_premium'=>false,'points'=>0,'is_active'=>true,'is_featured'=>false],
            ['title'=>'Deep Work','author'=>'Cal Newport','description'=>'Focus on deep cognitive work.','category'=>'Self-Help','format'=>'epub','page_count'=>296,'is_premium'=>false,'points'=>0,'is_active'=>true,'is_featured'=>false],
            ['title'=>'Dune','author'=>'Frank Herbert','description'=>'Epic science fiction.','category'=>'Sci-Fi','format'=>'mobi','page_count'=>412,'is_premium'=>true,'points'=>9,'is_active'=>true,'is_featured'=>true],
            ['title'=>'The Alchemist','author'=>'Paulo Coelho','description'=>'A tale following your dreams.','category'=>'Fiction','format'=>'epub','page_count'=>208,'is_premium'=>false,'points'=>0,'is_active'=>true,'is_featured'=>false],
            ['title'=>'Design Patterns','author'=>'Erich Gamma','description'=>'Elements of reusable object-oriented software.','category'=>'Technology','format'=>'pdf','page_count'=>395,'is_premium'=>true,'points'=>6,'is_active'=>true,'is_featured'=>false],
            ['title'=>'The 7 Habits of Highly Effective People','author'=>'Stephen Covey','description'=>'Powerful lessons in personal change.','category'=>'Self-Help','format'=>'epub','page_count'=>384,'is_premium'=>false,'points'=>0,'is_active'=>true,'is_featured'=>false],
            ['title'=>'Brave New World','author'=>'Aldous Huxley','description'=>'A dystopian social science fiction novel.','category'=>'Fiction','format'=>'pdf','page_count'=>268,'is_premium'=>true,'points'=>5,'is_active'=>true,'is_featured'=>false],
            ['title'=>'The Art of War','author'=>'Sun Tzu','description'=>'Ancient treatise on strategy.','category'=>'History','format'=>'epub','page_count'=>272,'is_premium'=>false,'points'=>0,'is_active'=>true,'is_featured'=>false],
            ['title'=>'Thinking, Fast and Slow','author'=>'Daniel Kahneman','description'=>'The mind’s two systems that drive the way we think.','category'=>'Psychology','format'=>'epub','page_count'=>499,'is_premium'=>false,'points'=>0,'is_active'=>true,'is_featured'=>false],
            ['title'=>'Project Hail Mary','author'=>'Andy Weir','description'=>'A lone astronaut must save the earth.','category'=>'Sci-Fi','format'=>'mobi','page_count'=>496,'is_premium'=>true,'points'=>8,'is_active'=>true,'is_featured'=>true],
            ['title'=>'The Power of Now','author'=>'Eckhart Tolle','description'=>'A guide to spiritual enlightenment.','category'=>'Self-Help','format'=>'epub','page_count'=>240,'is_premium'=>false,'points'=>0,'is_active'=>true,'is_featured'=>false],
        ];

        foreach ($books as $b) {
            Book::create(array_merge($b, ['slug' => \Illuminate\Support\Str::slug($b['title'])]));
        }
    }
}