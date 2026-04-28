<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'parent_id' => ['nullable', 'integer', 'exists:pages,id'],
            'slug' => ['required', 'string', 'max:255', 'unique:pages,slug'],
            'page_type' => ['required', 'string', 'max:50'],
            'status' => ['required', Rule::in(['draft', 'published', 'archived'])],
            'published_at' => ['nullable', 'date'],
            'sort_order' => ['required', 'integer', 'min:0'],
        ];
    }
}