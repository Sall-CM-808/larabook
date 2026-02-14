<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Setting;
use App\Services\LoanService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(protected LoanService $loanService)
    {
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $adminId = $user->getAdminId();

        // Mettre à jour les emprunts en retard
        $this->loanService->updateOverdueLoans();

        // Catalogue: livres scopés par admin_id
        $search = $request->get('search');
        $filterBy = $request->get('filter_by', 'titre');

        $booksQuery = Book::where('admin_id', $adminId)
            ->with(['category', 'copies'])
            ->withCount(['copies as total_copies', 'availableCopies as available_copies']);

        if ($search) {
            if ($filterBy === 'auteur') {
                $booksQuery->where('auteur', 'like', "%{$search}%");
            } elseif ($filterBy === 'categorie') {
                $booksQuery->whereHas('category', fn ($q) => $q->where('nom', 'like', "%{$search}%"));
            } else {
                $booksQuery->where('titre', 'like', "%{$search}%");
            }
        }

        $books = $booksQuery->paginate(12);

        // Emprunts de l'utilisateur
        $filter = $request->get('loan_filter');
        $loans = $this->loanService->getUserLoans($user, $filter);

        $settings = Setting::forAdmin($adminId);

        return view('dashboard', compact('books', 'loans', 'search', 'filterBy', 'filter', 'settings'));
    }
}
