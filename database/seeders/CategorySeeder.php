<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Cuidado Capilar',
            'Coloración',
            'Uñas',
            'Maquillaje',
            'Herramientas',
            'Consumibles',
            'Refrescos',
            'Botanas',
        ];

        foreach ($categories as $c) {
            Category::firstOrCreate(['name' => $c]);
        }
    }
}