<?php

namespace App\Events;

use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserDeleted implements ShouldBroadcast
{
    /*
        SerializesModels se removio
        Se encarga de mantener la consistencia de nuestras instancias, al momento de despachar un evento
        Cuando se despacha un evento este trata de obtener una copia fresca de la base de datos
        pero como se elimino la instancia esta ya no existe en la base de datos,
        por este motivo es importante remover SerializesModels
    */
    use Dispatchable, InteractsWithSockets;

    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        \Log::debug( "User deleted {$this->user->name}" );
        /* En un mismo canal se pueden transmitir y echuchar diferentes eventos */
        return new Channel( 'users' );
    }
}
