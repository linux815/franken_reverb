<?php

namespace App\DTO;

readonly class UpdateUserProfileDTO
{
    public function __construct(
        public string $name,
        public string $email,
    ) {}
}
