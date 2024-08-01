<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApproveQuotationRequest extends FormRequest
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
            // 'user_id' => 'required|integer',
            'quotation_id' => 'required|integer',
            'order_id' => 'required|integer',
            // 'number' => 'required|string',
            'order_number_warranty' => 'nullable|string',
            'order_number_expenses' => 'nullable|string',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, mixed>
     */
    public function messages()
    {
        return [
            'quotation_id.required' => 'La cotización es requerida',
            'order_id.required' => 'La orden de compra es requerida',
            // 'number.required' => 'El número de orden de compra es requerido',
            'order_number_warranty.string' => 'El número de orden de compra de garantia debe ser un valor valido',
            'order_number_expenses.string' => 'El número de orden de compra de gastos debe ser un valor valido',
        ];
    }
}
