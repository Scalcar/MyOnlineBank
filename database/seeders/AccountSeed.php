<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Seeder;

class AccountSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $accounts = [
            [
                'accNo' => '639369',
                'branch' => '0',
                'type' => '0',
                'balance' => '3690',
                'currency' => '0',
                'pin' => '6976',          
                'user_id' => '1',
                'admin_id' => '1'            
            ], [
                'accNo' => '660036',
                'branch' => '1',
                'type' => '0',
                'balance' => '4200',
                'currency' => '0',
                'pin' => '3483',               
                'user_id' => '2',
                'admin_id' => '1'
            ], [
                'accNo' => '960280',
                'branch' => '0',
                'type' => '1',
                'balance' => '400',
                'currency' => '1',
                'pin' => '1723',
                'user_id' => '1',
                'admin_id' => '1'
            ], [
                'accNo' => '893446',
                'branch' => '1',
                'type' => '1',
                'balance' => '420',
                'currency' => '2',
                'pin' => '4601',
                'user_id' => '2',
                'admin_id' => '1'
            ],
        ];

        foreach($accounts as $account)
        {
            Account::create($account);
        }
    }
}
