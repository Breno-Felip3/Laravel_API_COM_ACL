<?php
namespace App\DTO\Users;

class CreateUserDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password
    )
    {}
}