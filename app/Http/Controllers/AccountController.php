<?php

namespace App\Http\Controllers;

use App\Http\Requests\Account\BalanceRequest;
use App\Http\Requests\Account\MoneyTransferRequest;
use App\Http\Requests\Account\OpenRequest;
use App\Http\Resources\Account\AccountResource;
use App\Services\AccountService;

class AccountController extends Controller
{
    public function __construct(private AccountService $accountService)
    {
    }

    public function open(OpenRequest $request): AccountResource
    {
       return AccountResource::make($this->accountService->open($request->user(), $request->balance));
    }

    public function moneyTransfer(MoneyTransferRequest $request): AccountResource
    {
       return AccountResource::make($this->accountService->transfer($request->validated()));
    }

    public function balance(BalanceRequest $request): int
    {
       return $this->accountService->balance($request->account);
    }
}
