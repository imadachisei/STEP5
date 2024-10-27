<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User::insert([
        //     [
        //       'name' => 'admin',
        //       'email' => 'admin@example.com',
        //       'password' => Hash::make('adminpass')
        //     ],
        //     [
        //       'name' => 'member',
        //       'email' => 'member@example.com',
        //       'password' => Hash::make('memberpass')
        //     ],
        //     [
        //       'name' => 'creator',
        //       'email' => 'creator@example.com',
        //       'password' => Hash::make('creatorpass')
        //     ]
        //   ]);
    }
}
