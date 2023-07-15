<?php

namespace App\Services;

use App\Models\Transaction;
use Illuminate\Contracts\Pagination\Paginator;

class TransactionService
{
    public function history(int $account): Paginator
    {
        return Transaction::query()->where('account_id', $account)->simplePaginate();
    }
}
