<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CategorieDocument;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Validation\Rule;

class DocumentController extends Controller
{
    private array $typeOptions = [
        'rapport' => 'Rapport',
        'brochure' => 'Brochure',
        'texte_reglementaire' => 'Texte réglementaire',
        'support_pedagogique' => 'Support pédagogique',
    ];

    private array $accesOptions = [
        'public' => 'Public',
        'restreint' => 'Restreint',
    ];

    public function index(Request $request): View
{
    $categories = CategorieDocument::orderBy('nom')->get();

    $query = Document::with(['categorie', 'publiePar'])
        ->when($request->filled('categorie_id'), fn($q) => $q->where('categorie_id', $request->categorie_id))
        ->when($request->filled('type'), fn($q) => $q->where('type', $request->type))
        ->when($request->filled('acces'), fn($q) => $q->where('acces', $request->acces))
        ->when($request->filled('telechargeable'), fn($q) => $q->where('telechargeable', $request->boolean('telechargeable')))
        ->orderByDesc('publie_le');

    // Pagination : 10, 25, 50, 100 ou "tous"
    $perPage = $request->input('per_page', 15);

    if ($perPage === 'tous') {
        $total = (clone $query)->count();
        $documents = $query->paginate($total > 0 ? $total : 1);
    } else {
        $perPage = in_array((int) $perPage, [10, 25, 50, 100], true)
            ? (int) $perPage
            : 15;

        $documents = $query->paginate($perPage);
    }

    $documents->withQueryString();

    return view('admin.documents.index', [
        'documents' => $documents,
        'categories' => $categories,
    ]);
}

    public function create(): View
    {
        return view('admin.documents.create', [
            'categories' => CategorieDocument::orderBy('nom')->get(),
            'typeOptions' => $this->typeOptions,
            'accesOptions' => $this->accesOptions,
            'document' => new Document(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateRequest($request);

        $data = $validated;

        if ($request->hasFile('fichier')) {
            $fichier = $request->file('fichier');
            $path = $fichier->store('documents', 'public');

            $data['fichier_url'] = $path;
            $data['format_fichier'] = $fichier->getClientOriginalExtension();
            $data['taille_fichier_ko'] = (int) round($fichier->getSize() / 1024);
        }

        Document::create([
            ...$data,
            'nombre_telechargements' => 0,
            'publie_par' => auth()->id(),
        ]);

        return redirect()
            ->route('admin.documents.index')
            ->with('success', 'Document créé avec succès.');
    }

    public function show(Document $document): View
    {
        $document->load(['categorie', 'publiePar']);

        return view('admin.documents.show', [
            'document' => $document,
            'typeOptions' => $this->typeOptions,
        ]);
    }

    public function edit(Document $document): View
    {
        return view('admin.documents.edit', [
            'document' => $document,
            'categories' => CategorieDocument::orderBy('nom')->get(),
            'typeOptions' => $this->typeOptions,
            'accesOptions' => $this->accesOptions,
        ]);
    }

    public function update(Request $request, Document $document): RedirectResponse
    {
        $validated = $this->validateRequest($request, document: $document);

        $data = $validated;

        if ($request->hasFile('fichier')) {
            // Remplace l'ancien fichier
            if ($document->fichier_url) {
                Storage::disk('public')->delete($document->fichier_url);
            }

            $fichier = $request->file('fichier');
            $path = $fichier->store('documents', 'public');

            $data['fichier_url'] = $path;
            $data['format_fichier'] = $fichier->getClientOriginalExtension();
            $data['taille_fichier_ko'] = (int) round($fichier->getSize() / 1024);
        }

        $document->update($data);

        return redirect()
            ->route('admin.documents.index')
            ->with('success', 'Document mis à jour avec succès.');
    }

    public function destroy(Document $document): RedirectResponse
    {
        if ($document->fichier_url) {
            Storage::disk('public')->delete($document->fichier_url);
        }

        $document->delete();

        return redirect()
            ->route('admin.documents.index')
            ->with('success', 'Document supprimé.');
    }

    public function telecharger(Document $document): StreamedResponse
    {
        if (! $document->telechargeable) {
            abort(403, 'Ce document n\'est pas téléchargeable. Veuillez consulter le code fourni pour une consultation sur place.');
        }

        if (! $document->fichier_url || ! Storage::disk('public')->exists($document->fichier_url)) {
            abort(404, 'Fichier introuvable.');
        }

        // Seuls les téléchargements effectués par le public depuis le centre de
        // téléchargement (bibliothèque) incrémentent le compteur de statistiques.
        if (request()->routeIs('documents.telecharger')) {
            $document->increment('nombre_telechargements');
        }

        $nomTelecharge = Str::slug($document->titre)
            . ($document->format_fichier ? '.' . $document->format_fichier : '');

        return Storage::disk('public')->download($document->fichier_url, $nomTelecharge);
    }
    

    private function validateRequest(Request $request, ?Document $document = null): array
    {
        $validated = $request->validate([
            'categorie_id' => ['required', 'exists:categories_documents,id'],
            'titre' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'type' => ['required', 'in:' . implode(',', array_keys($this->typeOptions))],
            'acces' => ['required', 'in:' . implode(',', array_keys($this->accesOptions))],
            'telechargeable' => ['sometimes', 'boolean'],
            'code_consultation' => ['nullable', 'string', 'max:30'],
            'version' => ['nullable', 'string', 'max:20'],
            'publie_le' => ['nullable', 'date'],
            'fichier' => [
                Rule::requiredIf(function () use ($request, $document) {
                    // Fichier obligatoire si le document doit être téléchargeable
                    // et qu'aucun fichier n'existe déjà (cas de l'édition sans remplacement)
                    return $request->boolean('telechargeable') && ! $document?->fichier_url;
                }),
                'file',
                'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx',
                'max:20480',
            ],
        ]);

        $validated['telechargeable'] = $request->boolean('telechargeable');

        return $validated;
    }
}
