<x-admin>
    @section('title', 'Informations')

    @if ($informations->isEmpty())
        <div class="card bg-white">
            <div class="card-body text-center text-muted py-5">
                <i class="far fa-bell-slash fa-2x d-block mb-3"></i>
                Aucune information pour le moment.
            </div>
        </div>
    @else
        <div class="row">
            @foreach ($informations as $information)
                @php
                    $ext = strtolower(pathinfo($information->fichier_nom ?? '', PATHINFO_EXTENSION));
                    $icone = match ($ext) {
                        'pdf' => 'fa-file-pdf text-danger',
                        'doc', 'docx' => 'fa-file-word text-primary',
                        'xls', 'xlsx' => 'fa-file-excel text-success',
                        'ppt', 'pptx' => 'fa-file-powerpoint text-warning',
                        'jpg', 'jpeg', 'png' => 'fa-file-image text-info',
                        default => 'fa-file text-secondary',
                    };
                    $estNouveau =
                        $information->publie_le && $information->publie_le->greaterThanOrEqualTo(now()->subDays(7));
                @endphp

                <div class="col-md-6 d-flex">
                    <div class="card bg-white w-100">
                        <div class="card-header bg-white">
                            <h3 class="card-title">
                                {{ $information->titre }}
                                @if ($estNouveau)
                                    <span class="badge badge-success ml-2">Nouveau</span>
                                @endif
                            </h3>
                            @if ($information->publie_le)
                                <div class="card-tools text-muted small">
                                    <i class="far fa-calendar-alt mr-1"></i>
                                    <time datetime="{{ $information->publie_le->toDateString() }}">
                                        {{ $information->publie_le->translatedFormat('d M Y') }}
                                    </time>
                                </div>
                            @endif
                        </div>

                        <div class="card-body bg-white">
                            {!! nl2br(e($information->contenu)) !!}
                        </div>

                        @if ($information->fichier_path)
                            <div class="card-footer bg-white">
                                <a href="{{ route('admin.informations.fichier', $information) }}"
                                    class="btn btn-sm btn-outline-secondary" target="_blank" rel="noopener">
                                    <i class="fas {{ $icone }} mr-1"></i>
                                    Télécharger : {{ $information->fichier_nom ?: 'Pièce jointe' }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @if ($informations->hasPages())
        <div class="d-flex justify-content-center">
            {{ $informations->links() }}
        </div>
    @endif
</x-admin>
