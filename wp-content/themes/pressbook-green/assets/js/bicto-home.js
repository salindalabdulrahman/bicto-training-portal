/* Bicto portal homepage: mobile menu and active-section highlighting. */
( function () {
	'use strict';

	document.documentElement.classList.add( 'bicto-js' );
	document.body.classList.add( 'bicto-js' );

	var toggle = document.querySelector( '.bicto-nav-toggle' );
	var nav = document.getElementById( 'bicto-nav' );

	function setMenu( open ) {
		if ( ! toggle || ! nav ) { return; }
		nav.classList.toggle( 'is-open', open );
		toggle.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
	}

	if ( toggle && nav ) {
		toggle.addEventListener( 'click', function () {
			setMenu( toggle.getAttribute( 'aria-expanded' ) !== 'true' );
		} );

		document.addEventListener( 'keydown', function ( e ) {
			if ( e.key === 'Escape' && toggle.getAttribute( 'aria-expanded' ) === 'true' ) {
				setMenu( false );
				toggle.focus();
			}
		} );

		nav.addEventListener( 'click', function ( e ) {
			if ( e.target.closest( 'a' ) ) { setMenu( false ); }
		} );
	}

	/* Mark the section currently in view as the active nav item. */
	var links = document.querySelectorAll( '.bicto-nav-links a[data-spy]' );
	if ( ! links.length || ! ( 'IntersectionObserver' in window ) ) { return; }

	var map = {};
	links.forEach( function ( a ) { map[ a.getAttribute( 'data-spy' ) ] = a; } );

	var observer = new IntersectionObserver( function ( entries ) {
		entries.forEach( function ( entry ) {
			if ( ! entry.isIntersecting ) { return; }
			links.forEach( function ( a ) { a.removeAttribute( 'aria-current' ); } );
			if ( map[ entry.target.id ] ) { map[ entry.target.id ].setAttribute( 'aria-current', 'page' ); }
		} );
	}, { rootMargin: '-45% 0px -50% 0px' } );

	Object.keys( map ).forEach( function ( id ) {
		var el = document.getElementById( id );
		if ( el ) { observer.observe( el ); }
	} );
}() );
