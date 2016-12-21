/**
 * navigation.js
 *
 * Handles toggling the navigation menu for small screens.
 */
( function() {
	var container, button, menu;

	brm = document.getElementsByClassName( 'better-responsive-menu' )[0];
	container = document.getElementById( 'site-navigation' );
	if ( ! container || brm ) {
		return;
	}
	button = container.getElementsByClassName( 'menu-toggle' )[0];
	if ( 'undefined' === typeof button ) {
		return;
	}

	menu = container.getElementsByTagName( 'ul' )[0];

	// Hide menu toggle button if menu is empty and return early.
	if ( 'undefined' === typeof menu ) {
		button.style.display = 'none';
		return;
	}

	if ( -1 === menu.className.indexOf( 'menu-primary-container' ) ) {
		menu.className += 'menu-primary-container';
	}

	button.onclick = function() {
		if ( -1 !== container.className.indexOf( 'main-small-navigation' ) ) {
			container.className = container.className.replace( 'main-small-navigation', 'main-navigation' );
		} else {
			container.className = container.className.replace( 'main-navigation', 'main-small-navigation' );
		}
	};
} )();