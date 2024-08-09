<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAdditionalExpenseToOrder extends FormRequest
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
            'repair_order_id' => 'required|integer',
            'additional_expense_account_id' => 'required|integer',
            'supplier' => 'required_if:additional_expense_account_id,1|nullable|integer',
            'amount' => 'required|numeric|max:999999999999',
        ];
    }

    public function attributes()
    {
        return [
            'repair_order_id' => 'Orden de reparación',
            'additional_expense_account_id' => 'Gasto adicional',
            'supplier' => 'Proveedor',
            'amount' => 'Monto',
        ];
    }
}
