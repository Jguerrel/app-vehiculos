<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSubCategoryRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:repair_sub_categories,name',
            'repair_category_id' => 'required|integer|exists:repair_categories,id',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre del modelo es requerido',
            'name.unique' => 'El nombre del modelo ya existe, por favor ingrese otro',
            'name.string' => 'El nombre del modelo debe ser una cadena de texto',
            'name.max' => 'El nombre del modelo no debe exceder los 255 caracteres',
            'repair_category_id.required' => 'El id de la marca es requerido',
            'repair_category_id.integer' => 'El id de la marca debe ser un número entero',
            'repair_category_id.exists' => 'El id de la marca no existe',
        ];
    }
}
