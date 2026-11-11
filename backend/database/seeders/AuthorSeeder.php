<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $authors = [
            [
                'name' => 'Jane McCode',
                'slug' => 'jane-mccode',
                'bio' => 'Software engineer and technical author passionate about teaching programming fundamentals.',
                'email' => 'jane.mccode@example.com',
                'website' => 'https://janemccode.example.com',
                'is_active' => true,
            ],
            [
                'name' => 'Robert C. Martin',
                'slug' => 'robert-c-martin',
                'bio' => 'Affectionately known as "Uncle Bob", author of Clean Code and Clean Architecture.',
                'email' => 'unclebob@example.com',
                'website' => 'https://cleancoder.example.com',
                'is_active' => true,
            ],
            [
                'name' => 'Joshua Kerievsky',
                'slug' => 'joshua-kerievsky',
                'bio' => 'Industrial Logic founder and author of Refactoring to Patterns.',
                'email' => 'joshua@example.com',
                'website' => 'https://industriallogic.example.com',
                'is_active' => true,
            ],
            [
                'name' => 'Eric Evans',
                'slug' => 'eric-evans',
                'bio' => 'Domain language expert and author of Domain-Driven Design.',
                'email' => 'eric.evans@example.com',
                'website' => 'https://domainlanguage.example.com',
                'is_active' => true,
            ],
            [
                'name' => 'Thomas H. Cormen',
                'slug' => 'thomas-h-cormen',
                'bio' => 'Professor of computer science and co-author of Introduction to Algorithms.',
                'email' => 'thomas.cormen@example.com',
                'website' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Andrew Hunt',
                'slug' => 'andrew-hunt',
                'bio' => 'Pragmatic programmer and co-author of The Pragmatic Programmer.',
                'email' => 'andrew.hunt@example.com',
                'website' => 'https://pragprog.example.com',
                'is_active' => true,
            ],
            [
                'name' => 'David Thomas',
                'slug' => 'david-thomas',
                'bio' => 'Pragmatic programmer and co-author of The Pragmatic Programmer.',
                'email' => 'dave.thomas@example.com',
                'website' => 'https://pragprog.example.com',
                'is_active' => true,
            ],
        ];

        foreach ($authors as $author) {
            Author::updateOrCreate(['slug' => $author['slug']], $author);
        }
    }
}
