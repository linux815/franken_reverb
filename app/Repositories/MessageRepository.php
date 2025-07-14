<?php

namespace App\Repositories;

use App\DTO\MessageDTO;
use App\Factories\MessageFactoryInterface;
use App\Models\Message;
use App\Repositories\Contracts\MessageRepositoryInterface;
use Illuminate\Support\Collection;
use RuntimeException;

class MessageRepository implements MessageRepositoryInterface
{
    public function __construct(
        private readonly Message $model,
        private readonly MessageFactoryInterface $messageFactory,
    ) {}

    /**
     * Получить все сообщения между двумя пользователями, упорядоченные по времени
     */
    public function getConversationBetween(int $authUserId, int $otherUserId): Collection
    {
        return $this->model
            ->newQuery()
            ->betweenUsers($authUserId, $otherUserId)
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function createFromDTO(MessageDTO $dto): Message
    {
        $message = $this->messageFactory->makeFromDTO($dto);
        if (!$message->save()) {
            throw new RuntimeException('Failed to save message.');
        }

        return $message;
    }
}
