<?php

namespace App\Http\Controllers;

use App\Exports\AuthorsAndBooksExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportData()
    {
        return Excel::download(new AuthorsAndBooksExport, 'authors_and_books.xlsx');
    }
}
