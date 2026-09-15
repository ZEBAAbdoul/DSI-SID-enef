<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Vente;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class GenerateDailyVenteReport extends Command
{
    protected $signature = 'rapport:ventes-journalier';

    protected $description = 'Générer automatiquement le rapport des ventes du jour à 23:59:59';

    public function handle()
    {
        $dateDebut = now()->startOfDay();
        $dateFin   = now()->endOfDay();

        $ventes = Vente::with(['produit', 'initiatedBy', 'validatedBy'])
            ->whereBetween('created_at', [$dateDebut, $dateFin])
            ->get();

        $stats = [
            'total'     => $ventes->count(),
            'validees'  => $ventes->where('status', 'validated')->count(),
            'rejetees'  => $ventes->where('status', 'rejected')->count(),
            'benefice'  => $ventes->where('status', 'validated')->sum('benefice'),
        ];

        $pdf = Pdf::loadView(
            'admin.ventes.rapports.pdf',
            compact('ventes', 'stats', 'dateDebut', 'dateFin')
        )->setPaper('A4', 'landscape');

        // 📂 Stockage du fichier
        $fileName = 'rapports/rapport_ventes_' . now()->format('Y-m-d') . '.pdf';

        Storage::disk('public')->put($fileName, $pdf->output());

        $this->info('✅ Rapport journalier généré avec succès');
    }
}