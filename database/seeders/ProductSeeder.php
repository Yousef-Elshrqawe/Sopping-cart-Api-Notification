<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        for ($i = 1; $i <= 1000; $i++) {
            $products[] = [
                'sku'                   => $faker->ean8,
                'name'                  => $faker->sentence(2, true),
                'slug'                  => $faker->unique()->slug(2, true),
                'price'                 => $faker->numberBetween(5, 200),
                'quantity'              => $faker->numberBetween(10, 100),
                'Category'              => $faker->randomElement(['Electronics', 'Books', 'Clothing', 'Shoes', 'Toys', 'Sports', 'Home', 'Garden', 'Tools', 'Automotive', 'Industrial', 'Grocery', 'Health', 'Beauty', 'Baby', 'Kids', ]),
                'UnitsInStock'          => $faker->numberBetween(10, 100),
                'created_at'            => now(),
                'updated_at'            => now(),
                'image'                 => $faker->imageUrl(640, 480, 'cats', true, 'Faker'),
            ];
        }

        $chunks = array_chunk($products, 100);
        foreach ($chunks as $chunk) {
            Product::insert($chunk);
        }
    }
}
