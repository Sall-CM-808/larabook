<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'copy_id',
        'date_emprunt',
        'date_retour_prevue',
        'date_retour_effective',
        'statut',
    ];

    protected function casts(): array
    {
        return [
            'date_emprunt' => 'date',
            'date_retour_prevue' => 'date',
            'date_retour_effective' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function copy(): BelongsTo
    {
        return $this->belongsTo(Copy::class);
    }

    public function fines(): HasMany
    {
        return $this->hasMany(Fine::class);
    }

    public function isOverdue(): bool
    {
        return $this->statut === 'en_cours'
            && Carbon::now()->greaterThan($this->date_retour_prevue);
    }

    public function daysOverdue(): int
    {
        if (!$this->isOverdue()) {
            return 0;
        }

        return Carbon::now()->diffInDays($this->date_retour_prevue);
    }
}
