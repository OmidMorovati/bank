<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function customer_can_open_a_new_account(): void
    {
        $customer = Customer::factory()->create();
        $balance = (int)fake()->numerify('1##0000');
        $response = $this->actingAs($customer)
            ->post(route('account.open'), ['balance' => $balance])
            ->assertCreated()
            ->assertJsonPath('data.balance', $balance);

        $this->assertDatabaseHas(Transaction::class, ['account_id' => data_get($response, 'data.id')]);
    }
}
