<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAdditionalExpenseAccount extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'account_number' => 'required|numeric|max:999999999999|unique:additional_expense_accounts,account_number',
            'account_name' => 'required|string|max:255|unique:additional_expense_accounts,account_name',
        ];
    }

    public function attributes()
    {
        return [
            'account_number' => 'Nº de cuenta',
            'account_name' => 'Nombre de la cuenta',
        ];
    }
}
