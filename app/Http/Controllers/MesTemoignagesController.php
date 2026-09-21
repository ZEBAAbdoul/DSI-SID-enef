<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Temoignage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;

class MesTemoignagesController extends Controller
{
    public function index(): View
    {
        $temoignages = Temoignage::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('admin.mes-temoignages.index', compact('temoignages'));
    }

    public function create(): View
    {
        $temoignage = new Temoignage([
            'note' => 5,
            'auteur' => auth()->user()->name,
        ]);

        return view('admin.mes-temoignages.create', compact('temoignage'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            $data['image_url'] = $this->storeImage($request);
        }

        Temoignage::create($data + [
            'user_id' => auth()->id(),
            'est_publie' => false, // toujours soumis à validation
            'ordre' => 0,
        ]);

        return redirect()
            ->route('admin.mes-temoignages.index')
            ->with('success', "Merci ! Votre témoignage a été envoyé. Il sera visible sur le site après validation par l'administration.");
    }

    public function edit(Temoignage $temoignage): View
    {
        $this->autoriser($temoignage);

        return view('admin.mes-temoignages.edit', compact('temoignage'));
    }

    public function update(Request $request, Temoignage $temoignage): RedirectResponse
    {
        $this->autoriser($temoignage);

        $data = $this->validated($request);
        $etaitPublie = $temoignage->est_publie;

        if ($request->boolean('supprimer_image')) {
            $this->deleteImage($temoignage->image_url);
            $data['image_url'] = null;
        }

        if ($request->hasFile('image')) {
            $this->deleteImage($temoignage->image_url);
            $data['image_url'] = $this->storeImage($request);
        }

        // Toute modification repasse le témoignage en validation
        $data['est_publie'] = false;

        $temoignage->update($data);

        return redirect()
            ->route('admin.mes-temoignages.index')
            ->with('success', $etaitPublie
                ? "Témoignage modifié. Il a été retiré du site en attendant une nouvelle validation."
                : "Témoignage mis à jour.");
    }

    public function destroy(Temoignage $temoignage): RedirectResponse
    {
        $this->autoriser($temoignage);

        $this->deleteImage($temoignage->image_url);
        $temoignage->delete();

        return redirect()
            ->route('admin.mes-temoignages.index')
            ->with('success', 'Témoignage supprimé.');
    }

    // ------------------------------------------------------------------

    /** Un user ne touche qu'à ses propres témoignages. */
    private function autoriser(Temoignage $temoignage): void
    {
        abort_unless($temoignage->user_id === auth()->id(), 403);
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'contenu' => ['required', 'string', 'min:10', 'max:600'],
            'auteur' => ['required', 'string', 'max:150'],
            'fonction' => ['nullable', 'string', 'max:200'],
            'note' => ['required', 'integer', 'between:1,5'],
            'formation_concernee' => ['nullable', 'string', 'max:200'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'contenu.required' => 'Le témoignage est obligatoire.',
            'contenu.min' => 'Le témoignage doit contenir au moins 10 caractères.',
            'contenu.max' => 'Le témoignage ne doit pas dépasser 600 caractères.',
            'auteur.required' => 'Votre nom est obligatoire.',
            'note.required' => 'La note est obligatoire.',
            'note.between' => 'La note doit être comprise entre 1 et 5.',
            'image.image' => 'Le fichier doit être une image.',
            'image.max' => "L'image ne doit pas dépasser 2 Mo.",
        ]);

        unset($data['image']);

        return $data;
    }

    private function storeImage(Request $request): string
    {
        $file = $request->file('image');
        $name = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('temoignages'), $name);

        return 'temoignages/' . $name;
    }

    private function deleteImage(?string $path): void
    {
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}