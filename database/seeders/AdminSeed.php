<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new Admin([
            'name' => 'AdminV',
            'email' => 'admin@mail.com',
            'password' => Hash::make('123456')
        ]);

        $admin->save();
    }
}
