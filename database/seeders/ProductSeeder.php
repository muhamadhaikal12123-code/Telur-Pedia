<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            ['name' => 'Telur Ayam Negeri', 'price' => 28000, 'stock' => 150, 'description' => 'Grade A, fresh from farm', 'category' => 'Ayam', 'badge' => 'Best Seller'],
            ['name' => 'Telur Ayam Kampung', 'price' => 35000, 'stock' => 75, 'description' => 'Organik, premium quality', 'category' => 'Ayam', 'badge' => 'Organik'],
            ['name' => 'Telur Puyuh', 'price' => 38000, 'stock' => 60, 'description' => 'Mini, gurih, kaya protein', 'category' => 'Puyuh', 'badge' => 'Premium'],
        ];
        
        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
