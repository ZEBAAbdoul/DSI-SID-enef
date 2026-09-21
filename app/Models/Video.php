<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'titre',
        'description',
        'url',
        'ordre',
        'est_visible',
    ];

    protected $casts = [
        'ordre' => 'integer',
        'est_visible' => 'boolean',
    ];

    /**
     * URL d'intégration (iframe) si la plateforme est supportée.
     *
     * @return string|null
     */
    public function getEmbedUrlAttribute(): ?string
    {
        $url = trim($this->url);

        // YouTube : watch / embed / shorts / youtu.be
        if (preg_match('~(?:youtube\.com/(?:watch\?v=|embed/|shorts/|live/)|youtu\.be/)([\w-]{6,})~i', $url, $m)) {
            return 'https://www.youtube-nocookie.com/embed/' . $m[1];
        }

        // Vimeo
        if (preg_match('~vimeo\.com/(?:video/)?(\d+)~i', $url, $m)) {
            return 'https://player.vimeo.com/video/' . $m[1];
        }

        // Dailymotion
        if (preg_match('~dailymotion\.com/video/([a-z0-9]+)~i', $url, $m)) {
            return 'https://www.dailymotion.com/embed/video/' . $m[1];
        }

        return null;
    }

    /**
     * Vignette de la vidéo (miniature YouTube) si disponible.
     */
    public function getThumbnailUrlAttribute(): ?string
    {
        $url = trim($this->url);

        if (preg_match('~(?:youtube\.com/(?:watch\?v=|embed/|shorts/|live/)|youtu\.be/)([\w-]{6,})~i', $url, $m)) {
            return 'https://img.youtube.com/vi/' . $m[1] . '/hqdefault.jpg';
        }

        return null;
    }

    /**
     * Nom de la plateforme pour l'affichage.
     */
    public function getPlatformAttribute(): string
    {
        $url = strtolower(trim($this->url));

        if (str_contains($url, 'youtube.com') || str_contains($url, 'youtu.be')) {
            return 'YouTube';
        }

        if (str_contains($url, 'vimeo.com')) {
            return 'Vimeo';
        }

        if (str_contains($url, 'dailymotion.com')) {
            return 'Dailymotion';
        }

        if (str_contains($url, 'facebook.com')) {
            return 'Facebook';
        }

        return 'Vidéo';
    }
}