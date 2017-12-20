/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

(function ( $ ) {
	// Site title
	wp.customize( 'blogname', function ( value ) {
		value.bind( function ( to ) {
			$( '#site-title a' ).text( to );
		} );
	} );

	// Site description.
	wp.customize( 'blogdescription', function ( value ) {
		value.bind( function ( to ) {
			$( '#site-description' ).text( to );
		} );
	} );

	/*
	 * Shows a live preview of changing the site title color.
	 */
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {

			jQuery( '#site-title a' ).css( 'color', to );

		} ); // value.bind
	} ); // wp.customize

	// Site layout
	wp.customize( 'explore_site_layout', function ( value ) {
		value.bind( function ( layout ) {
			var layout_options = layout;
			if ( layout_options == 'wide_layout' ) {
				$( 'body' ).addClass( 'wide' );
			} else if( layout == 'boxed_layout' ) {
				$( 'body' ).removeClass( 'wide' );
				$( 'body' ).addClass( 'boxed' );
			}
		});
	});
})( jQuery );