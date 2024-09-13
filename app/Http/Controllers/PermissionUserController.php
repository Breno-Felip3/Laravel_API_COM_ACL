<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class PermissionUserController extends Controller
{
    public function __construct(private UserRepository $userRepository)
    {}

    public function syncPermissionsOfUser($userId, Request $request)
    {
        $permissions = $request->permissions;
        $response = $this->userRepository->syncPermissions($userId, $permissions);
        if (! $response)
        {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json(['message' => 'ok'], 200);
    }

    public function getPermissionsOfUser($userId)
    {
        return $this->userRepository->getPermissionsByUserId($userId);
    }
}
