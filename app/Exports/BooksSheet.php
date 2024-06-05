<?php

namespace App\Exports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\FromCollection;

class BooksSheet implements FromCollection
{
    public function title(): string
    {
        return 'Books';
    }

    public function collection()
    {
        $books = Book::all(['id', 'author_id', 'title', 'genre', 'published_at']);
        $books->prepend([
            'Book ID',
            'Author ID',
            'title',
            'Genre',
            'Published At'
        ]);
        return $books;
    }
}
