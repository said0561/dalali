<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Nyumba', 'icon' => 'bi-house-door'],
            ['name' => 'Viwanja & Mashamba', 'icon' => 'bi-map'],
            ['name' => 'Ofisi & Fremu', 'icon' => 'bi-building'],
            ['name' => 'Shule & Majengo', 'icon' => 'bi-mortarboard'],
            ['name' => 'Magari & Mitambo', 'icon' => 'bi-truck'],
            ['name' => 'Mashine & Vifaa', 'icon' => 'bi-tools'],
        ];

        foreach ($categories as $cat) {
            Category::create([
                'name' => $cat['name'],
                'slug' => Str::slug($cat['name']),
                'icon' => $cat['icon'],
            ]);
        }
    }
}