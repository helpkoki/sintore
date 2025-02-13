<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies = [
            [
                'c_name' => 'Lulu Admin',
                'c_email' => 'l83698230@gmail.com',
                'c_type' => 'Super Admin',
                'date_added' => Carbon::now(),
                'admin_no' => '24680',
                'password' => 'admin@123'
            ]
            // [
            //     'c_name' => 'System Manager',
            //     'c_email' => 'manager@tekete.com',
            //     'c_type' => 'Manager',
            //     'date_added' => Carbon::now(),
            //     'admin_no' => '36912',
            //     'password' => 'manager@123'
            // ]
            // Add more admins as needed
        ];

        foreach ($companies as $company) {
            Company::create([
                'c_name' => $company['c_name'],
                'c_email' => $company['c_email'],
                'c_type' => $company['c_type'],
                'date_added' => $company['date_added'],
                'admin_no' => $company['admin_no'],
                'password' => md5($company['password']),
                'random' => Str::random(50),
                'password_updated' => 0
            ]);
        }

        // foreach ($companies as $company) {
        //     Company::create($company);  // Insert directly without hashing
        // }
    }
}