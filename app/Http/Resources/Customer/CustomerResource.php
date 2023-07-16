<?php

namespace App\Http\Resources\Customer;

use App\Http\Resources\Account\AccountResource;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Customer|CustomerResource $this */
        return [
            'name' => $this->name,
            'email' => $this->email,
            'token' => $this->token ?? null,
            'accounts' => $this->whenLoaded('accounts', AccountResource::collection($this->accounts))
        ];
    }
}
