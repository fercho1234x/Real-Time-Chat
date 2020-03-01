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

// Logica para el acceso a un canal privado, donde debe de tener un usuario identificado
Broadcast::channel('notifications', function ($user) {
    return $user != null;
});

Broadcast::channel('chat', function ($user) {
	if ($user != null) {
		return [ 'id' => $user->id, 'name' => $user->name ];
	}
});

/*
	El usuario logeado solo puede ver sus saludos o mensajes!
*/
Broadcast::channel('chat.greet.{receiver}', function ($user, $receiver) {
	return (int) $user->id === (int) $receiver;
});