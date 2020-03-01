@extends('layouts.app')

@push('styles')
<style type="text/css">
    #users > li {
        cursor: pointer;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Chat</div>

                <div class="card-body">

                    <div class="row p-2">
                        <div class="col-10">
                            <div class="row">
                                <div class="col-12 border rounded-lg p-3">
                                    <ul id="messages" class="list-unstyled overflow-auto" style="height: 45vh;">
                                    </ul>
                                </div>
                            </div>
                            <form>
                                <div class="row py-3">
                                    <div class="col-10">
                                        <input class="form-control" id="message" type="" name="">
                                    </div>
                                    <div class="col-2">
                                        <button type="submit" id="send" class="btn btn-outline-primary btn-block">Send</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-2">
                            <p>
                                <strong>Online Now</strong>
                                <ul id="users" class="list-unstyled overflow-auto text-info" style="height: 45vh;">
                                </ul>
                            </p>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push( 'scripts' )
<script type="text/javascript">
    const usersElement = document.getElementById( 'users' );
    const messagesElement = document.getElementById( 'messages' );
    /*
        .join canal de presencia 
    */
    Echo.join( 'chat' )
        // Tendra la lista de usuarios
        .here( users => {
            users.forEach( ( user, index ) => {
                let li = document.createElement( 'li' );

                li.setAttribute( 'id', user.id );
                li.setAttribute('onclick', 'greetUser("' + user.id + '")');

                li.innerText = user.name;

                usersElement.appendChild( li );
            })
        })
        // Servira para reaccionar cuando un usuario se une a un canal
        .joining( user => {
            let li = document.createElement( 'li' );

            li.setAttribute( 'id', user.id );
            li.setAttribute('onclick', 'greetUser("' + user.id + '")');

            li.innerText = user.name;

            usersElement.appendChild( li );
        })
        // Servira para reaccionar cunado un usuario abandona un canal
        .leaving( user => {
            let li = document.getElementById( user.id );
            li.parentNode.removeChild( li );
        })
        .listen( 'MessageSent', (e) => {
            let li = document.createElement( 'li' );

            li.setAttribute( 'id', e.user.id );

            li.innerText = e.user.name + ':' + e.message;

            messagesElement.appendChild( li );
        })
</script>

<script type="text/javascript">
    const sendElement = document.getElementById( 'send' );
    const messageElement = document.getElementById( 'message' );

    sendElement.addEventListener( 'click', (e) => {
        e.preventDefault();

        window.axios.post( '/chat/message', {
            message: messageElement.value
        });

        messageElement.value = '';
    })
</script>

<script type="text/javascript">
    function greetUser( id ) {
        window.axios.post(`/chat/greet/${ id }`);
    }
</script>

<script type="text/javascript">
    Echo.private('chat.greet.{{ auth()->user()->id }}')
    .listen('GreetingSent', (e) => {
        let li = document.createElement( 'li' );

        li.innerText = e.message;
        li.classList.add( 'text-success' );

        messagesElement.appendChild( li );
    });
</script>

@endpush