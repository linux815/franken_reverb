<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendMessageRequest;
use App\Http\Resources\MessageResource;
use App\Models\User;
use App\Services\Contracts\ChatServiceInterface;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Throwable;

class ChatController extends Controller
{
    public function __construct(
        private readonly ChatServiceInterface $chatService,
        private readonly Authenticatable $authenticatedUser,
    ) {}

    public function show(User $user): View
    {
        return view('chat', compact('user'));
    }

    public function index(User $user): AnonymousResourceCollection
    {
        $messages = $this->chatService->getConversationBetweenUsers(
            $this->authenticatedUser->getAuthIdentifier(),
            $user->id,
        );

        return MessageResource::collection($messages);
    }


    public function sendMessage(SendMessageRequest $request, User $user): MessageResource
    {
        try {
            $dto = $request->toDTO(receiverId: $user->id, senderId: $this->authenticatedUser->getAuthIdentifier());

            $message = $this->chatService->sendMessage($dto);

            return new MessageResource($message);
        } catch (Throwable $e) {
            report($e);

            abort(HttpResponse::HTTP_INTERNAL_SERVER_ERROR, 'Message could not be sent.');
        }
    }
}
