<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasAnyRole(['admin', 'bibliothecaire']);
    }

    public function rules(): array
    {
        return [
            'titre' => 'required|string|max:255',
            'auteur' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:20|unique:books,isbn',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'couverture' => 'nullable|image|max:2048',
            'annee_publication' => 'nullable|integer|min:1000|max:' . date('Y'),
        ];
    }

    public function messages(): array
    {
        return [
            'titre.required' => 'Le titre est obligatoire.',
            'auteur.required' => 'L\'auteur est obligatoire.',
            'category_id.required' => 'La catégorie est obligatoire.',
            'category_id.exists' => 'La catégorie sélectionnée n\'existe pas.',
            'isbn.unique' => 'Cet ISBN existe déjà.',
            'couverture.image' => 'Le fichier doit être une image.',
            'couverture.max' => 'L\'image ne doit pas dépasser 2 Mo.',
        ];
    }
}
