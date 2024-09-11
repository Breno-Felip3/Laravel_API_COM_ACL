<?php
namespace App\DTO\Permissions;

class UpdatePermissionDTO
{
    public function __construct(
        public string $name,
        public string $description,
    )
    {}
}