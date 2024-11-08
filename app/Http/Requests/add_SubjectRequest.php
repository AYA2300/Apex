<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class add_SubjectRequest extends FormRequest
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
            'name'=>'required|string',
            'description'=>'nullable',
            'image'=>'nullable|image|file|mimes:png,jpg,jpeg',
            'section_id'=>'nullable|exists:sections,id',
            'year'=>'required',
            'chapter'=>'required|string',
            'type'=>'required|string'

        ];
    }
}
