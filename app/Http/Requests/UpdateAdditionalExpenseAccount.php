<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAdditionalExpenseAccount extends FormRequest
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
        $id = $this->id;
        // Rule::unique('additional_expense_accounts', 'account_number')->ignore($id)
        // Rule::unique('additional_expense_accounts', 'account_name')->ignore($id)

        return [
            'account_number' => 'required|numeric|max:999999999999|' . Rule::unique('additional_expense_accounts')->ignore($id),
            'account_name' => 'required|string|max:255|' . Rule::unique('additional_expense_accounts')->ignore($id),
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
