<?php

namespace App\Services;

use App\Models\Copy;
use App\Models\Fine;
use App\Models\Loan;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LoanService
{
    private function getSettings(int $adminId): Setting
    {
        return Setting::forAdmin($adminId);
    }

    public function createLoan(User $user, Copy $copy): Loan
    {
        if (!$copy->isAvailable()) {
            throw new \Exception('Cet exemplaire n\'est pas disponible.');
        }

        $settings = $this->getSettings($user->getAdminId());

        $activeLoans = Loan::where('user_id', $user->id)
            ->whereIn('statut', ['en_cours', 'en_retard'])
            ->count();

        if ($activeLoans >= $settings->max_active_loans) {
            throw new \Exception('Nombre maximum d\'emprunts actifs atteint (' . $settings->max_active_loans . ').');
        }

        return DB::transaction(function () use ($user, $copy, $settings) {
            $loan = Loan::create([
                'user_id' => $user->id,
                'copy_id' => $copy->id,
                'date_emprunt' => Carbon::now(),
                'date_retour_prevue' => Carbon::now()->addDays($settings->loan_duration_days),
                'statut' => 'en_cours',
            ]);

            $copy->update(['etat' => 'emprunte']);

            return $loan;
        });
    }

    public function returnLoan(Loan $loan): Loan
    {
        if ($loan->statut === 'retourne') {
            throw new \Exception('Cet emprunt a déjà été retourné.');
        }

        $adminId = $loan->copy->book->admin_id;
        $settings = $this->getSettings($adminId);

        return DB::transaction(function () use ($loan, $settings) {
            $now = Carbon::now();

            $loan->update([
                'date_retour_effective' => $now,
                'statut' => 'retourne',
            ]);

            $loan->copy->update(['etat' => 'disponible']);

            if ($now->greaterThan($loan->date_retour_prevue)) {
                $daysLate = $now->diffInDays($loan->date_retour_prevue);
                $amount = $daysLate * $settings->fine_per_day;

                Fine::create([
                    'loan_id' => $loan->id,
                    'montant' => $amount,
                    'motif' => "Retard de {$daysLate} jour(s)",
                    'reglee' => false,
                ]);
            }

            return $loan->fresh();
        });
    }

    public function updateOverdueLoans(): int
    {
        return Loan::where('statut', 'en_cours')
            ->where('date_retour_prevue', '<', Carbon::now())
            ->update(['statut' => 'en_retard']);
    }

    public function getUserLoans(User $user, ?string $filter = null)
    {
        $query = Loan::where('user_id', $user->id)
            ->with(['copy.book', 'fines']);

        if ($filter === 'en_cours') {
            $query->where('statut', 'en_cours');
        } elseif ($filter === 'retourne') {
            $query->where('statut', 'retourne');
        } elseif ($filter === 'en_retard') {
            $query->where('statut', 'en_retard');
        }

        return $query->orderByDesc('date_emprunt')->get();
    }

    public function calculateFineAmount(Loan $loan): float
    {
        if (!$loan->isOverdue()) {
            return 0;
        }

        $adminId = $loan->copy->book->admin_id;
        $settings = $this->getSettings($adminId);

        return $loan->daysOverdue() * $settings->fine_per_day;
    }
}
