<?php

namespace App\Http\Resources\Customer;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RegisterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Customer|RegisterResource $this */
        return [
            'name' => $this->name,
            'email' => $this->email,
            'token' => $this->token ?? null,
            'accounts' => $this->whenLoaded('accounts', AccountResource::collection($this->accounts))
        ];
    }
}
