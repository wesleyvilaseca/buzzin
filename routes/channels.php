<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('order-created.{tenantId}', function ($user, $tenantId) {
    return $user->tenant_id == $tenantId;
});

Broadcast::channel('message-ticket-support-created.{userId}', function ($user, $userId) {
    return $user->id == $userId;
});

Broadcast::channel('message-ticket-tenant-created.{userId}', function ($user, $userId) {
    return $user->id == $userId;
});