<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditRepairSubCategoryRequest extends FormRequest
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
            'name' => 'required|min:3|max:60|unique:repair_sub_categories,name,'.$this->repairsubcategory->id.',id,repair_category_id,'.$this->input('repair_category_id').',deleted_at,NULL',
            'repair_category_id' => 'required',
        ];
    }
}
