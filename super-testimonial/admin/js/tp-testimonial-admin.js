jQuery( document ).ready( function( $  ) {
	"use strict";
	
	$( "#tp_company_show" ).on( 'change', function() {
		var getImgVal = $( this ).val();
		if( getImgVal  == 2 ) {
			$( "#url_controller" ).hide( 'slow' );
		}
		if( getImgVal  == 1 ) {
			$( "#url_controller" ).show( 'slow' );
		}
	});

	$( "#tp_company_hide" ).on( 'change', function() {
		var getImgVal = $( this ).val();
		if( getImgVal  == 2 ) {
			$( "#url_controller" ).hide( 'slow' );
		}
		if( getImgVal  == 1 ) {
			$( "#url_controller" ).show( 'slow' );
		}
	});

	$( "#tp_show_rating_option" ).on( 'change', function() {
		var getRatVal = $( this ).val();
		if( getRatVal  == 2 ) {
			$( "#rating_controller, #rating_size_controller" ).hide( 'slow' );
		}
		if( getRatVal  == 1 ) {
			$( "#rating_controller, #rating_size_controller" ).show( 'slow' );
		}
	});

	$( "#tp_hide_rating_option" ).on( 'change', function() {
		var getRatVal = $( this ).val();
		if( getRatVal  == 2 ) {
			$( "#rating_controller, #rating_size_controller" ).hide( 'slow' );
		}
		if( getRatVal  == 1 ) {
			$( "#rating_controller, #rating_size_controller" ).show( 'slow' );
		}
	});

	$( "#tp_img_show" ).on( 'change', function() {
		var getImghIVal = $( this ).val();
		if( getImghIVal  == 2 ) {
			$( "#imgRadius_controller, #imgBorderController, #imgColor_controller" ).hide( 'slow' );
		}
		if( getImghIVal  == 1 ) {
			$( "#imgRadius_controller, #imgBorderController, #imgColor_controller" ).show( 'slow' );
		}
	});

	$( "#tp_img_hide" ).on( 'change', function() {
		var getImghIVal = $( this ).val();
		if( getImghIVal  == 2 ) {
			$( "#imgRadius_controller, #imgBorderController, #imgColor_controller" ).hide( 'slow' );
		}
		if( getImghIVal  == 1 ) {
			$( "#imgRadius_controller, #imgBorderController, #imgColor_controller" ).show( 'slow' );
		}
	});

	$( "#tp_designation_show" ).on( 'change', function() {
		var getDesigVal = $( this ).val();
		if( getDesigVal  == 2 ) {
			$( "#desig_size_controller, #desig_color_controller" ).hide( 'slow' );
		}
		if( getDesigVal  == 1 ) {
			$( "#desig_size_controller, #desig_color_controller" ).show( 'slow' );
		}
	});

	$( "#tp_designation_hide" ).on( 'change', function() {
		var getDesigVal = $( this ).val();
		if( getDesigVal  == 2 ) {
			$( "#desig_size_controller, #desig_color_controller" ).hide( 'slow' );
		}
		if( getDesigVal  == 1 ) {
			$( "#desig_size_controller, #desig_color_controller" ).show( 'slow' );
		}
	});

	$( "#pagination_true" ).on( 'change', function() {
		var getPagiVal = $( this ).val();
		if( getPagiVal  == 'false'  ) {
			$( "#pagi_align_controller, #pagi_color_controller, #pagi_color_active_controller, #pagi_style_controller" ).hide( 'slow' );
		}
		if( getPagiVal  == 'true'  ) {
			$( "#pagi_align_controller, #pagi_color_controller, #pagi_color_active_controller, #pagi_style_controller" ).show( 'slow' );
		}
	});

	$( "#pagination_false" ).on( 'change', function() {
		var getPagiVal = $( this ).val();
		if( getPagiVal  == 'false'  ) {
			$( "#pagi_align_controller, #pagi_color_controller, #pagi_color_active_controller, #pagi_style_controller" ).hide( 'slow' );
		}
		if( getPagiVal  == 'true'  ) {
			$( "#pagi_align_controller, #pagi_color_controller, #pagi_color_active_controller, #pagi_style_controller" ).show( 'slow' );
		}
	});

	$( "#navigation_true" ).on( 'change', function() {
		var getNaviVal = $( this ).val();
		if( getNaviVal  == 'false'  ) {
			$( "#navi_align_controller, #navi_color_controller, #navi_bgcolor_controller, #navi_color_hover_controller, #navi_bgcolor_hover_controller, #navi_style_controller" ).hide( 'slow' );
		}
		if( getNaviVal  == 'true'  ) {
			$(  "#navi_align_controller, #navi_color_controller, #navi_bgcolor_controller, #navi_color_hover_controller, #navi_bgcolor_hover_controller, #navi_style_controller" ).show( 'slow' );
		}
	});

	$( "#navigation_false" ).on( 'change', function() {
		var getNaviVal = $( this ).val();
		if( getNaviVal  == 'false'  ) {
			$( "#navi_align_controller, #navi_color_controller, #navi_bgcolor_controller, #navi_color_hover_controller, #navi_bgcolor_hover_controller, #navi_style_controller" ).hide( 'slow' );
		}
		if( getNaviVal  == 'true'  ) {
			$(  "#navi_align_controller, #navi_color_controller, #navi_bgcolor_controller, #navi_color_hover_controller, #navi_bgcolor_hover_controller, #navi_style_controller" ).show( 'slow' );
		}
	});

	$( document).on( 'click', '.tab-nav li', function() {
		$( ".active" ).removeClass( "active" );
		$( this ).addClass( "active" );
		var nav = $( this ).attr( "nav" );
		$( ".box li.tab-box" ).css( "display","none" );
		$( ".box"+nav ).css( "display","block" );
		$( "#nav_value" ).val( nav );
	});

	var slider = document.getElementById("myRange");
	var output = document.getElementById("autoplay_speed");
	output.innerHTML = slider.value;

	slider.oninput = function() { 
	  	output.setAttribute( 'value' ,this.value );
	}
});