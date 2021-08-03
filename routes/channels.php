<?php

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


// Verifica si el usuario esta logueado (Private)
Broadcast::channel('channel-ring', function ($user) {
     return true;
});

// Verifica si el usuario esta logueado (Presence)
Broadcast::channel('presence-ring', function ($user) {
     return $user;
});

////////////// TEST ///////////////////
// Verifica si el usuario esta logueado (Private)
Broadcast::channel('private-channel', function ($user) {
     return true;
});

// Verifica si el usuario esta logueado (Presence)
Broadcast::channel('presence-channel', function ($user) {
     return $user;
});

/////////// Channel for video-chat ???????
Broadcast::channel('user.{userId}', function ($user, $userId) {
  if ($user->id === $userId) {
    return array('name' => $user->name);
  }
});