<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Region;
use Illuminate\Support\Str;

class RegionSeeder extends Seeder
{
    public function run(): void
    {
        $regions = [
            'Arusha', 'Dar es Salaam', 'Dodoma', 'Geita', 'Iringa', 
            'Kagera', 'Katavi', 'Kigoma', 'Kilimanjaro', 'Lindi', 
            'Manyara', 'Mara', 'Mbeya', 'Morogoro', 'Mtwara', 
            'Mwanza', 'Njombe', 'Pwani', 'Rukwa', 'Ruvuma', 
            'Shinyanga', 'Simiyu', 'Singida', 'Songwe', 'Tabora', 
            'Tanga', 'Kaskazini Unguja', 'Kusini Unguja', 'Mjini Magharibi', 
            'Kaskazini Pemba', 'Kusini Pemba'
        ];

        foreach ($regions as $name) {
            Region::create([
                'name' => $name,
                'slug' => Str::slug($name),
            ]);
        }
    }
}