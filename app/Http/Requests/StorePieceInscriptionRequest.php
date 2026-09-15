<?php

namespace App\Http\Requests;

use App\Models\TypePiece;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePieceInscriptionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // adapte selon ta politique d'autorisation
    }

    public function rules(): array
    {
        $rules = [
            'session_formation_id' => ['required', 'exists:session_formations,id'],
            'commentaire' => ['nullable', 'string', 'max:500'],
            'confirmation' => ['required', 'accepted'],
            'pieces' => ['nullable', 'array'],
        ];

        // Règles générées dynamiquement pour chaque type de pièce actif
        foreach (TypePiece::actifs()->get() as $type) {
            $rules['pieces.' . $type->code] = [
                $type->obligatoire ? 'required' : 'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:5120', // 5 Mo en Ko
            ];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'pieces.*.required' => 'Ce document est obligatoire.',
            'pieces.*.mimes' => 'Formats acceptés : PDF, JPG, PNG uniquement.',
            'pieces.*.max' => 'Le fichier ne doit pas dépasser 5 Mo.',
            'confirmation.accepted' => 'Vous devez confirmer votre candidature.',
        ];
    }
}