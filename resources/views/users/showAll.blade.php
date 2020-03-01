@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Users</div>

                <ul id="users">
                    
                </ul>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push( 'scripts' )

<script>
    /* Libreria Axios nos permite realizar peticiones con JS vanilla */
    window.axios.get( '/api/users' )
        .then( ( response ) => {
            const usersElement = document.querySelector( '#users' );
            let users = response.data;

            users.forEach( ( user, index ) => {
                let li = document.createElement( 'li' );

                li.setAttribute( 'id', user.id );

                li.innerText = user.name;

                usersElement.appendChild( li );
            })
        })
</script>

<script>
    console.log( 'Hola' );
    Echo.channel( 'users' )
        .listen( 'UserCreated', (e) => {

            console.log( e );

            const usersElement = document.getElementById( 'users' );

            console.log( usersElement );

            let li = document.createElement( 'li' );

            li.setAttribute( 'id', e.user.id );

            li.innerText = e.user.name;

            console.log( li );

            usersElement.appendChild( li );

        })
        .listen( 'UserUpdated', (e) => {
            let li = document.getElementById( e.user.id );

            li.innerText = e.user.name;
        })
        .listen( 'UserDeleted', (e) => {
            let li = document.getElementById( e.user.id );
            li.parentNode.removeChild( li );
        })
</script>

@endpush
