<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.{id}', static function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('presence.chat', static function ($user) {
    return ['id' => $user->id, 'name' => $user->name];
});
