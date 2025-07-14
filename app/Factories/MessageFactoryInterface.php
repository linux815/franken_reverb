<?php

namespace App\Factories;

use App\DTO\MessageDTO;
use App\Models\Message;

interface MessageFactoryInterface
{
    public function makeFromDTO(MessageDTO $dto): Message;
}
