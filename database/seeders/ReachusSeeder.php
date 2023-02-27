<?php

namespace Database\Seeders;

use App\Models\Reach;
use Illuminate\Database\Seeder;

class ReachusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Reach::create([
            'name' => 'Email Marketing',
            'status' => 1
        ]);
        Reach::create([
            'name' => 'Trade Show',
            'status' => 1
        ]);
        Reach::create([
            'name' => 'Search Engine',
            'status' => 1
        ]);
        Reach::create([
            'name' => 'Advertisement',
            'status' => 1
        ]);
        Reach::create([
            'name' => 'Bussiness Associate referral',
            'status' => 1
        ]);
        Reach::create([
            'name' => 'Sales Person',
            'status' => 1
        ]);
        Reach::create([
            'name' => 'Other',
            'status' => 1
        ]);
    }
}
