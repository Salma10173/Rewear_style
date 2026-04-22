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

        // Sample products
        $products = [
            [
                'category_id' => 1, 'name' => 'Floral Midi Dress',
                'slug' => 'floral-midi-dress', 'price' => 89.99,
                'stock' => 25, 'sizes' => 'XS,S,M,L,XL',
                'colors' => 'Rose,Sky Blue,Ivory', 'is_featured' => true,
                'description' => 'A beautiful floral midi dress perfect for spring and summer outings.',
            ],
            [
                'category_id' => 1, 'name' => 'Black Evening Gown',
                'slug' => 'black-evening-gown', 'price' => 149.99, 'sale_price' => 119.99,
                'stock' => 10, 'sizes' => 'S,M,L',
                'colors' => 'Black', 'is_featured' => true,
                'description' => 'A sleek black evening gown for formal events and special occasions.',
            ],
            [
                'category_id' => 2, 'name' => 'Silk Satin Blouse',
                'slug' => 'silk-satin-blouse', 'price' => 54.99,
                'stock' => 40, 'sizes' => 'XS,S,M,L,XL',
                'colors' => 'Champagne,Dusty Pink,White',
                'description' => 'Luxuriously soft satin blouse that drapes beautifully.',
            ],
            [
                'category_id' => 3, 'name' => 'High-Waist Trousers',
                'slug' => 'high-waist-trousers', 'price' => 69.99,
                'stock' => 30, 'sizes' => 'XS,S,M,L',
                'colors' => 'Camel,Black,Navy', 'is_featured' => true,
                'description' => 'Tailored high-waist trousers with a flattering silhouette.',
            ],
            [
                'category_id' => 4, 'name' => 'Oversized Wool Coat',
                'slug' => 'oversized-wool-coat', 'price' => 199.99, 'sale_price' => 159.99,
                'stock' => 15, 'sizes' => 'S,M,L,XL',
                'colors' => 'Camel,Charcoal', 'is_featured' => true,
                'description' => 'A statement oversized wool coat to elevate any winter look.',
            ],
            [
                'category_id' => 5, 'name' => 'Leather Tote Bag',
                'slug' => 'leather-tote-bag', 'price' => 119.99,
                'stock' => 20, 'sizes' => 'One Size',
                'colors' => 'Tan,Black,Burgundy',
                'description' => 'Spacious genuine leather tote bag with a polished finish.',
            ],
        ];

        foreach ($products as $prod) {
            Product::create($prod);
        }
    }
}
