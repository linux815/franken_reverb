<?php

namespace App\Services;

use App\DTO\MessageDTO;
use App\Events\MessageSent;
use App\Exceptions\MessageSendException;
use App\Models\Message;
use App\Repositories\Contracts\MessageRepositoryInterface;
use App\Services\Contracts\ChatServiceInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Throwable;

class ChatService implements ChatServiceInterface
{
    public function __construct(
        private readonly MessageRepositoryInterface $messageRepository,
    ) {}

    public function getConversationBetweenUsers(int $authUserId, int $otherUserId): Collection
    {
        return $this->messageRepository->getConversationBetween($authUserId, $otherUserId);
    }

    public function sendMessage(MessageDTO $dto): Message
    {
        try {
            $message = $this->messageRepository->createFromDTO($dto);

            event(new MessageSent($message));

            return $message;
        } catch (Throwable $e) {
            Log::error('Failed to send message', [
                'exception' => $e->getMessage(),
                'sender_id' => $dto->senderId,
                'receiver_id' => $dto->receiverId,
            ]);

            throw new MessageSendException('Failed to send message');
        }
    }
}
