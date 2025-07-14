<?php

namespace App\DTO;

readonly class MessageDTO
{
    public function __construct(
        public int $senderId,
        public int $receiverId,
        public string $text,
    ) {}
}
