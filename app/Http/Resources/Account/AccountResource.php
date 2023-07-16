<?php

namespace App\Http\Resources\Account;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Account $this */
        return [
            'id' => $this->id,
            'balance' => $this->balance,
        ];
    }
}
