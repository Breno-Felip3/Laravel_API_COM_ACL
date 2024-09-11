<?php
namespace App\Repositories;

use App\DTO\Permissions\CreatePermissionDTO;
use App\Models\Permission;

class PermissionRepository
{
    public function __construct(protected Permission $permission)
    {}

    public function getAllPermissions($totalPerPage = 15, $page = 1, $filter = '')
    {
        $permissions = $this->permission->where(function($query) use ($filter){
            if ($filter != "")
            {
                $query->where('name', 'LIKE', "%{$filter}%");
            }
        })
        ->paginate($totalPerPage, ['*'], 'page', $page);
        
        return $permissions;
    }

    public function create(CreatePermissionDTO $permissionDTO)
    {
        $data = (array) $permissionDTO;
        return  $this->permission->create($data);
    }

    public function getPermissionById($id)
    {
        return $this->permission->find($id);  
    }

    public function update($permissionDTO, $id)
    {
        if(!$permission = $this->getPermissionById($id))
        {
           return false;
        }

        $data = (array) $permissionDTO;
        return $permission->update($data);
    }

    public function delete($id)
    {
        $permission = $this->getPermissionById($id);
        if(!$permission)
        {
           return false;
        }
        
        return $permission->delete();
    }
}