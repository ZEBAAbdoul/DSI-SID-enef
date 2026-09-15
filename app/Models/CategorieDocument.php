<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategorieDocument extends Model
{
    use HasFactory;

    protected $table = 'categories_documents';

    public $timestamps = false;

    protected $fillable = [
        'nom',
        'parent_id',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(CategorieDocument::class, 'parent_id');
    }

    public function enfants(): HasMany
    {
        return $this->hasMany(CategorieDocument::class, 'parent_id');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class, 'categorie_id');
    }
}