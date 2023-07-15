<?php

namespace App\Models;

use App\Enums\AccountTypes;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $customer_id
 * @property int $balance
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read Customer $customer
 * @property-read Transaction[] $transactions
 * @property-read Transaction[] $depositTransactions
 * @property-read Transaction[] $withdrawalTransactions
 */
class Account extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'balance'];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function depositTransactions(): HasMany
    {
        return $this->hasMany(Transaction::class)->where('type', AccountTypes::DEPOSIT->value);
    }

    public function withdrawalTransactions(): HasMany
    {
        return $this->hasMany(Transaction::class)->where('type', AccountTypes::WITHDRAWAL->value);
    }
}
