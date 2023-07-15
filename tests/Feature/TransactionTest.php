<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function customer_can_view_own_transaction_history(): void
    {
        /** @var Account $customerAccount */
        $customerAccount = Account::factory()->create()->load('customer');
        $transactionCount = fake()->numberBetween(1, 10);
        Transaction::factory($transactionCount)->create(['account_id' => $customerAccount->id]);

        $response = $this->actingAs($customerAccount->customer)
            ->get(route('transaction.history', $customerAccount->id))
            ->assertSuccessful()
            ->assertJsonStructure(['data' => [['amount', 'type', 'description', 'created_at']]]);

        $this->assertCount($transactionCount, $response->json('data'));
    }

    /**
     * @test
     */
    public function customer_can_not_view_transaction_history_of_another_customer(): void
    {
        /** @var Account $customerAccount */
        $customerAccount = Account::factory()->create()->load('customer');
        /** @var Account $anotherAccount */
        $anotherAccount = Account::factory()->create()->load('customer');
        $transactionCount = fake()->numberBetween(1, 10);
        Transaction::factory($transactionCount)->create(['account_id' => $customerAccount->id]);

        $this->actingAs($customerAccount->customer)
            ->get(route('transaction.history', $anotherAccount->id))
            ->assertSessionHasErrors();
    }
}
