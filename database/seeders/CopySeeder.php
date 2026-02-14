<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Copy;
use Illuminate\Database\Seeder;

class CopySeeder extends Seeder
{
    public function run(): void
    {
        $books = Book::all();

        foreach ($books as $book) {
            // 2 exemplaires par livre
            for ($i = 1; $i <= 2; $i++) {
                Copy::firstOrCreate(
                    ['code_barre' => 'LB-' . str_pad($book->id, 4, '0', STR_PAD_LEFT) . '-' . $i],
                    [
                        'book_id' => $book->id,
                        'etat' => 'disponible',
                    ]
                );
            }
        }
    }
}
