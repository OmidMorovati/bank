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
}
