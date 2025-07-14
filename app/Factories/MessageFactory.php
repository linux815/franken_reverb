<?php

namespace App\Factories;

use App\DTO\MessageDTO;
use App\Models\Message;

class MessageFactory implements MessageFactoryInterface
{
    public function makeFromDTO(MessageDTO $dto): Message
    {
        $message = new Message();

        $message->sender_id = $dto->senderId;
        $message->receiver_id = $dto->receiverId;
        $message->text = $dto->text;

        return $message;
    }
}
