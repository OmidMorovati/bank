<?php

namespace App\Http\Requests\Account;

use App\Models\Account;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BalanceRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'account' => [
                'required',
                Rule::exists(Account::class, 'id')->where('customer_id', auth()->id())
            ],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(['account' => $this->route('account')]);
    }
}
