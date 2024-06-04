<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\StoreUpdateAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\User;
use App\Utils\DAO;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use \Illuminate\Http\JsonResponse;
use \Illuminate\Database\ModelNotFoundException;

class AuthorController extends Controller
{


    /**
     * Display a listing of authors.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(
            DAO::paginateWithEagerLoading(Author::class, ['user', 'books'])
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUpdateAuthorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreUpdateAuthorRequest $request)
    {
        $validated_author_data = $request->validated();
        $author = Author::create($validated_author_data);

        return response()->json([
            'message' => 'Author created successfully!',
            'data' => $author,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $author = Author::find($id);

        if (!$author) {
            return response()->json([
                'message' => 'Author not found.',
            ], 404);
        }

        return response()->json([
            'message' => 'Author found successfully!',
            'data' => $author,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreUpdateAuthorRequest $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(StoreUpdateAuthorRequest $request, string $id)
    {

        $author = Author::find($id);
        if (!$author) {
            return response()->json([
                'message' => 'Author not found.',
            ], 404);
        }
        $author->update($request->validated());
        return response()->json([
            'message' => 'Author updated successfully!',
            'data' => $author,
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
        $author = Author::find($id);
        if (!$author) {
            return response()->json([
                'message' => 'User not found!',
            ], 404);
        }
        Book::where('author_id', $author->id)->delete();
        $author->delete();
        return response()->json([
            'message' => 'Author deleted successfully!',
            'user' => $author
        ], 200);
    }
}
