<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexTaskRequest extends FormRequest
{
    public function rules()
    {
        return [
            'status' => 'sometimes|in:pending_id,pending,completed',
            'created_at' => 'sometimes|date',
            'page_size' => 'nullable|integer'
        ];
    }
}