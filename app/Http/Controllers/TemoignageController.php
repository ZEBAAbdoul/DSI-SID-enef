<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Temoignage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class TemoignageController extends Controller
{
    public function index(Request $request): View
    {
        $temoignages = Temoignage::query()
            ->when($request->filled('q'), function ($query) use ($request) {
                $q = '%' . $request->q . '%';
                $query->where(function ($sub) use ($q) {
                    $sub->where('auteur', 'ilike', $q)
                        ->orWhere('contenu', 'ilike', $q)
                        ->orWhere('formation_concernee', 'ilike', $q);
                });
            })
            ->when($request->filled('statut'), function ($query) use ($request) {
                $query->where('est_publie', $request->statut === 'publie');
            })
            ->orderBy('est_publie')       // les « en attente » d'abord
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        return view('admin.temoignages.index', compact('temoignages'));
    }

    /** Publier / dépublier. */
    public function toggle(Temoignage $temoignage): RedirectResponse
    {
        $temoignage->update(['est_publie' => ! $temoignage->est_publie]);

        return back()->with(
            'success',
            $temoignage->est_publie ? 'Témoignage publié sur le site.' : 'Témoignage retiré du site.'
        );
    }

    public function destroy(Temoignage $temoignage): RedirectResponse
    {
        if ($temoignage->image_url && File::exists(public_path($temoignage->image_url))) {
            File::delete(public_path($temoignage->image_url));
        }

        $temoignage->delete();

        return back()->with('success', 'Témoignage supprimé.');
    }
}