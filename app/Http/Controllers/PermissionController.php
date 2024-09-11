<?php

namespace App\Http\Controllers;

use App\DTO\Permissions\CreatePermissionDTO;
use App\DTO\Permissions\UpdatePermissionDTO;
use App\Http\Requests\Permissions\PermissionStoreRequest;
use App\Http\Requests\Permissions\PermissionUpdateRequest;
use App\Repositories\PermissionRepository;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function __construct(private PermissionRepository $permissionRepository)
    {
    }
  
    public function index(Request $request)
    {
        $totalPerPage = $request->total_per_page;
        $page = $request->page;
        $filter = $request->filter;

        return $this->permissionRepository->getAllPermissions($totalPerPage, $page, $filter);
    }

    public function store(PermissionStoreRequest $request)
    {
        return $this->permissionRepository->create(new CreatePermissionDTO(...$request->validated()));
    }

    public function show(string $id)
    {
        $user = $this->permissionRepository->getPermissionById($id);

        if(!$user)
        {
            return response()->json(['message' => "Usuário não encontrado"], 404);
        }
        return $user;
    }

    public function update(PermissionUpdateRequest $request, string $id)
    {
        $objeticPermission = new UpdatePermissionDTO(...$request->validated());
        $response = $this->permissionRepository->update($objeticPermission, $id);

        if(! $response)
        {
            return response()->json(['message' => 'Permission not found'], 404);
        }
        return response()->json(['message' => "Permission updated with success"]);
    }

    public function destroy(string $id)
    {
        $response = $this->permissionRepository->delete($id);

        if(! $response)
        {
            return response()->json(['message' => 'Permission not found'], 404);
        }
        return response()->json([],204);
    }
}
