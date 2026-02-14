<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Services\LoanService;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function __construct(protected LoanService $loanService)
    {
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $filter = $request->get('filter');

        // Mettre à jour les retards
        $this->loanService->updateOverdueLoans();

        $loans = $this->loanService->getUserLoans($user, $filter);

        // Compter par statut
        $counts = [
            'en_cours' => $user->loans()->where('statut', 'en_cours')->count(),
            'retourne' => $user->loans()->where('statut', 'retourne')->count(),
            'en_retard' => $user->loans()->where('statut', 'en_retard')->count(),
        ];

        $settings = Setting::forAdmin($user->getAdminId());

        return view('loans.index', compact('loans', 'filter', 'counts', 'settings'));
    }
}
