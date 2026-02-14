<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLoanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasAnyRole(['admin', 'bibliothecaire']);
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'copy_id' => 'required|exists:copies,id',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'L\'utilisateur est obligatoire.',
            'user_id.exists' => 'L\'utilisateur sélectionné n\'existe pas.',
            'copy_id.required' => 'L\'exemplaire est obligatoire.',
            'copy_id.exists' => 'L\'exemplaire sélectionné n\'existe pas.',
        ];
    }
}
