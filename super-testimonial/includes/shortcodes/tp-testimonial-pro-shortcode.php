<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

# shortocde
function tp_testimonial_pro_post_query( $atts, $content = null ) {
	$atts = shortcode_atts(
		array(
			'id' => "",
		),
		$atts
	);

	global $post, $paged, $query;	
	$postid = $atts['id'];

	$testimonial_cat_name          = get_post_meta( $postid, 'testimonial_cat_name', true );
	$tp_testimonial_themes         = get_post_meta( $postid, 'tp_testimonial_themes', true );
	$tp_testimonial_theme_style    = get_post_meta( $postid, 'tp_testimonial_theme_style', true );
	$grid_normal_column            = get_post_meta( $postid, 'grid_normal_column', true );
	$tp_order_by_option            = get_post_meta( $postid, 'tp_order_by_option', true );
	$tp_order_option               = get_post_meta( $postid, 'tp_order_option', true );
	$tp_testimonial_textalign      = get_post_meta( $postid, 'tp_testimonial_textalign', true );
	$tp_img_show_hide              = get_post_meta( $postid, 'tp_img_show_hide', true );
	$tp_img_border_radius          = get_post_meta( $postid, 'tp_img_border_radius', true );
	$tp_imgborder_width_option     = get_post_meta( $postid, 'tp_imgborder_width_option', true );
	$tp_imgborder_color_option     = get_post_meta( $postid, 'tp_imgborder_color_option', true );
	$tp_title_color_option         = get_post_meta( $postid, 'tp_title_color_option', true );
	$tp_title_fontsize_option      = get_post_meta( $postid, 'tp_title_fontsize_option', true );
	$tp_title_font_case            = get_post_meta( $postid, 'tp_title_font_case', true );
	$tp_title_font_style           = get_post_meta( $postid, 'tp_title_font_style', true );
	$tp_name_color_option          = get_post_meta( $postid, 'tp_name_color_option', true );
	$tp_name_fontsize_option       = get_post_meta( $postid, 'tp_name_fontsize_option', true );
	$tp_name_font_case             = get_post_meta( $postid, 'tp_name_font_case', true );
	$tp_name_font_style            = get_post_meta( $postid, 'tp_name_font_style', true );
	$tp_designation_show_hide      = get_post_meta( $postid, 'tp_designation_show_hide', true );
	$tp_desig_fontsize_option      = get_post_meta( $postid, 'tp_desig_fontsize_option', true );
	$tp_designation_color_option   = get_post_meta( $postid, 'tp_designation_color_option', true );
	$tp_designation_font_style     = get_post_meta( $postid, 'tp_designation_font_style', true );
	$tp_designation_case           = get_post_meta( $postid, 'tp_designation_case', true );
	$tp_company_show_hide          = get_post_meta( $postid, 'tp_company_show_hide', true );
	$tp_company_url_color          = get_post_meta( $postid, 'tp_company_url_color', true );
	$tp_content_color              = get_post_meta( $postid, 'tp_content_color', true );
	$tp_content_fontsize_option    = get_post_meta( $postid, 'tp_content_fontsize_option', true );
	$tp_content_bg_color           = get_post_meta( $postid, 'tp_content_bg_color', true );
	$tp_show_rating_option         = get_post_meta( $postid, 'tp_show_rating_option', true );
	$tp_rating_color               = get_post_meta( $postid, 'tp_rating_color', true );
	$tp_rating_fontsize_option     = get_post_meta( $postid, 'tp_rating_fontsize_option', true );
	$nav_text_color                = get_post_meta( $postid, 'nav_text_color', true );	
	$nav_bg_color                  = get_post_meta( $postid, 'nav_bg_color', true );
	$navigation_align              = get_post_meta( $postid, 'navigation_align', true );
	$pagination                    = get_post_meta( $postid, 'pagination', true );
	$pagination_bg_color           = get_post_meta( $postid, 'pagination_bg_color', true );
	$pagination_align              = get_post_meta( $postid, 'pagination_align', true );
	$dpstotoal_items               = get_post_meta( $postid, 'dpstotoal_items', true );
	
	$item_no                       = get_post_meta( $postid, 'item_no', true );
	$loop                          = get_post_meta( $postid, 'loop', true );
	$margin                        = get_post_meta( $postid, 'margin', true );
	$navigation                    = get_post_meta( $postid, 'navigation', true );
	$pagination                    = get_post_meta( $postid, 'pagination', true );
	$autoplay                      = get_post_meta( $postid, 'autoplay', true );
	$autoplay_speed                = get_post_meta( $postid, 'autoplay_speed', true );
	$stop_hover                    = get_post_meta( $postid, 'stop_hover', true );
	$autoplaytimeout               = get_post_meta( $postid, 'autoplaytimeout', true );
	$itemsdesktop                  = get_post_meta( $postid, 'itemsdesktop', true );
	$itemsdesktopsmall             = get_post_meta( $postid, 'itemsdesktopsmall', true );
	$itemsmobile                   = get_post_meta( $postid, 'itemsmobile', true );
	
	$filter_menu_styles            = get_post_meta( $postid, 'filter_menu_styles', true );
	$testimonial_filter_menu_text  = get_post_meta( $postid, 'testimonial_filter_menu_text', true );
	$filter_menu_alignment         = get_post_meta( $postid, 'filter_menu_alignment', true );
	$filter_menu_bg_color          = get_post_meta( $postid, 'filter_menu_bg_color', true );
	$filter_menu_bg_color_hover    = get_post_meta( $postid, 'filter_menu_bg_color_hover', true );
	$filter_menu_bg_color_active   = get_post_meta( $postid, 'filter_menu_bg_color_active', true );
	$filter_menu_font_color        = get_post_meta( $postid, 'filter_menu_font_color', true );
	$filter_menu_font_color_hover  = get_post_meta( $postid, 'filter_menu_font_color_hover', true );
	$filter_menu_font_color_active = get_post_meta( $postid, 'filter_menu_font_color_active', true );
	$nav_text_color_hover          = get_post_meta( $postid, 'nav_text_color_hover', true );
	$nav_bg_color_hover            = get_post_meta( $postid, 'nav_bg_color_hover', true );
	$pagination_bg_color_active    = get_post_meta( $postid, 'pagination_bg_color_active', true );
	$navigation_style              = get_post_meta( $postid, 'navigation_style', true );
	$pagination_style              = get_post_meta( $postid, 'pagination_style', true );
	$tp_item_bg_color              = get_post_meta( $postid, 'tp_item_bg_color', true );
	$tp_item_padding               = get_post_meta( $postid, 'tp_item_padding', true );
	$tp_show_item_bg_option        = get_post_meta( $postid, 'tp_show_item_bg_option', true );

	$args = array(
       'taxonomy' 	=> 'ktspcategory',
       'orderby' 	=> 'name',
       'order'   	=> 'ASC',
       'hide_empty' => 1,
    );
    
	$cats = get_categories($args);
	if ( ! empty( $testimonial_cat_name ) && ! empty( $cats ) ) {
		$tpprocat =  array();
		$num = count( $testimonial_cat_name );
		for ( $j=0; $j<$num; $j++ ) {
			array_push( $tpprocat, $testimonial_cat_name[$j] );
		}

		$args = array(
			'post_type' 		=> 'ktsprotype',
			'post_status' 		=> 'publish',
			'posts_per_page' 	=> $dpstotoal_items,
			'orderby' 			=> $tp_order_by_option,
			'order' 			=> $tp_order_option,
			'tax_query' 		=> array(
				array(
					'taxonomy' 	=> 'ktspcategory',
					'field' 	=> 'id',
					'terms' 	=> $tpprocat,
				)
			)
		);
	}else {
		$args = array(
			'post_type' 		=> 'ktsprotype',
			'post_status' 		=> 'publish',
			'posts_per_page' 	=> $dpstotoal_items,
			'orderby' 			=> $tp_order_by_option,
			'order' 			=> $tp_order_option,
		);
	}

  	$query = new WP_Query( $args );

	ob_start();
	
	switch ( $tp_testimonial_themes ) {
	    case '1':

	    		include __DIR__ . '/template/theme-1.php';

	        break;
	    case '2':

	    		include __DIR__ . '/template/theme-2.php';

	        break;
	    case '3':

				include __DIR__ . '/template/theme-3.php';
		
	        break; 
	    case '4':

				include __DIR__ . '/template/theme-4.php';

	        break; 
	    case '5':

				include __DIR__ . '/template/theme-5.php';

	        break;

	  //   case '6':

			// include __DIR__ . '/template/theme-6.php';

	  //       break; 
	  //   case '7':

			// include __DIR__ . '/template/theme-7.php';

	  //       break; 
	  //   case '8':

			// include __DIR__ . '/template/theme-8.php';

	  //       break; 
	  //   case '9':

			// include __DIR__ . '/template/theme-9.php';

	  //       break; 
	  //   case '10':

			// include __DIR__ . '/template/theme-10.php';

	  //       break;  
	  //   case '11':

			// include __DIR__ . '/template/theme-11.php';

	  //       break;  
	  //   case '12':

			// include __DIR__ . '/template/theme-12.php';

	  //       break;  
	  //   case '13':

			// include __DIR__ . '/template/theme-13.php';

	  //       break;  
	  //   case '14':

			// include __DIR__ . '/template/theme-14.php';

	  //       break;
	  //   case '15':

			// include __DIR__ . '/template/theme-15.php';

	  //       break; 
	  //   case '16':

			// include __DIR__ . '/template/theme-16.php';

	  //       break; 
	  //   case '17':

			// include __DIR__ . '/template/theme-17.php';

	  //       break; 
	  //   case '18':

			// include __DIR__ . '/template/theme-18.php';

	  //       break; 
	  //   case '19':

			// include __DIR__ . '/template/theme-19.php';

	  //       break; 
	    case '20':

				include __DIR__ . '/template/theme-20.php';

	        break; 
	  //   case '21':

			// include __DIR__ . '/template/theme-21.php';

	  //       break; 
	  //   case '22':

			// include __DIR__ . '/template/theme-22.php';

	  //       break; 
	  //   case '23':

			// include __DIR__ . '/template/theme-23.php';

	  //       break; 
	  //   case '24':

			// include __DIR__ . '/template/theme-24.php';

	  //       break; 
	  //   case '25':

			// include __DIR__ . '/template/theme-25.php';

	  //       break; 
	  //   case '26':
			// include __DIR__ . '/template/theme-26.php';

	  //       break; 
	  //   case '27':

			// include __DIR__ . '/template/theme-27.php';

	  //       break; 
	  //   case '28':

			// include __DIR__ . '/template/theme-28.php';

	  //       break; 
	  //   case '29':

			// include __DIR__ . '/template/theme-29.php';

	  //       break; 
	  //   case '30':

			// include __DIR__ . '/template/theme-30.php';

	  //       break;
	}
	return ob_get_clean();
}
add_shortcode( 'tptpro', 'tp_testimonial_pro_post_query' );