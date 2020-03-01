require('./bootstrap');

// Canal publico, definido en nuestro evento

/*
Canal Publico

Echo.channel( 'notifications' )
	.listen('UserSessionChanged', ( e ) => {
		const notificationElement = document.querySelector( '#notifications' );

		notificationElement.innerText = e.message;

		notificationElement.classList.remove( 'invisible' );
		notificationElement.classList.remove( 'alert-success' );
		notificationElement.classList.remove( 'alert-danger' );

		notificationElement.classList.add( `alert-${ e.type }` )
	});
*/

/*
Canal Privado
*/

Echo.private( 'notifications' )
	.listen('UserSessionChanged', ( e ) => {
		const notificationElement = document.querySelector( '#notifications' );

		notificationElement.innerText = e.message;

		notificationElement.classList.remove( 'invisible' );
		notificationElement.classList.remove( 'alert-success' );
		notificationElement.classList.remove( 'alert-danger' );

		notificationElement.classList.add( `alert-${ e.type }` )
	});