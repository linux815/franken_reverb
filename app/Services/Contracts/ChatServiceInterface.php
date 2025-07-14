<?php

namespace App\Services\Contracts;

use App\DTO\MessageDTO;
use App\Models\Message;
use Illuminate\Support\Collection;

interface ChatServiceInterface
{
    public function getConversationBetweenUsers(int $authUserId, int $otherUserId): Collection;

    public function sendMessage(MessageDTO $dto): Message;
}
