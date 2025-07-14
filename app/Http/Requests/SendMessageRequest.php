<?php

namespace App\Http\Requests;

use App\DTO\MessageDTO;
use Illuminate\Foundation\Http\FormRequest;

class SendMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'message' => ['required', 'string', 'max:1000'],
        ];
    }

    public function toDTO(int $receiverId, int $senderId): MessageDTO
    {
        return new MessageDTO(
            senderId: $senderId,
            receiverId: $receiverId,
            text: $this->validated('message'),
        );
    }
}
