<?php

namespace App\Imports;

use App\Models\Enseignant;
use App\Models\Note;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class NotesImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    private array $erreurs = [];
    private int $nombreImportees = 0;

    public function __construct(
        private readonly Enseignant $enseignant,
        private readonly string $formationId,
        private readonly ?string $sessionFormationId,
        private readonly int $matiereId,
        private readonly string $typeEvaluation,
        private readonly ?string $dateEvaluation,
    ) {}

    /**
     * Colonnes attendues dans le fichier Excel (première ligne = en-têtes) :
     * email | note | note_max (optionnel) | commentaire (optionnel)
     */
    public function collection(Collection $lignes): void
    {
        foreach ($lignes as $index => $ligne) {

            $numeroLigne = $index + 2; // +1 pour l'en-tête, +1 car index part de 0

            $email = trim((string) ($ligne['email'] ?? ''));
            $note  = $ligne['note'] ?? null;

            if (empty($email)) {
                $this->erreurs[] = "Ligne {$numeroLigne} : email manquant, ligne ignorée.";
                continue;
            }

            if ($note === null || $note === '') {
                $this->erreurs[] = "Ligne {$numeroLigne} : note manquante, ligne ignorée.";
                continue;
            }

            $eleve = User::where('email', $email)->first();

            if (! $eleve) {
                $this->erreurs[] = "Ligne {$numeroLigne} : aucun élève trouvé pour « {$email} ».";
                continue;
            }

            $noteMax = isset($ligne['note_max']) && $ligne['note_max'] !== ''
                ? (float) $ligne['note_max']
                : 20;

            if ((float) $note < 0 || (float) $note > $noteMax) {
                $this->erreurs[] = "Ligne {$numeroLigne} : note ({$note}) hors intervalle [0, {$noteMax}].";
                continue;
            }

            Note::create([
                'enseignant_id'        => $this->enseignant->id,
                'eleve_id'             => $eleve->id,
                'formation_id'         => $this->formationId,
                'session_formation_id' => $this->sessionFormationId,
                'matiere_id'           => $this->matiereId,
                'type_evaluation'      => $this->typeEvaluation,
                'note'                 => $note,
                'note_max'             => $noteMax,
                'commentaire'          => $ligne['commentaire'] ?? null,
                'date_evaluation'      => $this->dateEvaluation,
            ]);

            $this->nombreImportees++;
        }
    }

    public function getErreurs(): array
    {
        return $this->erreurs;
    }

    public function getNombreImportees(): int
    {
        return $this->nombreImportees;
    }
}