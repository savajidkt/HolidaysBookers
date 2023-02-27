<?php

namespace Database\Seeders;

use App\Models\CompanyType;
use Illuminate\Database\Seeder;

class CompanyTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CompanyType::create([
            'company_type' => 'Proprietor',
            'status' => 1
        ]);
        CompanyType::create([
            'company_type' => 'Partnership',
            'status' => 1
        ]);
        CompanyType::create([
            'company_type' => 'LLP',
            'status' => 1
        ]);
        CompanyType::create([
            'company_type' => 'Pvt Ltd',
            'status' => 1
        ]);
        CompanyType::create([
            'company_type' => 'Admin Agent',
            'status' => 1
        ]);
    }
}
