<?php

namespace App\Services;

use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\ValidationException;

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

    public function login(array $validatedRequest): Customer
    {
        /** @var Customer $customer */
        $customer = $this->customer->query()->where('email', $validatedRequest['email'])->first();
        if (!isset($customer) || !Hash::check($validatedRequest['password'], $customer->password)) {
            throw ValidationException::withMessages([
                'email' => Lang::get('validation.custom.email.credentials'),
            ]);
        }
        $customer->token = $customer->createToken('customer')->plainTextToken;
        return $customer;
    }
}
