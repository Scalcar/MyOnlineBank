<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'fname' => 'Eduard',
                'lname' => 'Stelian',
                'gender' => '1',
                'dob' => '1999-09-06',
                'cnp' => '1990906400216',
                'email' => 'elyan@mail.com',
                'phone' => '0212323639',
                'address' => 'Bucuresti Str Cavalerilor nr 96',
                'username' => 'ElyanTheBrave',
                'password' => Hash::make('123456'),
                'admin_id' => 1
            ], 
            [
                'fname' => 'Maria',
                'lname' => 'Natalia',
                'gender' => '0',
                'dob' => '2001-11-25',
                'cnp' => '6011125400213',
                'email' => 'nataly@mail.com',
                'phone' => '0212323245',
                'address' => 'Bucuresti Str Bogatiei nr 36',
                'username' => 'Nataly',
                'password' => Hash::make('123456'),
                'admin_id' => 1
            ], 
            [
                'fname' => 'Gheorghe',
                'lname' => 'Gigi',
                'gender' => '1',
                'dob' => '2000-10-11',
                'cnp' => '5001011400521',
                'email' => 'user@mail.com',
                'phone' => '0766232323',
                'address' => 'Bucuresti Drumul Fericirii nr 12',                    
                'username' => 'Gheorghe',
                'password' => Hash::make('123456'),
                'admin_id' => '1'
            ]
        ];

        foreach($users as $user)
        {
            User::create($user);
        }
    }
}
