<?php

namespace Database\Factories;

use App\Enums\AccountDescription;
use App\Enums\AccountTypes;
use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends Factory
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        /** @var AccountTypes $typeCase */
        $typeCase = Arr::random(AccountTypes::cases());
        /** @var AccountDescription $description */
        $descriptionCase = Arr::random(AccountDescription::cases());

        if ($descriptionCase === AccountDescription::OPEN_NEW_ACCOUNT) {
            $typeCase = AccountTypes::DEPOSIT;
        }
        return [
            'account_id' => Account::factory(),
            'amount' => (int)fake()->numerify('1##0000'),
            'type' => $typeCase->value,
            'description' => $descriptionCase->description()
        ];
    }
}
