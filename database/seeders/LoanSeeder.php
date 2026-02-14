<?php

namespace Database\Seeders;

use App\Models\Copy;
use App\Models\Fine;
use App\Models\Loan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class LoanSeeder extends Seeder
{
    public function run(): void
    {
        $jean = User::where('email', 'jean.martin@larabook.com')->first();
        $sophie = User::where('email', 'sophie.bernard@larabook.com')->first();

        // Emprunt en cours (Fondation pour Jean)
        $copyFondation = Copy::whereHas('book', fn ($q) => $q->where('titre', 'Fondation'))
            ->where('etat', 'disponible')
            ->first();

        if ($copyFondation) {
            $loan1 = Loan::firstOrCreate(
                ['copy_id' => $copyFondation->id, 'user_id' => $jean->id, 'statut' => 'en_cours'],
                [
                    'date_emprunt' => Carbon::now()->subDays(5),
                    'date_retour_prevue' => Carbon::now()->addDays(9),
                ]
            );
            $copyFondation->update(['etat' => 'emprunte']);
        }

        // Emprunt en retard (Sapiens pour Jean) — avec amende
        $copySapiens = Copy::whereHas('book', fn ($q) => $q->where('titre', 'Sapiens'))
            ->where('etat', 'disponible')
            ->first();

        if ($copySapiens) {
            $loan2 = Loan::firstOrCreate(
                ['copy_id' => $copySapiens->id, 'user_id' => $jean->id, 'statut' => 'en_retard'],
                [
                    'date_emprunt' => Carbon::now()->subDays(20),
                    'date_retour_prevue' => Carbon::now()->subDays(6),
                ]
            );
            $copySapiens->update(['etat' => 'emprunte']);

            Fine::firstOrCreate(
                ['loan_id' => $loan2->id],
                [
                    'montant' => 5.00,
                    'motif' => 'retard',
                    'reglee' => false,
                ]
            );
        }

        // Emprunt retourné (Dune pour Sophie)
        $copyDune = Copy::whereHas('book', fn ($q) => $q->where('titre', 'Dune'))
            ->where('etat', 'disponible')
            ->first();

        if ($copyDune) {
            Loan::firstOrCreate(
                ['copy_id' => $copyDune->id, 'user_id' => $sophie->id, 'statut' => 'retourne'],
                [
                    'date_emprunt' => Carbon::now()->subDays(30),
                    'date_retour_prevue' => Carbon::now()->subDays(16),
                    'date_retour_effective' => Carbon::now()->subDays(18),
                ]
            );
            // Exemplaire rendu => disponible
        }

        // Emprunt en cours (Le Petit Prince pour Sophie)
        $copyPP = Copy::whereHas('book', fn ($q) => $q->where('titre', 'Le Petit Prince'))
            ->where('etat', 'disponible')
            ->first();

        if ($copyPP) {
            Loan::firstOrCreate(
                ['copy_id' => $copyPP->id, 'user_id' => $sophie->id, 'statut' => 'en_cours'],
                [
                    'date_emprunt' => Carbon::now()->subDays(3),
                    'date_retour_prevue' => Carbon::now()->addDays(11),
                ]
            );
            $copyPP->update(['etat' => 'emprunte']);
        }
    }
}
