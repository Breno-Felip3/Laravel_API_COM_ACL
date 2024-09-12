<?php
namespace App\Repositories;

use App\DTO\Users\CreateUserDTO;
use App\DTO\Users\UpdateUserDTO;
use App\Models\User;

class UserRepository
{
    public function __construct(protected User $user)
    {}

    public function getAllUsers($totalPerPage = 15, $page = 1, $filter = '')
    {
        $users = $this->user->where(function($query) use ($filter){
            if ($filter != "")
            {
                $query->where('name', 'LIKE', "%{$filter}%");
            }
        })
        ->paginate($totalPerPage, ['*'], 'page', $page);
        
        return $users;
    }

    public function create(CreateUserDTO $userDTO)
    {
        $data = (array) $userDTO;
        $data['password'] = bcrypt($data['password']);

        $user = $this->user->create($data);
        return $user;
    }

    public function getUserById($id)
    {
        return $this->user->find($id);  
    }

    public function update(UpdateUserDTO $userDTO, $id)
    {
        $user = $this->getUserById($id);
        if(!$user)
        {
           return false;
        }

        $data = (array) $userDTO;
        return $user->update($data);
    }

    public function delete($id)
    {
        $user = $this->getUserById($id);
        if(!$user)
        {
           return false;
        }
        
        return $user->delete();
    }

    public function findByEmail($email)
    {
        return $this->user->where('email', $email)->first();
    }
}