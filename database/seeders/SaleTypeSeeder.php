<?php

namespace Database\Seeders;

use App\Models\SaleType;
use Illuminate\Database\Seeder;

class SaleTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SaleType::updateOrCreate(
            ['code' => 1],
            [
                'name' => 'Ágio'
            ]
        );

        SaleType::updateOrCreate(
            ['code' => 2],
            [
                'name' => 'Troca'
            ]
        );

        SaleType::updateOrCreate(
            ['code' => 3],
            [
                'name' => 'À vista'
            ]
        );

        SaleType::updateOrCreate(
            ['code' => 4],
            [
                'name' => 'Negociável'
            ]
        );
    }
}
