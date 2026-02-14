<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $adminId = $request->user()->getAdminId();
        $search = $request->get('search');
        $filterBy = $request->get('filter_by', 'titre');
        $categorySlug = $request->get('category');

        $query = Book::where('admin_id', $adminId)
            ->with(['category', 'copies'])
            ->withCount(['copies as total_copies', 'availableCopies as available_copies']);

        if ($search) {
            if ($filterBy === 'auteur') {
                $query->where('auteur', 'like', "%{$search}%");
            } elseif ($filterBy === 'categorie') {
                $query->whereHas('category', fn ($q) => $q->where('nom', 'like', "%{$search}%"));
            } else {
                $query->where('titre', 'like', "%{$search}%");
            }
        }

        if ($categorySlug) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $categorySlug));
        }

        $books = $query->paginate(12);
        $categories = Category::orderBy('nom')->get();

        return view('catalog.index', compact('books', 'categories', 'search', 'filterBy', 'categorySlug'));
    }

    public function show(Request $request, Book $book)
    {
        $adminId = $request->user()->getAdminId();

        if ($book->admin_id !== $adminId) {
            abort(403);
        }

        $book->load(['category', 'copies']);

        return view('catalog.show', compact('book'));
    }
}
