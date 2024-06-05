<?php

namespace App\Exports;

use App\Models\Author;
use Maatwebsite\Excel\Concerns\FromCollection;

class AuthorsSheet implements FromCollection
{
    public function title(): string
    {
        return 'Authors';
    }

    public function collection()
    {
        $authors = Author::all(['id', 'nickname', 'published_books']);
        $authors->prepend([
            'Author ID',
            'Nickname',
            'Published Books'
        ]);
        return $authors;
    }
}
