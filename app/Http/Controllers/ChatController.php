<?php

namespace App\Http\Controllers;

use App\Events\GreetingSent;
use App\Events\MessageSent;
use App\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showChat()
    {
        return view('chat.show');
    }

    public function messageRecived()
    {
        $rules = [
            'message' => ['required']
        ];
        request()->validate( $rules );
        broadcast( new MessageSent( request()->user(), request( 'message' ) ) );
        return response()->json( 'Message broadcast' );
    }

    public function greetRecived(User $user)
    {
        broadcast( new GreetingSent( $user, request()->user()->name." greeteed you" ) );
        broadcast( new GreetingSent( request()->user(), "You greeted ".request()->user()->name ) );
        return "Greeting {$user->name} from ".request()->user()->name;
    }
}
