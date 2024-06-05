<?php

namespace App\Exports;

use App\Models\Author;
use App\Models\Book;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AuthorsAndBooksExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new AuthorsSheet(),
            new BooksSheet(),
        ];
    }
}
