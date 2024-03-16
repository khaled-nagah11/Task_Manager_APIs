<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'sometimes|required|min:5|max:255',
            'is_done'=>'sometimes|boolean',
            'project_id'=>[
                'nullable',
                Rule::in(Auth::user()->memberships->pluck('id')),
            ],
        ];
    }
    public function messages()
    {
        return [
            'title.required' => 'هذا الحقل مطلوب',
            'title.min' => 'يجب ادخال 5 احرف على الاقل',
            'title.max' => 'يجب ادخال 255 حرف على الاكثر',
        ];
    }
}
