jQuery( document ).ready( function( $ ) {
	"use strict";
	$( document).on( 'click', '.tab-nav li', function() {
		$( ".active" ).removeClass( "active" );
		$( this ).addClass( "active" );
		var nav = $( this ).attr( "nav" );
		$( ".box li.tab-box" ).css( "display","none" );
		$( ".box"+nav ).css( "display","block" );
		$( "#nav_value" ).val( nav );
	});
});