<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    protected $userService;
    public function __construct(UserService $movieService)
    {
        $this->userService = $movieService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return response()->json($users, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',  // Validate name if provided
            'email' => 'required|email|max:255|unique:users,email',  // Validate email if provided and ensure it's unique
            'password' => 'required|string|min:6',  // Validate password if provided
        ]);
        $users = User::create($validatedData);
        return response()->json($users, 201);
    }
    public function show(User $user)
    {
        $user = User::findOrFail($user->id);
        // $user = User::with('ratings')->findOrFail($user->id);

        return response()->json([
            'user' => $user,

        ], 200);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // return response()->json($request->all(), 200);
        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',  // Validate name if provided
            'email' => 'sometimes|email|max:255|unique:users,email',  // Validate email if provided and ensure it's unique
            'password' => 'sometimes|string|min:6',  // Validate password if provided
        ]);


        $user = $this->userService->updateUser($user, $validatedData);

        return response()->json($user, 201);
    }

    public function destroy(User $user)
    {
        $user = $this->userService->deleteUser($user);

        return $user;
    }
}
