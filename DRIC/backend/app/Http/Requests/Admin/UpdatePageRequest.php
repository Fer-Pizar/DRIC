<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $pageId = $this->route('page')->id ?? null;

        return [
            'parent_id' => ['nullable', 'integer', 'exists:pages,id'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('pages', 'slug')->ignore($pageId)],
            'page_type' => ['required', 'string', 'max:50'],
            'status' => ['required', Rule::in(['draft', 'published', 'archived'])],
            'published_at' => ['nullable', 'date'],
            'sort_order' => ['required', 'integer', 'min:0'],
        ];
    }
}