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
            'show_other_textbox' => 0,
            'textbox_lable' => '',
            'status' => 1
        ]);
        Reach::create([
            'name' => 'Trade Show',
            'show_other_textbox' => 0,
            'textbox_lable' => '',
            'status' => 1
        ]);
        Reach::create([
            'name' => 'Search Engine',
            'show_other_textbox' => 0,
            'textbox_lable' => '',
            'status' => 1
        ]);
        Reach::create([
            'name' => 'Advertisement',
            'show_other_textbox' => 0,
            'textbox_lable' => '',
            'status' => 1
        ]);
        Reach::create([
            'name' => 'Bussiness Associate referral',
            'show_other_textbox' => 0,
            'textbox_lable' => '',
            'status' => 1
        ]);
        Reach::create([
            'name' => 'Sales Person',
            'show_other_textbox' => 1,
            'textbox_lable' => 'Sales Person Name',
            'status' => 1
        ]);
        Reach::create([
            'name' => 'Other',
            'show_other_textbox' => 1,
            'textbox_lable' => 'Specify Other',
            'status' => 1
        ]);
    }
}
