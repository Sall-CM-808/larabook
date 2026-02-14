<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCopyRequest;
use App\Models\Book;
use App\Models\Copy;
use Illuminate\Http\Request;

class CopyController extends Controller
{
    public function index(Request $request)
    {
        $adminId = $request->user()->getAdminId();

        $copies = Copy::whereHas('book', fn ($q) => $q->where('admin_id', $adminId))
            ->with('book')
            ->orderBy('code_barre')
            ->paginate(20);

        return view('admin.copies.index', compact('copies'));
    }

    public function create(Request $request)
    {
        $adminId = $request->user()->getAdminId();
        $books = Book::where('admin_id', $adminId)->orderBy('titre')->get();

        return view('admin.copies.create', compact('books'));
    }

    public function store(StoreCopyRequest $request)
    {
        $adminId = $request->user()->getAdminId();
        $book = Book::where('id', $request->book_id)->where('admin_id', $adminId)->firstOrFail();

        Copy::create($request->validated());

        return redirect()->route('admin.copies.index')
            ->with('success', 'Exemplaire ajouté avec succès.');
    }

    public function edit(Request $request, Copy $copy)
    {
        $adminId = $request->user()->getAdminId();

        if ($copy->book->admin_id !== $adminId) {
            abort(403);
        }

        $books = Book::where('admin_id', $adminId)->orderBy('titre')->get();

        return view('admin.copies.edit', compact('copy', 'books'));
    }

    public function update(StoreCopyRequest $request, Copy $copy)
    {
        $adminId = $request->user()->getAdminId();

        if ($copy->book->admin_id !== $adminId) {
            abort(403);
        }

        $copy->update($request->validated());

        return redirect()->route('admin.copies.index')
            ->with('success', 'Exemplaire mis à jour avec succès.');
    }

    public function destroy(Request $request, Copy $copy)
    {
        $adminId = $request->user()->getAdminId();

        if ($copy->book->admin_id !== $adminId) {
            abort(403);
        }

        if ($copy->etat === 'emprunte') {
            return redirect()->route('admin.copies.index')
                ->with('error', 'Impossible de supprimer un exemplaire actuellement emprunté.');
        }

        $copy->delete();

        return redirect()->route('admin.copies.index')
            ->with('success', 'Exemplaire supprimé avec succès.');
    }
}
