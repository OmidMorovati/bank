<?php

namespace App\Services;

use App\Enums\AccountDescription;
use App\Enums\AccountTypes;
use App\Models\Account;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class AccountService
{
    public const OPENING_BALANCE = 500000;

    public function open(Customer $customer, int $balance = self::OPENING_BALANCE): ?Account
    {
        $result = null;
        DB::transaction(function () use ($balance, $customer, &$result) {
            /** @var Account $accountModel */
            $accountModel = $customer->accounts()->create(['balance' => $balance]);
            $accountModel->transactions()->create([
                'amount' => $balance,
                'description' => AccountDescription::OPEN_NEW_ACCOUNT->description(),
                'type' => AccountTypes::DEPOSIT->value
            ]);
            $result = $accountModel;
        });
        return $result;
    }
}
