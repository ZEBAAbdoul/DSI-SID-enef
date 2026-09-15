@php $hidden = $hidden ?? false; @endphp
<article class="news-card" @if($hidden) aria-hidden="true" @endif>
    <div class="news-thumb">
        <img src="{{ $actualite->image }}" alt="{{ $hidden ? '' : $actualite->titre }}">
        <span class="date">{{ $actualite->created_at->translatedFormat('d M Y') }}</span>
    </div>
    <div class="news-body">
        <span class="news-cat">{{ $actualite->type_libelle }}</span>
        <h3>{{ $actualite->titre }}</h3>
        <p>{{ $actualite->chapo ?? $actualite->resume }}</p>
        <a class="news-link" href="{{ route('actualites.show', $actualite->slug) }}">Lire la suite
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M5 12h14M13 6l6 6-6 6" />
            </svg></a>
    </div>
</article>