<?php

namespace Tests\Feature;

use App\Enums\AccountTypes;
use App\Models\Account;
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

    /**
     * @test
     */
    public function customer_can_transfer_money_to_another_account(): void
    {
        $balanceAmount = (int)fake()->numerify('1##000');
        $transferAmount = (int)fake()->numerify('1###0');
        /** @var Account $sourceAccount */
        $sourceAccount = Account::factory()->create(['balance' => $balanceAmount])->load('customer');
        /** @var Account $targetAccount */
        $targetAccount = Account::factory()->create();
        $data = [
            'source_account' => $sourceAccount->id,
            'target_account' => $targetAccount->id,
            'amount' => $transferAmount
        ];
        $this->actingAs($sourceAccount->customer)
            ->post(route('account.money-transfer'), $data)
            ->assertSuccessful()
            ->assertJsonPath('data.balance', $balanceAmount - $transferAmount);

        $this->assertSame($balanceAmount - $transferAmount, $sourceAccount->refresh()->balance);
        $this->assertSame($targetAccount->balance + $transferAmount, $targetAccount->refresh()->balance);

        $this->assertDatabaseHas(Transaction::class, [
            'account_id' => $sourceAccount->id,
            'type' => AccountTypes::WITHDRAWAL->value,
            'amount' => $transferAmount
        ]);

        $this->assertDatabaseHas(Transaction::class, [
            'account_id' => $targetAccount->id,
            'type' => AccountTypes::DEPOSIT->value,
            'amount' => $transferAmount
        ]);
    }
}
