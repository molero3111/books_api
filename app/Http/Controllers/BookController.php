<?php

namespace App\Http\Controllers;

use App\Events\BookProcessed;
use App\Http\Requests\StoreUpdateBookRequest;
use App\Models\Author;
use App\Models\Book;
use App\Utils\DAO;
use \Illuminate\Http\JsonResponse;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(
            DAO::paginateWithEagerLoading(Book::class, ['author'])
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUpdateBookRequest $request
     * @return JsonResponse
     */
    public function store(StoreUpdateBookRequest $request)
    {
        $validated_book_data = $request->validated();
        $book = Book::create($validated_book_data);

        event(new BookProcessed($book->author));

        return response()->json([
            'message' => 'Book created successfully!',
            'data' => $book,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'message' => 'Book not found.',
            ], 404);
        }

        return response()->json([
            'message' => 'Book found successfully!',
            'data' => $book,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreUpdateBookRequest $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(StoreUpdateBookRequest $request, string $id)
    {

        $book = Book::find($id);
        if (!$book) {
            return response()->json([
                'message' => 'Book not found.',
            ], 404);
        }
        $book->update($request->validated());
        return response()->json([
            'message' => 'Book updated successfully!',
            'data' => $book,
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Author $author
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json([
                'message' => 'Book not found!',
            ], 404);
        }

        $book->delete();
        event(new BookProcessed($book->author));

        return response()->json([
            'message' => 'Book deleted successfully!',
            'data' => $book,
        ], 200);
    }
}
