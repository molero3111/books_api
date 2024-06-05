<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateUserRequest;
use App\Models\Book;
use App\Models\Role;
use App\Models\User;
use App\Utils\DAO;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(
            DAO::paginateWithEagerLoading(User::class)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUpdateUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreUpdateUserRequest $request)
    {
        $validated_user_data = $request->validated();
        $validated_user_data['role_id'] = Role::where('name', $validated_user_data['role'])->first()->id;
        $user = User::create($validated_user_data);

        return response()->json([
            'message' => 'User created successfully!',
            'data' => $user,
        ], 200);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found.',
            ], 404);
        }

        return response()->json([
            'message' => 'User found successfully!',
            'data' => $user,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreUpdateUserRequest $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(StoreUpdateUserRequest $request, string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'message' => 'User not found.',
            ], 404);
        }

        $validated_data = $request->validated();
        if (isset($validated_data['role'])) {
            $validated_data['role_id'] = Role::where('name', $validated_data['role'])->first()->id;
        }
        if (isset($validated_data['password'])) {
            $user->password = bcrypt($validated_data['password']);
        }
        $user->update($validated_data);

        return response()->json([
            'message' => 'User updated successfully!',
            'data' => $user,
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'message' => 'User not found!',
            ], 404);
        }
        $author = $user->author;
        Book::where('author_id', $author->id)->delete();
        $author->delete();
        $user->delete();
        return response()->json([
            'message' => 'User deleted successfully!',
            'data' => $user
        ], 200);
    }
}
