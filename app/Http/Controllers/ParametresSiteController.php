<?php

namespace App\Http\Controllers;

use App\Models\ParametresSite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Facades\Cache; 

class ParametresSiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $parametres = ParametresSite::with('updatedBy')->first();
            
            if (!$parametres) {
                session()->flash('info', 'Aucun paramètre trouvé. Veuillez créer les paramètres du site.');
            }
            
            return view('admin.parametres.index', compact('parametres'));
            
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération des paramètres : ' . $e->getMessage());
            
            return view('admin.parametres.index', [
                'parametres' => null,
            ])->with('error', 'Erreur lors de la récupération des paramètres.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Vérifier si des paramètres existent déjà
            $existing = ParametresSite::first();
            if ($existing) {
                return redirect()->route('admin.parametres.index')
                    ->with('error', 'Les paramètres existent déjà. Utilisez la modification pour les mettre à jour.');
            }

            $validator = Validator::make($request->all(), [
                'nom_site' => 'required|string|max:150',
                'slogan' => 'nullable|string|max:255',
                'logo_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'favicon_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,ico|max:1024',
                'mot_dg_titre' => 'nullable|string|max:150',
                'mot_dg_contenu' => 'nullable|string',
                'mot_dg_photo_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'mot_dg_nom' => 'nullable|string|max:150',
                'adresse' => 'nullable|string|max:255',
                'telephone' => 'nullable|string|max:30',
                'email_contact' => 'nullable|string|max:150|email',
                'annee_creation' => 'nullable|integer|min:1900|max:' . date('Y'),
                'personne_forme' => 'nullable|integer|min:0',
                'facebook_url' => 'nullable|string|max:255|url',
                'linkedin_url' => 'nullable|string|max:255|url',
                'liens_utiles.titre' => 'nullable|array',
                'liens_utiles.titre.*' => 'nullable|string|max:150',
                'liens_utiles.url' => 'nullable|array',
                'liens_utiles.url.*' => 'nullable|string|max:255|url',
                'meta_description' => 'nullable|string|max:255',
            ]);

            if ($validator->fails()) {
                return redirect()->route('admin.parametres.index')
                    ->withErrors($validator)
                    ->withInput();
            }

            $data = $request->except(['logo_url', 'favicon_url', 'mot_dg_photo_url']);
            
            // Gestion des fichiers
            if ($request->hasFile('logo_url')) {
                $path = $request->file('logo_url')->store('parametres/logos', 'public');
                $data['logo_url'] = '/storage/' . $path;
            }

            if ($request->hasFile('favicon_url')) {
                $path = $request->file('favicon_url')->store('parametres/favicons', 'public');
                $data['favicon_url'] = '/storage/' . $path;
            }

            if ($request->hasFile('mot_dg_photo_url')) {
                $path = $request->file('mot_dg_photo_url')->store('parametres/dg', 'public');
                $data['mot_dg_photo_url'] = '/storage/' . $path;
            }

            $data['updated_by'] = Auth::id();

            $data['liens_utiles'] = $this->normalizeLiensUtiles($request);

            ParametresSite::create($data);

            Cache::forget('site.parametres');
            Cache::forget('site.liens_utiles');

            return redirect()->route('admin.parametres.index')
                ->with('success', 'Paramètres créés avec succès !');

        } catch (\Exception $e) {
            Log::error('Erreur lors de la création des paramètres : ' . $e->getMessage());
            
            return redirect()->route('admin.parametres.index')
                ->with('error', 'Erreur lors de la création des paramètres : ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $parametre)
    {
        try {
            $parametres = ParametresSite::find($parametre);

            if (!$parametres) {
                return redirect()->route('admin.parametres.index')
                    ->with('error', 'Paramètres non trouvés');
            }

            $validator = Validator::make($request->all(), [
                'nom_site' => 'required|string|max:150',
                'slogan' => 'nullable|string|max:255',
                'logo_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'favicon_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,ico|max:1024',
                'mot_dg_titre' => 'nullable|string|max:150',
                'mot_dg_contenu' => 'nullable|string',
                'mot_dg_photo_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'mot_dg_nom' => 'nullable|string|max:150',
                'adresse' => 'nullable|string|max:255',
                'telephone' => 'nullable|string|max:30',
                'email_contact' => 'nullable|string|max:150|email',
                'annee_creation' => 'nullable|integer|min:1900|max:' . date('Y'),
                'personne_forme' => 'nullable|integer|min:0',
                'facebook_url' => 'nullable|string|max:255|url',
                'linkedin_url' => 'nullable|string|max:255|url',
                'liens_utiles.titre' => 'nullable|array',
                'liens_utiles.titre.*' => 'nullable|string|max:150',
                'liens_utiles.url' => 'nullable|array',
                'liens_utiles.url.*' => 'nullable|string|max:255|url',
                'meta_description' => 'nullable|string|max:255',
            ]);

            if ($validator->fails()) {
                return redirect()->route('admin.parametres.index')
                    ->withErrors($validator)
                    ->withInput();
            }

            $data = $request->except(['logo_url', 'favicon_url', 'mot_dg_photo_url', '_method', '_token']);

            // Gestion des fichiers
            if ($request->hasFile('logo_url')) {
                $path = $request->file('logo_url')->store('parametres/logos', 'public');
                $data['logo_url'] = '/storage/' . $path;
            }

            if ($request->hasFile('favicon_url')) {
                $path = $request->file('favicon_url')->store('parametres/favicons', 'public');
                $data['favicon_url'] = '/storage/' . $path;
            }

            if ($request->hasFile('mot_dg_photo_url')) {
                $path = $request->file('mot_dg_photo_url')->store('parametres/dg', 'public');
                $data['mot_dg_photo_url'] = '/storage/' . $path;
            }

            $data['updated_by'] = Auth::id();

            $data['liens_utiles'] = $this->normalizeLiensUtiles($request);

            $parametres->update($data);

            Cache::forget('site.parametres');
            Cache::forget('site.liens_utiles');

            return redirect()->route('admin.parametres.index')
                ->with('success', 'Paramètres mis à jour avec succès !');

        } catch (\Exception $e) {
            Log::error('Erreur lors de la mise à jour des paramètres : ' . $e->getMessage());

            return redirect()->route('admin.parametres.index')
                ->with('error', 'Erreur lors de la mise à jour des paramètres : ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Normalise la liste des liens utiles envoyée par le formulaire
     * (tableaux ´liens_utiles[titre][]´ et ´liens_utiles[url][]´).
     *
     * Ne conserve que les lignes non vides : [['titre' => ..., 'url' => ...], ...]
     *
     * @return array<int, array{titre: string, url: string}>
     */
    protected function normalizeLiensUtiles(Request $request): array
    {
        $liens = [];

        $titres = (array) $request->input('liens_utiles.titre', []);
        $urls = (array) $request->input('liens_utiles.url', []);

        foreach ($titres as $i => $titre) {
            $titre = trim((string) $titre);
            $url = trim((string) ($urls[$i] ?? ''));

            if ($titre === '' && $url === '') {
                continue;
            }

            // Repli : si le titre est vide, on affiche l'URL telle quelle.
            if ($titre === '') {
                $titre = $url;
            }

            $liens[] = [
                'titre' => $titre,
                'url' => $url,
            ];
        }

        return $liens;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $parametres = ParametresSite::find($id);

            if (!$parametres) {
                return redirect()->route('admin.parametres.index')
                    ->with('error', 'Paramètres non trouvés');
            }

            // Supprimer les fichiers associés
            if ($parametres->logo_url) {
                $path = str_replace('/storage/', '', $parametres->logo_url);
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }
            if ($parametres->favicon_url) {
                $path = str_replace('/storage/', '', $parametres->favicon_url);
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }
            if ($parametres->mot_dg_photo_url) {
                $path = str_replace('/storage/', '', $parametres->mot_dg_photo_url);
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }

            $parametres->delete();

            Cache::forget('site.parametres');
            Cache::forget('site.liens_utiles');

            return redirect()->route('admin.parametres.index')
                ->with('success', 'Paramètres supprimés avec succès !');

        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression des paramètres : ' . $e->getMessage());
            
            return redirect()->route('admin.parametres.index')
                ->with('error', 'Erreur lors de la suppression des paramètres : ' . $e->getMessage());
        }
    }

    /**
     * Get site settings for frontend (public)
     */
    public function getPublicSettings()
    {
        try {
            $parametres = ParametresSite::first();

            if (!$parametres) {
                return response()->json([
                    'status' => false,
                    'message' => 'Paramètres non trouvés',
                ], 404);
            }

            $publicData = $parametres->only([
                'nom_site',
                'slogan',
                'logo_url',
                'favicon_url',
                'mot_dg_titre',
                'mot_dg_contenu',
                'mot_dg_photo_url',
                'mot_dg_nom',
                'adresse',
                'telephone',
                'email_contact',
                'annee_creation',
                'personne_forme',
                'facebook_url',
                'linkedin_url',
                'liens_utiles',
                'meta_description',
            ]);

            return response()->json([
                'status' => true,
                'data' => $publicData,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erreur lors de la récupération des paramètres',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}