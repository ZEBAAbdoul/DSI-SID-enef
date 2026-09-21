@php
    $compact = $compact ?? false;
    $reverse = $reverse ?? false;

    // Assez de cartes pour une boucle continue, même avec peu de témoignages
    $count = $temoignages->count();
    $cards = $count < 5
        ? collect(range(1, (int) ceil(5 / $count)))->flatMap(fn () => $temoignages)->values()
        : $temoignages;
@endphp

<div class="testi-track {{ $reverse ? 'testi-track--reverse' : '' }}"
    style="animation-duration: {{ max(35, $cards->count() * ($compact ? 6 : 8)) }}s;">
    @for ($g = 0; $g < 2; $g++)
        <div class="testi-group" @if ($g === 1) aria-hidden="true" @endif>
            @foreach ($cards as $temoignage)
                @php
                    $note = max(0, min(5, (int) $temoignage->note));
                    $initiales = \Illuminate\Support\Str::of($temoignage->auteur)
                        ->explode(' ')
                        ->filter()
                        ->map(fn ($mot) => mb_substr($mot, 0, 1))
                        ->take(2)
                        ->implode('');
                @endphp
                <article class="testi-card">
                    <span class="testi-quote" aria-hidden="true">“</span>

                    <div class="testi-stars" aria-label="Note : {{ $note }} sur 5">
                        {!! str_repeat('★', $note) !!}{!! str_repeat('☆', 5 - $note) !!}
                    </div>

                    <div class="testi-body">
                        <p class="testi-text">{{ $temoignage->contenu }}</p>
                        <button type="button" class="testi-more" hidden
                            @if ($g === 1) tabindex="-1" @endif>Lire la suite</button>
                    </div>

                    @if ($temoignage->formation_concernee)
                        <span class="testi-formation">{{ $temoignage->formation_concernee }}</span>
                    @endif

                    <div class="testi-who">
                        @if ($temoignage->image_url)
                            <img src="{{ asset($temoignage->image_url) }}" alt="{{ $temoignage->auteur }}"
                                class="testi-avatar" loading="lazy">
                        @else
                            <span class="testi-avatar testi-avatar-initials">{{ \Illuminate\Support\Str::upper($initiales) }}</span>
                        @endif
                        <div>
                            <span class="testi-name">{{ $temoignage->auteur }}</span>
                            @if ($temoignage->fonction)
                                <span class="testi-role">{{ $temoignage->fonction }}</span>
                            @endif
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @endfor
</div>