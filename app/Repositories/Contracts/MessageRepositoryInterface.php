<?php


namespace App\Repositories\Contracts;

use App\DTO\MessageDTO;
use App\Models\Message;
use Illuminate\Support\Collection;

interface MessageRepositoryInterface
{
    public function getConversationBetween(int $authUserId, int $otherUserId): Collection;

    public function createFromDTO(MessageDTO $dto): Message;
}
