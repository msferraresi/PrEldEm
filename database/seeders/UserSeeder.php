<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Preldem Manager',
            'email' => 'preldem.manager@gmail.com',
            'password' => bcrypt('Lepo1867'),
        ])->assignRole('admin');
    }
}
