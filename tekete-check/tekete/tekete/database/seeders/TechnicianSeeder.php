<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Technician;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TechnicianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $technicians = [
            [
                'first_name' => 'Lulu',
                'last_name' => 'Matshidze',
                'email' => 'l83698230@gmail.com',
                'mobile' => '1234567890',
                'level' => 1,
                'password' => 'Luluza@72'
            ],
            // [
            //     'first_name' => 'Jane',
            //     'last_name' => 'Smith',
            //     'email' => 'jane.smith@example.com',
            //     'mobile' => '0987654321',
            //     'level' => 2,
            //     'password' => 'password456'
            //]
            // Add more technicians as needed
        ];

        foreach ($technicians as $technician) {
            Technician::create([
                'first_name' => $technician['first_name'],
                'last_name' => $technician['last_name'],
                'email' => $technician['email'],
                'mobile' => $technician['mobile'],
                'level' => $technician['level'],
                'randomstring' => Str::random(50),
                'password' => md5($technician['password']),
                'password_updated' => 0
            ]);
        }
    }
}