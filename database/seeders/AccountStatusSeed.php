<?php

namespace Database\Seeders;

use App\Models\AccountStatus;
use DateTime;
use Illuminate\Database\Seeder;

class AccountStatusSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $accountStatuses = [
            [
                'account_id' => '1',
                'status' => '1',
                'activated_at' => new DateTime(),
            ], [
                'account_id' => '2',
                'status' => '1',
                'activated_at' => new DateTime(),
            ], [
                'account_id' => '3',
                'status' => '1',
                'activated_at' => new DateTime(),
            ], [
                'account_id' => '4',
                'status' => '1',
                'activated_at' => new DateTime(),
            ],
        ];

        foreach($accountStatuses as $accountStatus)
        {
            AccountStatus::create($accountStatus);
        }
    }
}
