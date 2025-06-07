<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = $this->userService->getAllUsers();

        if ($users->isEmpty()) {
            return response()->json(['status' => 'error', 'message' => 'No users found'], 404);
        }

        return $this->userService->getAllUsers();
    }

    public function find($id)
    {
        $user = $this->userService->getUserById($id);

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User with id ' . $id . ' not found'], 404);
        }

        return response()->json($user, 200);
    }


    public function store(CreateUserRequest $request)
    {
        $validatedData = $request->validated();

        $user = $this->userService->createUser($validatedData);

        return response()->json([
            'status' => 'success',
            'data' => $user
        ], 202);
    }



    public function destroy($id)
    {
        if (!$this->userService->getUserById($id)) {
            return response()->json(['status' => 'error', 'message' => 'User with id ' . $id . ' not found'], 404);
        }

        return response()->json($this->userService->deleteUser($id), 204);
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $validatedData = $request->validated();

        if (!$this->userService->getUserById($id)) {
            return response()->json(['status' => 'error', 'message' => 'User with id ' . $id . ' not found'], 404);
        }

        $user = $this->userService->getUserById($id);
        $user->update($validatedData);

        return response()->json([
            'status' => 'success',
            'data' => $user
        ], 200);
    }
}
