<?php

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

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('invitation.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
    // return true;
});

Broadcast::channel('chat.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
    // return true;
});

Broadcast::channel('notification.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
    // return true;
});

Broadcast::channel('ReadNotification.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
    // return true;
});
