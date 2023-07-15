<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $account_id
 * @property int $amount
 * @property string $type
 * @property string $description
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read Account $account
 */
class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['account_id', 'amount', 'type', 'description'];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
