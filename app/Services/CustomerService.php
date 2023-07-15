<?php

namespace App\Services;

use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class CustomerService
{
    public function __construct(private Customer $customer, private AccountService $accountService)
    {
    }

    public function register(array $validatedRequest): ?Customer
    {
        $result = null;
        DB::transaction(function () use ($validatedRequest, &$result) {
            /** @var Customer $customerModel */
            $customerModel = $this->customer->query()->create($validatedRequest);
            $this->accountService->open($customerModel);
            $token = $customerModel->createToken('customer')->plainTextToken;
            $customerModel->token = $token;
            $result = $customerModel;
        });
        return $result;
    }
}
