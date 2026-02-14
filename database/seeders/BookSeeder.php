<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $sciFi = Category::where('slug', 'science-fiction')->first();
        $classique = Category::where('slug', 'litterature-classique')->first();
        $histoire = Category::where('slug', 'histoire')->first();
        $sciences = Category::where('slug', 'sciences')->first();
        $philosophie = Category::where('slug', 'philosophie')->first();
        $roman = Category::where('slug', 'roman')->first();

        $books = [
            [
                'titre' => 'Dune',
                'auteur' => 'Frank Herbert',
                'isbn' => '978-2-266-32008-7',
                'category_id' => $sciFi->id,
                'description' => 'Un chef-d\'œuvre de la science-fiction.',
                'couverture' => 'covers/dune.jpg',
                'annee_publication' => 1965,
            ],
            [
                'titre' => 'Le Petit Prince',
                'auteur' => 'Antoine de Saint-Exupéry',
                'isbn' => '978-2-07-061275-8',
                'category_id' => $classique->id,
                'description' => 'Un conte philosophique et poétique.',
                'couverture' => 'covers/le-petit-prince.jpg',
                'annee_publication' => 1943,
            ],
            [
                'titre' => 'Sapiens',
                'auteur' => 'Yuval Noah Harari',
                'isbn' => '978-2-226-25781-3',
                'category_id' => $histoire->id,
                'description' => 'Une brève histoire de l\'humanité.',
                'couverture' => 'covers/sapiens.jpg',
                'annee_publication' => 2011,
            ],
            [
                'titre' => 'Fondation',
                'auteur' => 'Isaac Asimov',
                'isbn' => '978-2-07-036024-4',
                'category_id' => $sciFi->id,
                'description' => 'Le cycle de Fondation, un classique de la SF.',
                'couverture' => 'covers/fondation.jpg',
                'annee_publication' => 1951,
            ],
            [
                'titre' => 'L\'Étranger',
                'auteur' => 'Albert Camus',
                'isbn' => '978-2-07-036002-2',
                'category_id' => $roman->id,
                'description' => 'Le roman emblématique d\'Albert Camus.',
                'couverture' => 'covers/letranger.jpg',
                'annee_publication' => 1942,
            ],
            [
                'titre' => 'Le Monde de Sophie',
                'auteur' => 'Jostein Gaarder',
                'isbn' => '978-2-02-021571-1',
                'category_id' => $philosophie->id,
                'description' => 'Roman sur l\'histoire de la philosophie.',
                'couverture' => 'covers/le-monde-de-sophie.jpg',
                'annee_publication' => 1991,
            ],
        ];

        foreach ($books as $book) {
            Book::firstOrCreate(['isbn' => $book['isbn']], $book);
        }
    }
}
