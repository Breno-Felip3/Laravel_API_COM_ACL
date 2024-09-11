<?php
namespace App\DTO\Permissions;

class CreatePermissionDTO
{
    public function __construct(
        public string $name,
        public string $description,
    )
    {}
}