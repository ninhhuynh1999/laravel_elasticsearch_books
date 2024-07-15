<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        //     'role' => 'admin',
        // ]);
        $this->generateDefaultCategories();

        User::factory(10)->create();
        Category::factory(10)->create();
        Supplier::factory(10)->create();
        Supplier::factory(10)->userUpdated()->create();
        Customer::factory(10)->create();
        Customer::factory(10)->userUpdated()->create();
        Product::factory(10)->create();
    }

    public function generateDefaultCategories()
    {
        $defaultCategories = [
            [
                "title" => "Arts & Photography",
                "description" => "Books on fine arts, photography, painting, sculpture and more."
            ],
            [
                "title" => "Biographies & Memoirs",
                "description" => "Autobiographies, biographies and personal accounts of people's lives and experiences."
            ],
            [
                "title" => "Business & Money",
                "description" => "Books on business, careers, leadership, personal finance and more."
            ],
            [
                "title" => "Calendars",
                "description" => "Planning calendars, agenda books and other scheduling tools."
            ],
            [
                "title" => "Children's Books",
                "description" => "Books for kids of all ages including picture books, chapter books and more."
            ],
            [
                "title" => "Christian Books & Bibles",
                "description" => "Books about Christianity, faith, spirituality and Bibles."
            ],
            [
                "title" => "Comics & Graphic Novels",
                "description" => "Graphic novels, comic books and manga in book format."
            ],
            [
                "title" => "Computers & Technology",
                "description" => "Books about computers, programming, software, gadgets and tech careers."
            ],
            [
                "title" => "Cooking & Food",
                "description" => "Cookbooks, baking books, food memoirs and more."
            ],
            [
                "title" => "Crafts, Hobbies & Home",
                "description" => "Books about crafts, knitting, DIY projects, home improvement and more."
            ],
            [
                "title" => "Education & Teaching",
                "description" => "Resources for teachers and books about various school subjects."
            ],
            [
                "title" => "Fiction & Literature",
                "description" => "Fiction novels from various genres including literary fiction."
            ],
            [
                "title" => "Health, Fitness & Dieting",
                "description" => "Books about health, nutrition, exercise and wellness."
            ],
            [
                "title" => "History",
                "description" => "Books about history, wars, events, time periods and historic figures."
            ],
            [
                "title" => "Humor",
                "description" => "Comedy books, joke books, cartoon collections and more lighthearted reads."
            ],
            [
                "title" => "Law",
                "description" => "Legal references, law guides and books about the legal profession."
            ],
            [
                "title" => "Medical",
                "description" => "Resources for medical professionals and books about health conditions."
            ],
            [
                "title" => "Mystery, Thriller & Suspense",
                "description" => "Mystery, crime, thriller and suspense novels."
            ],
            [
                "title" => "Religion & Spirituality",
                "description" => "Books on world religions, theology, prayer and spiritual growth."
            ],
            [
                "title" => "Romance",
                "description" => "Romance novels featuring love stories, relationships and fiction."
            ],
            [
                "title" => "Science & Math",
                "description" => "Non-fiction books about science, math, astronomy, physics and more."
            ],
            [
                "title" => "Science Fiction & Fantasy",
                "description" => "Sci-fi and fantasy novels featuring imaginary worlds, technology and magic."
            ],
            [
                "title" => "Self-Help",
                "description" => "Books on self-improvement, psychology, success, relationships and motivation."
            ],
            [
                "title" => "Sports & Recreation",
                "description" => "Books about specific sports, outdoor recreation, fitness and athletes."
            ],
            [
                "title" => "Textbooks",
                "description" => "College-level books assigned for coursework across various subjects."
            ],
            [
                "title" => "Travel",
                "description" => "Guidebooks, travel memoirs, photography books and resources for planning trips."
            ]
        ];

        for ($i = 0; $i < count($defaultCategories); $i++) {
            $category = new Category([
                'name' => $defaultCategories[$i]['title'],
                'text' => $defaultCategories[$i]['description'],
            ]);
            $category->save();
        }
    }
}
