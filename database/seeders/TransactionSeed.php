<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Seeder;

class TransactionSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $transactions = [
            [
                'trans_no' => '2510258',
                'description' => 'Account Opening',                            
                'account_id' => '1',
                'credit' => '3690',
                'balance' => '3690',
            ], [
                'trans_no' => '2065114',
                'description' => 'Account Opening',                            
                'account_id' => '2',
                'credit' => '4200',
                'balance' => '4200',
            ], [
                'trans_no' => '1157201',
                'description' => 'Account Opening',                            
                'account_id' => '3',
                'credit' => '400',
                'balance' => '400',
            ], [
                'trans_no' => '2707517',
                'description' => 'Account Opening',                            
                'account_id' => '4',
                'credit' => '420',
                'balance' => '420',
            ],
        ];

        foreach($transactions as $transaction)
        {
            Transaction::create($transaction);
        }
    }
}
