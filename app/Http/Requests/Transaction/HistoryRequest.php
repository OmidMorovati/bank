<?php

namespace App\Http\Requests\Transaction;

use App\Models\Account;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class HistoryRequest extends FormRequest
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
