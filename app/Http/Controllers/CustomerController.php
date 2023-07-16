<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customer\LoginRequest;
use App\Http\Requests\Customer\RegisterRequest;
use App\Http\Resources\Customer\CustomerResource;
use App\Services\CustomerService;

class CustomerController extends Controller
{
    public function __construct(private CustomerService $customerService)
    {
    }

    public function register(RegisterRequest $request): CustomerResource
    {
       return CustomerResource::make($this->customerService->register($request->validated()));
    }

    public function login(LoginRequest $request): CustomerResource
    {
       return CustomerResource::make($this->customerService->login($request->validated()));
    }
}
