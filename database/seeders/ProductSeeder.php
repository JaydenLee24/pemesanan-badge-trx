<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Polisi', 'Tentara', 'Pramuka', 'Custom', 'Sekolah'];
        $sizes = ['4cm x 4cm', '5cm x 5cm', '6cm x 6cm', '7cm x 5cm'];

        foreach ($categories as $category) {
            $itemsInCategory = $category === end($categories) ? 66 - (13 * 4) : 13;

            for ($i = 1; $i <= $itemsInCategory; $i++) {
                Product::create([
                    'code' => 'BDG-' . strtoupper(substr($category, 0, 3)) . '-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'name' => "Badge {$category} " . $i,
                    'category' => $category,
                    'image' => null,
                    'price' => rand(15, 60) * 1000,
                    'size' => $sizes[array_rand($sizes)],
                    'description' => "Contoh deskripsi untuk badge {$category} nomor {$i}. Data ini masih dummy, akan diperbarui admin.",
                    'min_qty_nego' => rand(0, 1) ? 50 : 0,
                    'is_active' => true,
                ]);
            }
        }
    }
}