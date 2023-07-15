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

    public function transfer(array $validatedRequest): Account
    {
        /** @var Account $sourceModel */
        $sourceModel = Account::query()->findOrFail($validatedRequest['source_account']);
        /** @var Account $targetModel */
        $targetModel = Account::query()->findOrFail($validatedRequest['target_account']);

        DB::transaction(function () use ($validatedRequest, $sourceModel, $targetModel) {
            $sourceModel->decrement('balance', $validatedRequest['amount']);
            $sourceModel->transactions()->create([
                'amount' => $validatedRequest['amount'],
                'type' => AccountTypes::WITHDRAWAL->value,
                'description' => AccountDescription::MONEY_TRANSFER->description()
            ]);
            $targetModel->increment('balance', $validatedRequest['amount']);
            $targetModel->depositTransactions()->create([
                'amount' => $validatedRequest['amount'],
                'type' => AccountTypes::DEPOSIT->value,
                'description' => AccountDescription::MONEY_TRANSFER->description()
            ]);
        });

        return $sourceModel;
    }
}
