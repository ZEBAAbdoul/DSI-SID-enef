<?php

namespace App\Http\Controllers;

use App\Models\CategorieDocument;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategorieDocumentController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = CategorieDocument::with('enfants')
            ->whereNull('parent_id')
            ->get();

        return response()->json($categories);
    }

    public function show(CategorieDocument $categorie): JsonResponse
    {
        return response()->json(
            $categorie->load(['enfants', 'documents'])
        );
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:150'],
            'parent_id' => ['nullable', 'exists:categories_documents,id'],
        ]);

        $categorie = CategorieDocument::create($validated);

        return response()->json($categorie, 201);
    }

    public function update(Request $request, CategorieDocument $categorie): JsonResponse
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:150'],
            'parent_id' => ['nullable', 'exists:categories_documents,id'],
        ]);

        $categorie->update($validated);

        return response()->json($categorie);
    }

    public function destroy(CategorieDocument $categorie): JsonResponse
    {
        $categorie->delete();

        return response()->json(null, 204);
    }
}