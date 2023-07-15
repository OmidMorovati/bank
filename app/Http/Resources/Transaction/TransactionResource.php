<?php

namespace App\Http\Resources\Transaction;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Transaction|TransactionResource $this */
        return [
            'amount' => $this->amount,
            'type' => $this->type,
            'description' => $this->description,
            'created_at' => Carbon::parse($this->created_at)->toDateTimeString(),
        ];
    }
}
