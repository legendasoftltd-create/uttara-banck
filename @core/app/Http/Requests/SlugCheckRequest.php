<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SlugCheckRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'slug' => 'required|string',
            'type' => 'required|string',
            'lang' => 'nullable|string',
            'date' => 'nullable|date',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}