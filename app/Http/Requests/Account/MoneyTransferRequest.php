<?php

namespace App\Http\Requests\Account;

use App\Models\Account;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class MoneyTransferRequest extends FormRequest
{
    private null|Account $customerAccount;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'source_account' => ['required'],
            'target_account' => [
                'required',
                Rule::notIn(request('source_account')),
                Rule::exists(Account::class,'id')
            ],
            'amount' => ['required', 'integer', 'gt:0', 'lte:' . $this->customerAccount->balance]
        ];
    }

    /**
     * @throws ValidationException
     */
    protected function prepareForValidation()
    {
        $this->customerAccount = Account::query()
            ->where('id', request('source_account'))
            ->where('customer_id', auth()->id())
            ->first();
        if (!isset($this->customerAccount)) {
            throw ValidationException::withMessages([
                'source_account' => Lang::get('validation.custom.source_account.exist')
            ]);
        }
        $this->merge(['source_account' => $this->customerAccount->id]);
    }
}
