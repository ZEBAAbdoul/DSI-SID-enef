<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DocumentController extends Controller
{
    /**
     * Liste des documents, avec filtres optionnels (categorie_id, type, acces).
     */
    public function index(Request $request): JsonResponse
    {
        $query = Document::with(['categorie', 'publiePar']);

        if ($request->filled('categorie_id')) {
            $query->where('categorie_id', $request->categorie_id);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('acces')) {
            $query->where('acces', $request->acces);
        }

        $documents = $query->orderByDesc('publie_le')->paginate(15);

        return response()->json($documents);
    }

    /**
     * Détail d'un document.
     */
    public function show(Document $document): JsonResponse
    {
        return response()->json(
            $document->load(['categorie', 'publiePar'])
        );
    }

    /**
     * Création d'un document.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $this->validateDocument($request);

        $validated['publie_par'] = $request->user()?->id;
        $validated['publie_le'] = now();

        $document = Document::create($validated);

        return response()->json($document->load(['categorie', 'publiePar']), 201);
    }

    /**
     * Mise à jour d'un document.
     */
    public function update(Request $request, Document $document): JsonResponse
    {
        $validated = $this->validateDocument($request, $document->id);

        $document->update($validated);

        return response()->json($document->load(['categorie', 'publiePar']));
    }

    /**
     * Suppression d'un document.
     */
    public function destroy(Document $document): JsonResponse
    {
        $document->delete();

        return response()->json(null, 204);
    }

    /**
     * Incrémente le compteur de téléchargements et renvoie l'URL du fichier.
     */
    public function telecharger(Document $document): JsonResponse
    {
        $document->increment('nombre_telechargements');

        return response()->json([
            'fichier_url' => $document->fichier_url,
            'nombre_telechargements' => $document->nombre_telechargements,
        ]);
    }

    private function validateDocument(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'categorie_id' => ['nullable', 'exists:categories_documents,id'],
            'titre' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'type' => ['required', Rule::in([
                'rapport',
                'brochure',
                'texte_reglementaire',
                'support_pedagogique',
            ])],
            'fichier_url' => ['required', 'string', 'max:255'],
            'format_fichier' => ['nullable', 'string', 'max:10'],
            'taille_fichier_ko' => ['nullable', 'integer', 'min:0'],
            'acces' => ['required', Rule::in(['public', 'restreint'])],
            'version' => ['nullable', 'string', 'max:20'],
        ]);
    }
}