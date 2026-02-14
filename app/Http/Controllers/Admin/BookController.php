<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $adminId = $request->user()->getAdminId();

        $books = Book::where('admin_id', $adminId)
            ->with('category')
            ->withCount(['copies as total_copies', 'availableCopies as available_copies'])
            ->orderBy('titre')
            ->paginate(15);

        return view('admin.books.index', compact('books'));
    }

    public function create()
    {
        $categories = Category::orderBy('nom')->get();

        return view('admin.books.create', compact('categories'));
    }

    public function store(StoreBookRequest $request)
    {
        $data = $request->validated();
        $data['admin_id'] = $request->user()->getAdminId();

        if ($request->hasFile('couverture')) {
            $data['couverture'] = $request->file('couverture')->store('covers', 'public');
        }

        Book::create($data);

        return redirect()->route('admin.books.index')
            ->with('success', 'Livre ajouté avec succès.');
    }

    public function edit(Request $request, Book $book)
    {
        if ($book->admin_id !== $request->user()->getAdminId()) {
            abort(403);
        }

        $categories = Category::orderBy('nom')->get();

        return view('admin.books.edit', compact('book', 'categories'));
    }

    public function update(UpdateBookRequest $request, Book $book)
    {
        if ($book->admin_id !== $request->user()->getAdminId()) {
            abort(403);
        }

        $data = $request->validated();

        if ($request->hasFile('couverture')) {
            if ($book->couverture) {
                Storage::disk('public')->delete($book->couverture);
            }
            $data['couverture'] = $request->file('couverture')->store('covers', 'public');
        }

        $book->update($data);

        return redirect()->route('admin.books.index')
            ->with('success', 'Livre mis à jour avec succès.');
    }

    public function destroy(Request $request, Book $book)
    {
        if ($book->admin_id !== $request->user()->getAdminId()) {
            abort(403);
        }

        if ($book->couverture) {
            Storage::disk('public')->delete($book->couverture);
        }

        $book->delete();

        return redirect()->route('admin.books.index')
            ->with('success', 'Livre supprimé avec succès.');
    }
}
