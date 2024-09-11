<?php

namespace App\Http\Controllers;

use App\DTO\Users\CreateUserDTO;
use App\DTO\Users\UpdateUserDTO;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(private UserRepository $userRepository)
    {
    }
  
    public function index(Request $request)
    {
        $totalPerPage = $request->total_per_page;
        $page = $request->page;
        $filter = $request->filter;

        return $this->userRepository->getAllUsers($totalPerPage, $page, $filter);
    }

 
    public function store(UserStoreRequest $request)
    {
        return $this->userRepository->create(new CreateUserDTO(...$request->validated()));
    }

    public function show(string $id)
    {
        $user = $this->userRepository->getUserById($id);

        if(!$user)
        {
            return response()->json(['message' => "Usuário não encontrado"], 404);
        }
        return $user;
    }

    public function update(UserUpdateRequest $request, string $id)
    {
        $objeticUser = new UpdateUserDTO(...$request->validated());
        $response = $this->userRepository->update($objeticUser, $id);

        if(! $response)
        {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json(['message' => "User updated with success"]);
    }

    public function destroy(string $id)
    {
        $response = $this->userRepository->delete($id);

        if(! $response)
        {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json([],204);
    }
}
