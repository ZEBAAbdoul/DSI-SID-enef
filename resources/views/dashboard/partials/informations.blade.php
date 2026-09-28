@php
    $informations = $informations ?? collect();
@endphp

<div class="card bg-white">
    <div class="card-header bg-white">
        <h3 class="card-title">Dernières informations</h3>
        <div class="card-tools">
            <a href="{{ route('admin.informations.consulter') }}" class="btn btn-primary btn-sm">
                Tout voir
            </a>
        </div>
    </div>
    <div class="card-body p-0 bg-white">
        <div class="table-responsive">
            <table class="table table-bordered mb-0 bg-white">
                <thead>
                    <tr>
                        <th>TITRE</th>
                        <th>FICHIER</th>
                        <th>PUBLIÉE LE</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($informations as $information)
                        @php
                            $ext = strtolower(pathinfo($information->fichier_nom ?? '', PATHINFO_EXTENSION));
                            $icone = match ($ext) {
                                'pdf'                => 'fa-file-pdf text-danger',
                                'doc', 'docx'        => 'fa-file-word text-primary',
                                'xls', 'xlsx'        => 'fa-file-excel text-success',
                                'ppt', 'pptx'        => 'fa-file-powerpoint text-warning',
                                'jpg', 'jpeg', 'png' => 'fa-file-image text-info',
                                default              => 'fa-file text-secondary',
                            };
                        @endphp
                        <tr>
                            <td>
                                {{ $information->titre }}
                                <div class="small text-muted">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($information->contenu), 120) }}
                                </div>
                            </td>
                            <td>
                                @if ($information->fichier_path)
                                    <a href="{{ route('admin.informations.fichier', $information) }}"
                                       target="_blank" rel="noopener">
                                        <i class="fas {{ $icone }}"></i>
                                        {{ $information->fichier_nom ?: 'Pièce jointe' }}
                                    </a>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>{{ $information->publie_le?->format('d/m/Y') ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">Aucune information pour le moment.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>