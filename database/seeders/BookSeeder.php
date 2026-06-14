<?php
namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            ['title' => 'Cooking Made Easy',          'author' => 'Molly Black',  'price' => 15.99, 'category' => 'bestseller',  'rating' => 4.5, 'stock' => 50,  'image' => 'Cooking Made Easy.png',          'description' => 'A simple guide to mastering everyday cooking.'],
            ['title' => 'Mystery of the Lost Island', 'author' => 'Jane Smith',   'price' => 14.99, 'category' => 'bestseller',  'rating' => 4.5, 'stock' => 60,  'image' => 'Mystery of the Lost Island.png', 'description' => 'A gripping mystery set on a remote island.'],
            ['title' => 'Shadows of Doubt',           'author' => 'Peter Parker', 'price' => 16.99, 'category' => 'bestseller',  'rating' => 4.5, 'stock' => 40,  'image' => 'Shadows of Doubt.png',           'description' => 'A psychological thriller till the last page.'],
            ['title' => 'Taste of Italy',             'author' => 'Gia Rossi',    'price' => 15.75, 'category' => 'new_release', 'rating' => 4.0, 'stock' => 70,  'image' => 'Taste of Italy.png',             'description' => 'Authentic Italian recipes to bring home.'],
            ['title' => 'The Lost Expedition',        'author' => 'Samwise',      'price' => 16.20, 'category' => 'new_release', 'rating' => 4.5, 'stock' => 45,  'image' => 'The Lost Expedition.png',        'description' => 'An adventurer\'s quest in the Amazon jungle.'],
            ['title' => 'Learning React',             'author' => 'Adele',        'price' => 20.99, 'category' => 'new_release', 'rating' => 5.0, 'stock' => 30,  'image' => 'Learning React.png',             'description' => 'A comprehensive guide to mastering React.'],
            ['title' => 'The Silent Forest',          'author' => 'Adele',        'price' => 12.50, 'category' => 'top_rated',   'rating' => 3.0, 'stock' => 55,  'image' => 'The Silent Forest.png',          'description' => 'A chilling story set in a haunted woodland.'],
            ['title' => 'Shadows of Doubt',           'author' => 'Peter Parker', 'price' => 18.25, 'category' => 'popular',     'rating' => 4.5, 'stock' => 35,  'image' => 'Shadows of Doubt.png',           'description' => 'Award-winning fiction about truth and lies.'],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }

        Book::factory(10)->create();
    }
}