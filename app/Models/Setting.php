<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Setting extends Model
{
    const CURRENCIES = [
        'GNF' => ['name' => 'Franc guinéen', 'symbol' => 'GNF'],
        'EUR' => ['name' => 'Euro', 'symbol' => '€'],
        'USD' => ['name' => 'Dollar US', 'symbol' => '$'],
        'XOF' => ['name' => 'Franc CFA (BCEAO)', 'symbol' => 'CFA'],
        'XAF' => ['name' => 'Franc CFA (BEAC)', 'symbol' => 'FCFA'],
        'GBP' => ['name' => 'Livre sterling', 'symbol' => '£'],
        'MAD' => ['name' => 'Dirham marocain', 'symbol' => 'MAD'],
        'TND' => ['name' => 'Dinar tunisien', 'symbol' => 'DT'],
        'DZD' => ['name' => 'Dinar algérien', 'symbol' => 'DA'],
    ];

    protected $fillable = [
        'admin_id',
        'loan_duration_days',
        'max_active_loans',
        'fine_per_day',
        'currency',
    ];

    protected function casts(): array
    {
        return [
            'loan_duration_days' => 'integer',
            'max_active_loans' => 'integer',
            'fine_per_day' => 'decimal:2',
        ];
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public static function forAdmin(int $adminId): self
    {
        return self::firstOrCreate(
            ['admin_id' => $adminId],
            [
                'loan_duration_days' => 14,
                'max_active_loans' => 3,
                'fine_per_day' => 1.00,
                'currency' => 'GNF',
            ]
        );
    }
}
