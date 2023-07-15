<?php

namespace App\Http\Controllers;

use App\Http\Requests\Account\MoneyTransferRequest;
use App\Http\Requests\Account\OpenRequest;
use App\Http\Resources\Customer\AccountResource;
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
}
