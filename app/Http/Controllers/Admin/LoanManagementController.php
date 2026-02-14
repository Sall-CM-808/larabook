<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLoanRequest;
use App\Models\Book;
use App\Models\Copy;
use App\Models\Loan;
use App\Models\Setting;
use App\Models\User;
use App\Services\LoanService;
use Illuminate\Http\Request;

class LoanManagementController extends Controller
{
    public function __construct(protected LoanService $loanService)
    {
    }

    public function index(Request $request)
    {
        $adminId = $request->user()->getAdminId();

        $this->loanService->updateOverdueLoans();

        $filter = $request->get('filter');
        $search = $request->get('search');

        $query = Loan::whereHas('copy.book', fn ($q) => $q->where('admin_id', $adminId))
            ->with(['user', 'copy.book', 'fines']);

        if ($filter) {
            $query->where('statut', $filter);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%")
                    ->orWhere('matricule', 'like', "%{$search}%"))
                  ->orWhereHas('copy.book', fn ($b) => $b->where('titre', 'like', "%{$search}%"));
            });
        }

        $loans = $query->orderByDesc('date_emprunt')->paginate(20);

        $scopedLoans = Loan::whereHas('copy.book', fn ($q) => $q->where('admin_id', $adminId));
        $counts = [
            'all' => (clone $scopedLoans)->count(),
            'en_cours' => (clone $scopedLoans)->where('statut', 'en_cours')->count(),
            'en_retard' => (clone $scopedLoans)->where('statut', 'en_retard')->count(),
            'retourne' => (clone $scopedLoans)->where('statut', 'retourne')->count(),
        ];

        $settings = Setting::forAdmin($adminId);

        return view('admin.loans.index', compact('loans', 'filter', 'search', 'counts', 'settings'));
    }

    public function create(Request $request)
    {
        $adminId = $request->user()->getAdminId();

        $users = User::where('admin_id', $adminId)
            ->whereHas('roles', fn ($q) => $q->where('slug', 'etudiant'))
            ->orderBy('name')
            ->get();

        $books = Book::where('admin_id', $adminId)
            ->with(['copies' => fn ($q) => $q->where('etat', 'disponible')])
            ->whereHas('copies', fn ($q) => $q->where('etat', 'disponible'))
            ->orderBy('titre')
            ->get();

        $settings = Setting::forAdmin($adminId);

        return view('admin.loans.create', compact('users', 'books', 'settings'));
    }

    public function store(StoreLoanRequest $request)
    {
        $adminId = $request->user()->getAdminId();

        $user = User::where('id', $request->user_id)
            ->where('admin_id', $adminId)
            ->firstOrFail();

        $copy = Copy::whereHas('book', fn ($q) => $q->where('admin_id', $adminId))
            ->where('id', $request->copy_id)
            ->firstOrFail();

        try {
            $this->loanService->createLoan($user, $copy);

            return redirect()->route('admin.loans.index')
                ->with('success', 'Emprunt créé avec succès.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function returnLoan(Request $request, Loan $loan)
    {
        $adminId = $request->user()->getAdminId();

        if ($loan->copy->book->admin_id !== $adminId) {
            abort(403);
        }

        try {
            $this->loanService->returnLoan($loan);

            return redirect()->route('admin.loans.index')
                ->with('success', 'Retour enregistré avec succès.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
