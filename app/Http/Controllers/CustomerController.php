<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customer\RegisterRequest;
use App\Http\Resources\Customer\RegisterResource;
use App\Services\CustomerService;

class CustomerController extends Controller
{
    public function __construct(private CustomerService $customerService)
    {
    }

    public function register(RegisterRequest $request): RegisterResource
    {
       return RegisterResource::make($this->customerService->register($request->validated()));
    }
}
