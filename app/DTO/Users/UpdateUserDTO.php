<?php
namespace App\DTO\Users;

class UpdateUserDTO
{
    public function __construct(
        public string $name,
    )
    {}
}