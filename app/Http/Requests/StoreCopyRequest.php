<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCopyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasAnyRole(['admin', 'bibliothecaire']);
    }

    public function rules(): array
    {
        return [
            'book_id' => 'required|exists:books,id',
            'code_barre' => 'required|string|max:50|unique:copies,code_barre',
            'etat' => 'required|in:disponible,emprunte,perdu,maintenance',
        ];
    }

    public function messages(): array
    {
        return [
            'book_id.required' => 'Le livre est obligatoire.',
            'book_id.exists' => 'Le livre sélectionné n\'existe pas.',
            'code_barre.required' => 'Le code-barres est obligatoire.',
            'code_barre.unique' => 'Ce code-barres existe déjà.',
        ];
    }
}
