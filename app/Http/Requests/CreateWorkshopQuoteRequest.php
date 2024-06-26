<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateWorkshopQuoteRequest extends FormRequest
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
            'workshop_id' => 'nullable|integer',
            'user_id' => 'nullable|integer',
            'subtotal' => 'required|numeric',
            'tax' => 'required|numeric',
            'total' => 'required|numeric',
            'subs' => 'required|array|min:1',
            'number' => 'required|numeric|min_digits:4|max_digits:15',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'repair_order_id.required' => 'El id de la orden de reparación es requerido',
            'repair_order_id.integer' => 'El id de la orden de reparación debe ser un número entero',
            'workshop_id.integer' => 'El id del taller debe ser un número entero',
            'user_id.integer' => 'El id del usuario debe ser un número entero',
            'subtotal.required' => 'El subtotal es requerido',
            'subtotal.numeric' => 'El subtotal debe ser un número',
            'tax.required' => 'El ITBMS es requerido',
            'tax.numeric' => 'El ITBMS debe ser un número',
            'total.required' => 'El total es requerido',
            'total.numeric' => 'El total debe ser un número',
            'subs.required' => 'Los servicios son requeridos',
            'subs.array' => 'Los servicios deben ser un arreglo',
            'subs.min' => 'Los servicios deben tener al menos un servicio',
            'number.required' => 'El número de cotización es requerido',
            // 'number.string' => 'El número de cotización debe ser una cadena de texto',
            'number.numeric' => 'El número de cotización debe ser un número',
            'number.min_digits' => 'El número de cotización no puede tener menos de 4 caracteres',
            'number.max_digits' => 'El número de cotización no puede tener más de 15 caracteres',
        ];
    }
}
