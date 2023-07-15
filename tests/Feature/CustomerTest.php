<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Transaction;
use App\Services\AccountService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function customer_can_register_with_initial_balance(): void
    {
        $data = Customer::factory()->raw();
        $data['password_confirmation'] = $data['password'];

        $response = $this->post(route('customer.register'), $data)
            ->assertCreated()
            ->assertJsonPath('data.name', $data['name'])
            ->assertJsonCount(1, 'data.accounts')
            ->assertJsonPath('data.accounts.0.balance', AccountService::OPENING_BALANCE);

        $this->assertDatabaseHas(
            Transaction::class,
            ['account_id' => data_get($response, 'data.accounts.0.id')]
        );
    }

    /**
     * @test
     */
    public function customer_can_login(): void
    {
        $password = fake()->password(8);
        /** @var Customer $customer */
        $customer = Customer::factory()->create(['password' => $password]);
        $data['email'] = $customer->email;
        $data['password'] = $password;

        $this->post(route('customer.login'), $data)
            ->assertSuccessful()
            ->assertJsonPath('data.email', $data['email'])
            ->assertJsonStructure(['data' => ['name', 'email', 'token']]);
    }
}
