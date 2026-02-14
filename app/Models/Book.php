<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'auteur',
        'isbn',
        'category_id',
        'description',
        'couverture',
        'annee_publication',
        'admin_id',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'admin_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function copies(): HasMany
    {
        return $this->hasMany(Copy::class);
    }

    public function availableCopies(): HasMany
    {
        return $this->hasMany(Copy::class)->where('etat', 'disponible');
    }

    public function isAvailable(): bool
    {
        return $this->availableCopies()->count() > 0;
    }
}
