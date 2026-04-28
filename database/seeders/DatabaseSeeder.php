<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@rewear.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        // Regular user
        User::create([
            'name'     => 'Jane Doe',
            'email'    => 'user@rewear.com',
            'password' => Hash::make('password'),
            'role'     => 'user',
            'phone'    => '+212 600 000001',
            'address'  => '12 Rue Hassan II, Casablanca',
        ]);

        // Categories
        $categories = [
            ['name' => 'Dresses',    'slug' => 'dresses',    'description' => 'Elegant and casual dresses for every occasion.'],
            ['name' => 'Tops',       'slug' => 'tops',       'description' => 'Blouses, shirts, and casual tops.'],
            ['name' => 'Pants',      'slug' => 'pants',      'description' => 'Trousers, jeans, and formal pants.'],
            ['name' => 'Outerwear',  'slug' => 'outerwear',  'description' => 'Coats, jackets, and cardigans.'],
            ['name' => 'Accessories','slug' => 'accessories','description' => 'Bags, scarves, belts, and more.'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}
