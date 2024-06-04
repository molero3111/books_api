<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Models\Author;
use Illuminate\Http\Request;
use \Illuminate\Http\JsonResponse;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $authors = Author::with(['user', 'books'])->paginate(50);
        $current_page = $authors->currentPage();
        $last_page =  $authors->lastPage();
        return response()->json([
            'authors' => $authors->items(),
            'meta' => [
                'total' => $authors->total(),
                'previous_page' => $current_page > 1 ? $current_page - 1 : 1,
                'current_page' => $current_page,
                'next_page' => $current_page < $last_page ? $current_page + 1 : $last_page,
                'last_page' => $last_page,
            ],
        ]);
    }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param StoreAuthorRequest $request
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    // public function store(StoreAuthorRequest $request)
    // {
    //     $author = Author::create($request->validated());
    //     return response()->json($author, 201);
    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param Author $author
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    // public function show(Author $author)
    // {
    //     return response()->json($author);
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param UpdateAuthorRequest $request
    //  * @param Author $author
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    // public function update(UpdateAuthorRequest $request, Author $author)
    // {
    //     $author->update($request->validated());
    //     return response()->json($author);
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param Author $author
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    // public function destroy(Author $author)
    // {
    //     $author->delete();
    //     return response()->json(null, 204);
    // }
}
