<?php

namespace App\Services;

use App\Enums\AccountDescription;
use App\Models\Account;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class AccountService
{
    public const OPENING_BALANCE = 500000;

    public function open(Customer $customer): ?Account
    {
        $result = null;
        DB::transaction(function () use ($customer, &$result) {
            /** @var Account $accountModel */
            $accountModel = $customer->accounts()->create(['balance' => self::OPENING_BALANCE]);
            $accountModel->depositTransactions()->create([
                'amount' => self::OPENING_BALANCE,
                'description' => AccountDescription::OPEN_NEW_ACCOUNT->description()
            ]);
            $result = $accountModel;
        });
        return $result;
    }
}
