<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function tps_super_testimonials_add_submenu_items() {
	add_submenu_page( 'edit.php?post_type=ktsprotype', __( 'Generate Shortcode', 'ktsttestimonialpro' ), __( 'Generate Shortcode', 'ktsttestimonialpro' ), 'manage_options', 'post-new.php?post_type=tptscode' );
}
add_action( 'admin_menu', 'tps_super_testimonials_add_submenu_items' );


function ps_super_testimonials_shortcode_generator_type() {
	// Set UI labels for Custom Post Type
	$labels = array(
		'name'                => _x( 'Testimonials', 'Post Type General Name', 'ktsttestimonialpro' ),
		'singular_name'       => _x( 'Testimonial', 'Post Type Singular Name', 'ktsttestimonialpro' ),
		'menu_name'           => __( 'Testimonials', 'ktsttestimonialpro' ),
		'parent_item_colon'   => __( 'Parent Shortcode', 'ktsttestimonialpro' ),
		'all_items'           => __( 'All Shortcode', 'ktsttestimonialpro' ),
		'view_item'           => __( 'View Shortcode', 'ktsttestimonialpro' ),
		'add_new_item'        => __( 'Generate Shortcode', 'ktsttestimonialpro' ),
		'add_new'             => __( 'Generate New Shortcode', 'ktsttestimonialpro' ),
		'edit_item'           => __( 'Edit Testimonial', 'ktsttestimonialpro' ),
		'update_item'         => __( 'Update Testimonial', 'ktsttestimonialpro' ),
		'search_items'        => __( 'Search Testimonial', 'ktsttestimonialpro' ),
		'not_found'           => __( 'Shortcode Not Found', 'ktsttestimonialpro' ),
		'not_found_in_trash'  => __( 'Shortcode Not found in Trash', 'ktsttestimonialpro' ),
	);

	// Set other options for Custom Post Type
	$args = array(
		'label'               => __( 'Testimonial Shortcode', 'ktsttestimonialpro' ),
		'description'         => __( 'Shortcode news and reviews', 'ktsttestimonialpro' ),
		'labels'              => $labels,
		'supports'            => array( 'title' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu' 		  => 'edit.php?post_type=ktsprotype',
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	// Registering your Custom Post Type
	register_post_type( 'tptscode', $args );
}
add_action( 'init', 'ps_super_testimonials_shortcode_generator_type' );	


function tps_super_testimonials_shortcode_clmn( $columns ) {
	return array_merge( $columns, 
	    array( 
	  		'shortcode' 	=> __( 'Shortcode', 'ktsttestimonialpro' ),
	  		'doshortcode' 	=> __( 'Template Shortcode', 'ktsttestimonialpro' ) 
	  	)
	);
}
add_filter( 'manage_tptscode_posts_columns' , 'tps_super_testimonials_shortcode_clmn' );


function tps_super_testimonials_shortcode_clmn_display( $tpcp_column, $post_id ) {
	if ( $tpcp_column == 'shortcode' ) { ?>
	<input style="background:#ddd" type="text" onClick="this.select();" value="[tptpro <?php echo 'id=&quot;'.$post_id.'&quot;';?>]" />
	 <?php
	}
 	if ( $tpcp_column == 'doshortcode' ) { ?>
  	<textarea cols="40" rows="2" style="background:#ddd;" onClick="this.select();" ><?php echo '<?php echo do_shortcode( "[tptpro id='; echo "'".$post_id."']"; echo '" ); ?>'; ?></textarea>
  	<?php
 	}
}	
add_action( 'manage_tptscode_posts_custom_column' , 'tps_super_testimonials_shortcode_clmn_display', 10, 2 );


// Register Testimonial Meta Box
function tp_testimonial_shortcode_register_meta_boxes() {
	$attend = array( 'tptscode' );
    add_meta_box( 
        'custom_meta_box_id',
        __( 'Testimonial Settings', 'ktsttestimonialpro' ),
        'tp_testimonials_display_post_type_func',
       	$attend,
        'normal'
    );
}
add_action( 'add_meta_boxes', 'tp_testimonial_shortcode_register_meta_boxes' );


# Call Back Function...
function tp_testimonials_display_post_type_func( $post, $args ) {

	#Call get post meta.
	$testimonial_cat_name 			= get_post_meta( $post->ID, 'testimonial_cat_name', true );
	$tp_testimonial_themes 			= get_post_meta( $post->ID, 'tp_testimonial_themes', true );
	$tp_testimonial_theme_style		= get_post_meta( $post->ID, 'tp_testimonial_theme_style', true );
	$tp_order_by_option 			= get_post_meta( $post->ID, 'tp_order_by_option', true );
	$tp_order_option 				= get_post_meta( $post->ID, 'tp_order_option', true );
	$tp_image_sizes 			    = get_post_meta( $post->ID, 'tp_image_sizes', true );
	$dpstotoal_items 				= get_post_meta( $post->ID, 'dpstotoal_items', true );
	$tp_testimonial_textalign 		= get_post_meta( $post->ID, 'tp_testimonial_textalign', true );
	$tp_img_show_hide				= get_post_meta( $post->ID, 'tp_img_show_hide', true );
	$tp_img_border_radius			= get_post_meta( $post->ID, 'tp_img_border_radius', true );
	$tp_imgborder_width_option		= get_post_meta( $post->ID, 'tp_imgborder_width_option', true );
	$tp_imgborder_color_option		= get_post_meta( $post->ID, 'tp_imgborder_color_option', true );
	$tp_name_color_option      	 	= get_post_meta( $post->ID, 'tp_name_color_option', true );
	$tp_name_fontsize_option 		= get_post_meta( $post->ID, 'tp_name_fontsize_option', true );
	$tp_name_font_case 				= get_post_meta( $post->ID, 'tp_name_font_case', true );
	$tp_name_font_style 			= get_post_meta( $post->ID, 'tp_name_font_style', true );
	$tp_designation_show_hide		= get_post_meta( $post->ID, 'tp_designation_show_hide', true );
	$tp_desig_fontsize_option		= get_post_meta( $post->ID, 'tp_desig_fontsize_option', true );
	$tp_designation_color_option	= get_post_meta( $post->ID, 'tp_designation_color_option', true );
	$tp_designation_case			= get_post_meta( $post->ID, 'tp_designation_case', true );
	$tp_designation_font_style		= get_post_meta( $post->ID, 'tp_designation_font_style', true );
	$tp_content_color         		= get_post_meta( $post->ID, 'tp_content_color', true );
	$tp_content_fontsize_option     = get_post_meta( $post->ID, 'tp_content_fontsize_option', true );
	$tp_content_bg_color     		= get_post_meta( $post->ID, 'tp_content_bg_color', true );
	$tp_company_show_hide     		= get_post_meta( $post->ID, 'tp_company_show_hide', true );
	$tp_company_url_color     		= get_post_meta( $post->ID, 'tp_company_url_color', true );
	$tp_show_rating_option  		= get_post_meta( $post->ID, 'tp_show_rating_option', true );
	$tp_show_item_bg_option  		= get_post_meta( $post->ID, 'tp_show_item_bg_option', true );
	$tp_rating_color 				= get_post_meta( $post->ID, 'tp_rating_color', true );
	$tp_item_bg_color 				= get_post_meta( $post->ID, 'tp_item_bg_color', true );
	$tp_item_padding 				= get_post_meta( $post->ID, 'tp_item_padding', true );
	$tp_rating_fontsize_option 		= get_post_meta( $post->ID, 'tp_rating_fontsize_option', true );

	#Call get post meta for slider settings.
	$item_no 							= get_post_meta( $post->ID, 'item_no', true );
	$loop 								= get_post_meta( $post->ID, 'loop', true );
	$margin 							= get_post_meta( $post->ID, 'margin', true );
	$navigation 						= get_post_meta( $post->ID, 'navigation', true );
	$pagination 						= get_post_meta( $post->ID, 'pagination', true );
	$autoplay   						= get_post_meta( $post->ID, 'autoplay', true );
	$autoplay_speed   					= get_post_meta( $post->ID, 'autoplay_speed', true );
	$stop_hover   						= get_post_meta( $post->ID, 'stop_hover', true );
	$itemsdesktop   					= get_post_meta( $post->ID, 'itemsdesktop', true );
	$itemsdesktopsmall  				= get_post_meta( $post->ID, 'itemsdesktopsmall', true );
	$itemsmobile   						= get_post_meta( $post->ID, 'itemsmobile', true );
	$autoplaytimeout    				= get_post_meta( $post->ID, 'autoplaytimeout', true );
	$nav_text_color     				= get_post_meta( $post->ID, 'nav_text_color', true );	
	$nav_text_color_hover   			= get_post_meta( $post->ID, 'nav_text_color_hover', true );	
	$nav_bg_color       				= get_post_meta( $post->ID, 'nav_bg_color', true );
	$nav_bg_color_hover     			= get_post_meta( $post->ID, 'nav_bg_color_hover', true );
	$navigation_align       			= get_post_meta( $post->ID, 'navigation_align', true );
	$navigation_style       			= get_post_meta( $post->ID, 'navigation_style', true );
	$pagination_bg_color				= get_post_meta( $post->ID, 'pagination_bg_color', true );
	$pagination_bg_color_active			= get_post_meta( $post->ID, 'pagination_bg_color_active', true );
	$grid_normal_column	    			= get_post_meta( $post->ID, 'grid_normal_column', true );
	$filter_menu_styles	    			= get_post_meta( $post->ID, 'filter_menu_styles', true );
	$filter_menu_alignment	    		= get_post_meta( $post->ID, 'filter_menu_alignment', true );
	$filter_menu_bg_color	    		= get_post_meta( $post->ID, 'filter_menu_bg_color', true );
	$filter_menu_bg_color_hover	    	= get_post_meta( $post->ID, 'filter_menu_bg_color_hover', true );
	$filter_menu_bg_color_active	    = get_post_meta( $post->ID, 'filter_menu_bg_color_active', true );
	$filter_menu_font_color	    		= get_post_meta( $post->ID, 'filter_menu_font_color', true );
	$filter_menu_font_color_hover	    = get_post_meta( $post->ID, 'filter_menu_font_color_hover', true );
	$filter_menu_font_color_active	    = get_post_meta( $post->ID, 'filter_menu_font_color_active', true );
	$pagination_align					= get_post_meta( $post->ID, 'pagination_align', true );
	$pagination_style					= get_post_meta( $post->ID, 'pagination_style', true );
	$nav_value 							= get_post_meta( $post->ID, 'nav_value', true );

	$tp_testimonial_theme_style 		= ($tp_testimonial_theme_style) ? $tp_testimonial_theme_style : 1;
	$grid_normal_column         		= ($grid_normal_column) ? $grid_normal_column : 3;
	$filter_menu_styles         		= ($filter_menu_styles) ? $filter_menu_styles : 1;
	$filter_menu_alignment      		= ($filter_menu_alignment) ? $filter_menu_alignment : 'center';
	$filter_menu_bg_color      			= ($filter_menu_bg_color) ? $filter_menu_bg_color : '#f8f8f8';
	$filter_menu_bg_color_hover      	= ($filter_menu_bg_color_hover) ? $filter_menu_bg_color_hover : '#003478';
	$filter_menu_bg_color_active      	= ($filter_menu_bg_color_active) ? $filter_menu_bg_color_active : '#003478';
	$filter_menu_font_color      		= ($filter_menu_font_color) ? $filter_menu_font_color : '#777777';
	$filter_menu_font_color_hover      	= ($filter_menu_font_color_hover) ? $filter_menu_font_color_hover : '#ffffff';
	$filter_menu_font_color_active      = ($filter_menu_font_color_active) ? $filter_menu_font_color_active : '#ffffff';
	$nav_text_color_hover      			= ($nav_text_color_hover) ? $nav_text_color_hover : '#020202';
	$nav_bg_color_hover      			= ($nav_bg_color_hover) ? $nav_bg_color_hover : '#dddddd';
	$pagination_bg_color_active      	= ($pagination_bg_color_active) ? $pagination_bg_color_active : '#9e9e9e';
	$navigation_style      				= ($navigation_style) ? $navigation_style : '0';
	$pagination_style      				= ($pagination_style) ? $pagination_style : '0';

	?>

	<div class="tupsetings post-grid-metabox">
		<!-- <div class="wrap"> -->
		<ul class="tab-nav">
			<li nav="1" class="nav1 <?php if ( $nav_value == 1 ) { echo "active"; } ?>"><?php _e( 'Shortcodes','ktsttestimonialpro' ); ?></li>
			<li nav="2" class="nav2 <?php if ( $nav_value == 2 ) { echo "active"; } ?>"><?php _e( 'Testimonial Query ','ktsttestimonialpro' ); ?></li>
			<li nav="3" class="nav3 <?php if ( $nav_value == 3 ) { echo "active"; } ?>"><?php _e( 'General Settings ','ktsttestimonialpro' ); ?></li>
			<li nav="4" class="nav4 <?php if ( $nav_value == 4 ) { echo "active"; } ?>"><?php _e( 'Slider Settings','ktsttestimonialpro' ); ?></li>
			<li nav="5" class="nav5 <?php if ( $nav_value == 5 ) { echo "active"; } ?>"><?php _e( 'Grid Settings','ktsttestimonialpro' ); ?></li>
		</ul> <!-- tab-nav end -->

		<?php 
		$getNavValue = "";
		if ( ! empty( $nav_value ) ) { $getNavValue = $nav_value; } else { $getNavValue = 1; }
		?>
		<input type="hidden" name="nav_value" id="nav_value" value="<?php echo $getNavValue; ?>">

		<ul class="box">
			<!-- Tab 1 -->
			<li style="<?php if ( $nav_value == 1 ) { echo "display: block;"; } else { echo "display: none;"; } ?>" class="box1 tab-box <?php if ( $nav_value == 1 ) { echo "active"; } ?>">
				<div class="option-box">
					<p class="option-title"><?php _e( 'Shortcode','ktsttestimonialpro' ); ?></p>
					<p class="option-info"><?php _e( 'Copy this shortcode and paste on post, page or text widgets where you want to display Testimonial Showcase.','ktsttestimonialpro' ); ?></p>
					<textarea cols="50" rows="1" onClick="this.select();" >[tptpro <?php echo 'id="'.$post->ID.'"';?>]</textarea>
					<br /><br />
					<p class="option-info"><?php _e( 'PHP Code:','ktsttestimonialpro' ); ?></p>
					<p class="option-info"><?php _e( 'Use PHP code to your themes file to display Testimonial Showcase.','ktsttestimonialpro' ); ?></p>
					<textarea cols="50" rows="2" onClick="this.select();" ><?php echo '<?php echo do_shortcode("[tptpro id='; echo "'".$post->ID."']"; echo '"); ?>'; ?></textarea>  
				</div>
			</li>
			<!-- Tab 2 -->
			<li style="<?php if($nav_value == 2){echo "display: block;";} else{ echo "display: none;"; }?>" class="box2 tab-box <?php if($nav_value == 2){echo "active";}?>">
				<div class="wrap">
					<div class="option-box">
						<p class="option-title"><?php _e( 'Testimonial Query','ktsttestimonialpro' ); ?></p>
						<table class="form-table">
							<tr valign="top">
								<th scope="row">
									<label for="testimonial_cat_name"><?php _e( 'Select Categories', 'ktsttestimonialpro' ); ?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __('The category names will only be visible when testimonials are published within specific categories.', 'ktsttestimonialpro' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<ul>			
										<?php
											$args = array( 
												'taxonomy'     => 'ktspcategory',
												'orderby'      => 'name',
												'show_count'   => 1,
												'pad_counts'   => 1, 
												'hierarchical' => 1,
												'echo'         => 0
											);
											$allthecats = get_categories( $args );

											foreach( $allthecats as $category ):
											    $cat_id = $category->cat_ID;
											    $checked = ( in_array( $cat_id,( array )$testimonial_cat_name ) ? ' checked="checked"' : "" );
											        echo'<li id="cat-'.$cat_id.'"><input type="checkbox" name="testimonial_cat_name[]" id="'.$cat_id.'" value="'.$cat_id.'"'.$checked.'> <label for="'.$cat_id.'">'.__( $category->cat_name, 'ktsttestimonialpro' ).'</label></li>';
											endforeach;
										?>
									</ul>
									<span class="tpstestimonial_manager_hint"><?php echo __('Choose multiple categories for each testimonial.', 'ktsttestimonialpro' ); ?></span>
								</td>
							</tr><!-- End Testimonial Categories -->

							<tr valign="top">
								<th scope="row">
									<label for="tp_testimonial_themes"><?php _e( 'Select Theme', 'ktsttestimonialpro' ); ?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __('Select a theme which you want to display.', 'ktsttestimonialpro' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<select name="tp_testimonial_themes" id="tp_testimonial_themes" class="timezone_string">
										<option value="1" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '1' ); ?>><?php _e( 'Theme 1', 'ktsttestimonialpro' );?></option>
										<option value="2" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '2' ); ?>><?php _e( 'Theme 2', 'ktsttestimonialpro' );?></option>
										<option value="3" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '3' ); ?>><?php _e( 'Theme 3', 'ktsttestimonialpro' );?></option>
										<option value="4" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '4' ); ?>><?php _e( 'Theme 4', 'ktsttestimonialpro' );?></option>
										<option value="5" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '5' ); ?>><?php _e( 'Theme 5', 'ktsttestimonialpro' );?></option>
										<option value="6" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '6' ); ?>><?php _e( 'Theme 6 (Pro)', 'ktsttestimonialpro' );?></option>
										<option value="7" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '7' ); ?>><?php _e( 'Theme 7 (Pro)', 'ktsttestimonialpro' );?></option>
										<option value="8" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '8' ); ?>><?php _e( 'Theme 8 (Pro)', 'ktsttestimonialpro' );?></option>
										<option value="9" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '9' ); ?>><?php _e( 'Theme 9 (Pro)', 'ktsttestimonialpro' );?></option>
										<option value="10" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '10' ); ?>><?php _e( 'Theme 10 (Pro)', 'ktsttestimonialpro' );?></option>
										<option value="11" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '11' ); ?>><?php _e( 'Theme 11 (Pro)', 'ktsttestimonialpro' );?></option>
										<option value="12" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '12' ); ?>><?php _e( 'Theme 12 (Pro)', 'ktsttestimonialpro' );?></option>
										<option value="13" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '13' ); ?>><?php _e( 'Theme 13 (Pro)', 'ktsttestimonialpro' );?></option>
										<option value="14" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '14' ); ?>><?php _e( 'Theme 14 (Pro)', 'ktsttestimonialpro' );?></option>
										<option value="15" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '15' ); ?>><?php _e( 'Theme 15 (Pro)', 'ktsttestimonialpro' );?></option>
										<option value="16" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '16' ); ?>><?php _e( 'Theme 16 (Pro)', 'ktsttestimonialpro' );?></option>
										<option value="17" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '17' ); ?>><?php _e( 'Theme 17 (Pro)', 'ktsttestimonialpro' );?></option>
										<option value="18" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '18' ); ?>><?php _e( 'Theme 18 (Pro)', 'ktsttestimonialpro' );?></option>
										<option value="19" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '19' ); ?>><?php _e( 'Theme 19 (Pro)', 'ktsttestimonialpro' );?></option>
										<option value="20" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '20' ); ?>><?php _e( 'Theme 20(List - Free)', 'ktsttestimonialpro' );?></option>
										<option value="21" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '21' ); ?>><?php _e( 'Theme 21(List - Pro)', 'ktsttestimonialpro' );?></option>
										<option value="22" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '22' ); ?>><?php _e( 'Theme 22(List - Pro)', 'ktsttestimonialpro' );?></option>
										<option value="23" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '23' ); ?>><?php _e( 'Theme 23(List - Pro)', 'ktsttestimonialpro' );?></option>
										<option value="24" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '24' ); ?>><?php _e( 'Theme 24(List - Pro)', 'ktsttestimonialpro' );?></option>
										<option value="25" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '25' ); ?>><?php _e( 'Theme 25(List - Pro)', 'ktsttestimonialpro' );?></option>
										<option value="26" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '26' ); ?>><?php _e( 'Theme 26(List - Pro)', 'ktsttestimonialpro' );?></option>
										<option value="27" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '27' ); ?>><?php _e( 'Theme 27(List - Pro)', 'ktsttestimonialpro' );?></option>
										<option value="28" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '28' ); ?>><?php _e( 'Theme 28(List - Pro)', 'ktsttestimonialpro' );?></option>
										<option value="29" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '29' ); ?>><?php _e( 'Theme 29(List - Pro)', 'ktsttestimonialpro' );?></option>
										<option value="30" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '30' ); ?>><?php _e( 'Theme 30(List - Pro)', 'ktsttestimonialpro' );?></option>
									</select>
									<span class="tpstestimonial_manager_hint">To unlock all Testimonial Themes, <a href="https://www.themepoints.com/shop/super-testimonial-pro/" target="_blank">Upgrade To Pro!</a></span>
								</td>
							</tr><!-- End Testimonial Themes -->

							<tr valign="top">
								<th scope="row">
									<label for="tp_testimonial_theme_style"><?php _e( 'Select Layout', 'ktsttestimonialpro' ); ?></label>
									<span class="tpstestimonial_manager_hint toss"><?php _e( 'Select a layout to display the testimonials.', 'ktsttestimonialpro' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<select name="tp_testimonial_theme_style" id="tp_testimonial_theme_style" class="timezone_string">
										<option value="1" <?php if ( isset ( $tp_testimonial_theme_style ) ) selected( $tp_testimonial_theme_style, '1' ); ?>><?php _e( 'Slider', 'ktsttestimonialpro' );?></option>
										<option value="2" <?php if ( isset ( $tp_testimonial_theme_style ) ) selected( $tp_testimonial_theme_style, '2' ); ?>><?php _e( 'Normal Grid ( Pro )', 'ktsttestimonialpro' );?></option>
										<option value="3" <?php if ( isset ( $tp_testimonial_theme_style ) ) selected( $tp_testimonial_theme_style, '3' ); ?>><?php _e( 'Filter Grid ( Pro )', 'ktsttestimonialpro' );?></option>
									</select>
									<span class="tpstestimonial_manager_hint">To unlock all Testimonial Layouts, <a href="https://www.themepoints.com/shop/super-testimonial-pro/" target="_blank">Upgrade To Pro!</a>.</span>
								</td>
							</tr>

							<tr valign="top">
								<th scope="row">
									<label for="dpstotoal_items"><?php _e( 'Limit Items', 'ktsttestimonialpro' ); ?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __('Limit number of testimonials to show.', 'ktsttestimonialpro' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="number" name="dpstotoal_items" id="dpstotoal_items" maxlength="4" class="timezone_string" value="<?php  if ( $dpstotoal_items !='' ) { echo $dpstotoal_items; } else { echo '12'; } ?>">
								</td>
							</tr><!-- End Order By -->

							<tr valign="top">
								<th scope="row">
									<label for="tp_order_by_option"><?php _e( 'Order By', 'ktsttestimonialpro' ); ?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Select an order option.', 'ktsttestimonialpro' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<select name="tp_order_by_option" id="tp_order_by_option" class="timezone_string">
										<option value="title" <?php if ( isset ( $tp_order_by_option ) ) selected( $tp_order_by_option, 'title' ); ?>><?php _e( 'Title', 'ktsttestimonialpro' );?></option>
										<option value="modified" <?php if ( isset ( $tp_order_by_option ) ) selected( $tp_order_by_option, 'modified' ); ?>><?php _e( 'Modified', 'ktsttestimonialpro' );?></option>
										<option value="rand" <?php if ( isset ( $tp_order_by_option ) ) selected( $tp_order_by_option, 'rand' ); ?>><?php _e( 'Rand', 'ktsttestimonialpro' );?></option>
										<option value="comment_count" <?php if ( isset ( $tp_order_by_option ) ) selected( $tp_order_by_option, 'comment_count' ); ?>><?php _e( 'Popularity', 'ktsttestimonialpro' ); ?></option>
									</select>									
								</td>
							</tr><!-- End Order By -->

							<tr valign="top">
								<th scope="row">
									<label for="tp_order_option"><?php _e( 'Order Type', 'ktsttestimonialpro' ); ?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Select an order option.', 'ktsttestimonialpro' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<select name="tp_order_option" id="tp_order_option" class="timezone_string">
										<option value="DESC" <?php if ( isset ( $tp_order_option ) ) selected( $tp_order_option, 'DESC' ); ?>><?php _e( 'Descending', 'ktsttestimonialpro' );?></option>
										<option value="ASC" <?php if ( isset ( $tp_order_option ) ) selected( $tp_order_option, 'ASC' ); ?>><?php _e( 'Ascending', 'ktsttestimonialpro' );?></option>
									</select>
								</td>
							</tr><!-- End Order By -->

							<tr>
								<th>
									<label for="tp_image_sizes"><?php _e( 'Image Sizes', 'ktsttestimonialpro' ); ?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Choose an image size to display perfectly', 'ktsttestimonialpro' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<select name="tp_image_sizes" id="tp_image_sizes" class="tp_image_sizes">
										<option value="thumbnail" <?php if ( isset ( $tp_image_sizes ) ) selected( $tp_image_sizes, 'thumbnail' ); ?>><?php _e( 'Thumbnail', 'ktsttestimonialpro' );?></option>
										<option value="medium" <?php if ( isset ( $tp_image_sizes ) ) selected( $tp_image_sizes, 'medium' ); ?>><?php _e( 'Medium', 'ktsttestimonialpro' );?></option>
										<option value="medium_large" <?php if ( isset ( $tp_image_sizes ) ) selected( $tp_image_sizes, 'medium_large' ); ?>><?php _e( 'Medium large', 'ktsttestimonialpro' );?></option>
										<option value="large" <?php if ( isset ( $tp_image_sizes ) ) selected( $tp_image_sizes, 'large' ); ?>><?php _e( 'Large', 'ktsttestimonialpro' );?></option>
										<option value="full" <?php if ( isset ( $tp_image_sizes ) ) selected( $tp_image_sizes, 'full' ); ?>><?php _e( 'Full', 'ktsttestimonialpro' );?></option>
									</select>
								</td>
							</tr><!-- End Image Size -->

						</table>
					</div>
				</div>
			</li>

			<!-- Tab 3 -->
			<li style="<?php if($nav_value == 3){echo "display: block;";} else{ echo "display: none;"; }?>" class="box3 tab-box <?php if($nav_value == 3){echo "active";}?>">
				<div class="wrap">
					<div class="option-box">
						<p class="option-title"><?php _e( 'General Settings','ktsttestimonialpro' ); ?></p>
						<table class="form-table">
							<tr valign="top">
								<th scope="row">
									<label for="tp_testimonial_textalign"><?php _e( 'Text Align', 'ktsttestimonialpro' ); ?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Choose an option for the alignment of testimonials content.', 'ktsttestimonialpro' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="radio-three" name="tp_testimonial_textalign" value="left" <?php if ( $tp_testimonial_textalign == 'left' ) echo 'checked'; ?>/>
										<label for="radio-three"><?php _e( 'Left', 'ktsttestimonialpro' ); ?><span class="mark"><?php _e( 'Pro', 'ktsttestimonialpro' ); ?></span></label>
										<input type="radio" id="radio-four" name="tp_testimonial_textalign" value="center" <?php if ( $tp_testimonial_textalign == 'center' || $tp_testimonial_textalign == '' ) echo 'checked'; ?>/>
										<label for="radio-four"><?php _e( 'Center', 'ktsttestimonialpro' ); ?></label>
										<input type="radio" id="radio-five" name="tp_testimonial_textalign" value="right" <?php if ( $tp_testimonial_textalign == 'right' ) echo 'checked'; ?>/>
										<label for="radio-five"><?php _e( 'Right', 'ktsttestimonialpro' ); ?><span class="mark"><?php _e( 'Pro', 'ktsttestimonialpro' ); ?></span></label>
									</div>
								</td>
							</tr><!-- End Text Align -->
							
							<tr valign="top">
								<th scope="row">
									<label for="tp_img_show_hide"><?php _e( 'Image', 'ktsttestimonialpro' ); ?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Please select whether you would like to display or hide the image of the testimonial.', 'ktsttestimonialpro' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="tp_img_show" name="tp_img_show_hide" value="1" <?php if ( $tp_img_show_hide == 1 || $tp_img_show_hide == '' ) echo 'checked'; ?>/>
										<label for="tp_img_show"><?php _e( 'Show', 'ktsttestimonialpro' ); ?></label>
										<input type="radio" id="tp_img_hide" name="tp_img_show_hide" value="2" <?php if ( $tp_img_show_hide == 2 ) echo 'checked'; ?>/>
										<label for="tp_img_hide"><?php _e( 'Hide', 'ktsttestimonialpro' ); ?><span class="mark"><?php _e( 'Pro', 'ktsttestimonialpro' ); ?></span></label>
									</div>
								</td>
							</tr><!-- End Image -->

							<tr valign="top" id="imgBorderController" style="<?php if ( $tp_img_show_hide == 2) {	echo "display:none;"; }?>">
								<th scope="row">
									<label for="tp_imgborder_width_option"><?php _e( 'Image Border Width', 'ktsttestimonialpro' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Set image border Width.', 'ktsttestimonialpro' ); ?></span>
								</th>
								<td>
									<input type="number" name="tp_imgborder_width_option" min="0" max="10" value="<?php if ( $tp_imgborder_width_option !='' ) {echo $tp_imgborder_width_option; }else{echo 0; } ?>">
								</td>
							</tr> <!-- End of image border width -->

							<tr valign="top" id="imgColor_controller" style="<?php if ( $tp_img_show_hide == 2) {	echo "display:none;"; }?>">
								<th scope="row">
									<label for="tp_imgborder_color_option"><?php _e( 'Image Border Color', 'ktsttestimonialpro' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Choose a color for the image border.', 'ktsttestimonialpro' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="text" id="tp_imgborder_color_option" name="tp_imgborder_color_option" value="<?php if ( $tp_imgborder_color_option !='' ) {echo $tp_imgborder_color_option; }else{echo "#f5f5f5"; } ?>" class="timezone_string">
								</td>
							</tr><!-- End Name Color -->
							
							<tr valign="top" id="imgRadius_controller" style="<?php if ( $tp_img_show_hide == 2 ) {	echo "display:none;"; } ?>">
								<th scope="row">
									<label for="tp_testimonial_textalign"><?php _e( 'Image Border Radius', 'ktsttestimonialpro' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Select an option for border radius of the images.', 'ktsttestimonialpro' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<select name="tp_img_border_radius" id="tp_img_border_radius" class="timezone_string">
										<option value="0%" <?php if ( isset ( $tp_img_border_radius ) ) selected( $tp_img_border_radius, '0%' ); ?>><?php _e( 'Default', 'ktsttestimonialpro' );?></option>
										<option value="10%" <?php if ( isset ( $tp_img_border_radius ) ) selected( $tp_img_border_radius, '10%' ); ?>><?php _e( '10%', 'ktsttestimonialpro' );?></option>
										<option value="15%" <?php if ( isset ( $tp_img_border_radius ) ) selected( $tp_img_border_radius, '15%' ); ?>><?php _e( '15%', 'ktsttestimonialpro' );?></option>
										<option value="20%" <?php if ( isset ( $tp_img_border_radius ) ) selected( $tp_img_border_radius, '20%' ); ?>><?php _e( '20%', 'ktsttestimonialpro' );?></option>
										<option value="25%" <?php if ( isset ( $tp_img_border_radius ) ) selected( $tp_img_border_radius, '25%' ); ?>><?php _e( '25%', 'ktsttestimonialpro' );?></option>
										<option value="30%" <?php if ( isset ( $tp_img_border_radius ) ) selected( $tp_img_border_radius, '30%' ); ?>><?php _e( '30%', 'ktsttestimonialpro' );?></option>
										<option value="40%" <?php if ( isset ( $tp_img_border_radius ) ) selected( $tp_img_border_radius, '40%' ); ?>><?php _e( '40%', 'ktsttestimonialpro' );?></option>
										<option value="50%" <?php if ( isset ( $tp_img_border_radius ) ) selected( $tp_img_border_radius, '50%' ); ?>><?php _e( '50%', 'ktsttestimonialpro' );?></option>
									</select>
								</td>
							</tr><!-- End Border Radius -->
							
							<tr valign="top">
								<th scope="row">
									<label for="tp_name_color_option"><?php _e( 'Name Font Color', 'ktsttestimonialpro' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Pick a color for testimonial givers name.', 'ktsttestimonialpro' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="text" id="tp_name_color_option" name="tp_name_color_option" value="<?php if ( $tp_name_color_option !='' ) {echo $tp_name_color_option; }else{echo "#020202"; } ?>" class="timezone_string">
								</td>
							</tr><!-- End Name Color -->
							
							<tr valign="top">
								<th scope="row">
									<label for="tp_name_fontsize_option"><?php _e( 'Name Font Size', 'ktsttestimonialpro' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __('Choose a font size for testimonial name.', 'ktsttestimonialpro'); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="number" name="tp_name_fontsize_option" id="tp_name_fontsize_option" min="10" max="45" class="timezone_string" required value="<?php  if($tp_name_fontsize_option !=''){echo $tp_name_fontsize_option; }else{ echo '18';} ?>"> <br />
								</td>
							</tr><!-- End Name Font Size-->

							<tr valign="top">
								<th scope="row">
									<label for="tp_name_font_case"><?php _e('Name Text Transform', 'ktsttestimonialpro');?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __('Select Name Text Transform', 'ktsttestimonialpro'); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<select name="tp_name_font_case" id="tp_name_font_case" class="timezone_string">
										<option value="none" <?php if ( isset ( $tp_name_font_case ) ) selected( $tp_name_font_case, 'none' ); ?>><?php _e('Default', 'ktsttestimonialpro');?></option>
										<option value="capitalize" <?php if ( isset ( $tp_name_font_case ) ) selected( $tp_name_font_case, 'capitalize' ); ?>><?php _e('Capitalize', 'ktsttestimonialpro');?></option>
										<option value="lowercase" <?php if ( isset ( $tp_name_font_case ) ) selected( $tp_name_font_case, 'lowercase' ); ?>><?php _e('Lowercase', 'ktsttestimonialpro');?></option>
										<option value="uppercase" <?php if ( isset ( $tp_name_font_case ) ) selected( $tp_name_font_case, 'uppercase' ); ?>><?php _e('Uppercase', 'ktsttestimonialpro');?></option>
									</select><br>
								</td>
							</tr><!-- End name text Transform -->

							<tr valign="top">
								<th scope="row">
									<label for="tp_name_font_style"><?php _e('Name Text Style', 'ktsttestimonialpro');?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __('Select Name Text style', 'ktsttestimonialpro'); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<select name="tp_name_font_style" id="tp_name_font_style" class="timezone_string">
										<option value="normal" <?php if ( isset ( $tp_name_font_style ) ) selected( $tp_name_font_style, 'normal' ); ?>><?php _e('Default', 'ktsttestimonialpro');?></option>
										<option value="italic" <?php if ( isset ( $tp_name_font_style ) ) selected( $tp_name_font_style, 'italic' ); ?>><?php _e('Italic', 'ktsttestimonialpro');?></option>
									</select><br>
								</td>
							</tr> <!-- End name text style -->

							<tr valign="top">
								<th scope="row">
									<label for="tp_designation_show_hide"><?php _e( 'Designation', 'ktsttestimonialpro' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Choose one option whether you want to show or hide the designation of testimonial giver.', 'ktsttestimonialpro' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="tp_designation_show" name="tp_designation_show_hide" value="1" <?php if ( $tp_designation_show_hide == 1 || $tp_designation_show_hide == '' ) echo 'checked'; ?>/>
										<label for="tp_designation_show"><?php _e( 'Show', 'ktsttestimonialpro' ); ?></label>
										<input type="radio" id="tp_designation_hide" name="tp_designation_show_hide" value="2" <?php if ( $tp_designation_show_hide == 2 ) echo 'checked'; ?>/>
										<label for="tp_designation_hide"><?php _e( 'Hide', 'ktsttestimonialpro' ); ?><span class="mark"><?php _e( 'Pro', 'ktsttestimonialpro' ); ?></span></label>
									</div>
								</td>
							</tr><!-- End Designation Show/Hide -->
							
							<tr valign="top">
								<th scope="row">
									<label for="tp_desig_fontsize_option"><?php _e( 'Designation Font Size', 'ktsttestimonialpro' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __('Choose a font size for testimonial designation.', 'ktsttestimonialpro'); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="number" name="tp_desig_fontsize_option" id="tp_desig_fontsize_option" min="10" max="45" class="timezone_string" required value="<?php  if($tp_desig_fontsize_option !=''){echo $tp_desig_fontsize_option; }else{ echo '15';} ?>"> <br />
								</td>
							</tr><!-- End Designation Font Size-->
							
							<tr valign="top">
								<th scope="row">
									<label for="tp_designation_color_option"><?php _e( 'Designation Font Color', 'ktsttestimonialpro' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Pick a color for testimonial givers designation.', 'ktsttestimonialpro' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="text" id="tp_designation_color_option" name="tp_designation_color_option" value="<?php if ( $tp_designation_color_option !='' ) {echo $tp_designation_color_option; }else{echo "#666666"; } ?>" class="timezone_string">
								</td>
							</tr><!-- End Designation Font Color -->

							<tr valign="top">
								<th scope="row">
									<label for="tp_designation_case"><?php _e('Designation Text Transform', 'ktsttestimonialpro');?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __('Select Designation Text Transform', 'ktsttestimonialpro'); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<select name="tp_designation_case" id="tp_designation_case" class="timezone_string">
										<option value="none" <?php if ( isset ( $tp_designation_case ) ) selected( $tp_designation_case, 'none' ); ?>><?php _e('Default', 'ktsttestimonialpro');?></option>
										<option value="capitalize" <?php if ( isset ( $tp_designation_case ) ) selected( $tp_designation_case, 'capitalize' ); ?>><?php _e('Capitalize', 'ktsttestimonialpro');?></option>
										<option value="lowercase" <?php if ( isset ( $tp_designation_case ) ) selected( $tp_designation_case, 'lowercase' ); ?>><?php _e('Lowercase', 'ktsttestimonialpro');?></option>
										<option value="uppercase" <?php if ( isset ( $tp_designation_case ) ) selected( $tp_designation_case, 'uppercase' ); ?>><?php _e('Uppercase', 'ktsttestimonialpro');?></option>
									</select><br>
								</td>
							</tr><!-- End name text Transform -->

							<tr valign="top">
								<th scope="row">
									<label for="tp_designation_font_style"><?php _e('Designation Text Style', 'ktsttestimonialpro'); ?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __('Select Designation Text style', 'ktsttestimonialpro'); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<select name="tp_designation_font_style" id="tp_designation_font_style" class="timezone_string">
										<option value="normal" <?php if ( isset ( $tp_designation_font_style ) ) selected( $tp_designation_font_style, 'normal' ); ?>><?php _e('Default', 'ktsttestimonialpro');?></option>
										<option value="italic" <?php if ( isset ( $tp_designation_font_style ) ) selected( $tp_designation_font_style, 'italic' ); ?>><?php _e('Italic', 'ktsttestimonialpro');?></option>
									</select><br>
								</td>
							</tr> <!-- End name text style -->

							<tr valign="top">
								<th scope="row">
									<label for="tp_company_show_hide"><?php _e( 'Company URL', 'ktsttestimonialpro' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Choose one option whether you want to show or hide the company name and URL of testimonial giver.', 'ktsttestimonialpro' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="tp_company_show" name="tp_company_show_hide" value="1" <?php if ( $tp_company_show_hide == 1 || $tp_company_show_hide == '' ) echo 'checked'; ?>/>
										<label for="tp_company_show"><?php _e( 'Show', 'ktsttestimonialpro' ); ?></label>
										<input type="radio" id="tp_company_hide" name="tp_company_show_hide" value="2" <?php if ( $tp_company_show_hide == 2 ) echo 'checked'; ?>/>
										<label for="tp_company_hide"><?php _e( 'Hide', 'ktsttestimonialpro' ); ?><span class="mark"><?php _e( 'Pro', 'ktsttestimonialpro' ); ?></span></label>
									</div>
								</td>
							</tr><!-- End Company Profiles Show/Hide -->

							<tr valign="top">
								<th scope="row">
									<label for="tp_company_url_color"><?php _e( 'Company URL Color', 'ktsttestimonialpro' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Pick a color for testimonial givers company name.', 'ktsttestimonialpro' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="text" id="tp_company_url_color" name="tp_company_url_color" value="<?php if ( $tp_company_url_color !='' ) {echo $tp_company_url_color; }else{echo "#666666"; } ?>" class="timezone_string">
								</td>
							</tr><!-- End Url  Color -->

							<tr valign="top">
								<th scope="row">
									<label for="tp_content_color"><?php _e( 'Content Color', 'ktsttestimonialpro' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Pick a color for testimonial message.', 'ktsttestimonialpro' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="text" id="tp_content_color" name="tp_content_color" value="<?php if ( $tp_content_color !='' ) {echo $tp_content_color; } else{ echo "#666666"; } ?>" class="timezone_string">
								</td>
							</tr><!-- End Content Color -->

							<tr valign="top">
								<th scope="row">
									<label for="tp_content_fontsize_option"><?php _e( 'Content Font Size', 'ktsttestimonialpro' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __('Choose a font size for testimonial message.', 'ktsttestimonialpro'); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="number" name="tp_content_fontsize_option" id="tp_content_fontsize_option" min="10" max="45" class="timezone_string" required value="<?php  if($tp_content_fontsize_option !=''){echo $tp_content_fontsize_option; }else{ echo '15';} ?>"> <br />
								</td>
							</tr><!-- End Content Font Size-->
							
							<tr valign="top">
								<th scope="row">
									<label for="tp_content_bg_color"><?php _e( 'Content Background Color', 'ktsttestimonialpro' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Pick a color for content background.', 'ktsttestimonialpro' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="text" id="tp_content_bg_color" name="tp_content_bg_color" value="<?php if ( $tp_content_bg_color !='' ) {echo $tp_content_bg_color; } else{ echo "#ffffff"; } ?>" class="timezone_string">
								</td>
							</tr><!-- End Content Background Color -->

							<tr valign="top">
								<th scope="row">
									<label for="tp_show_rating_option"><?php _e( 'Rating', 'ktsttestimonialpro' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Choose one option whether you want to show or hide the rating of testimonial giver.', 'ktsttestimonialpro' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="tp_show_rating_option" name="tp_show_rating_option" value="1" <?php if ( $tp_show_rating_option == 1 || $tp_show_rating_option == '' ) echo 'checked'; ?>/>
										<label for="tp_show_rating_option"><?php _e( 'Show', 'ktsttestimonialpro' ); ?></label>
										<input type="radio" id="tp_hide_rating_option" name="tp_show_rating_option" value="2" <?php if ( $tp_show_rating_option == 2 ) echo 'checked'; ?>/>
										<label for="tp_hide_rating_option"><?php _e( 'Hide', 'ktsttestimonialpro' ); ?><span class="mark"><?php _e( 'Pro', 'ktsttestimonialpro' ); ?></span></label>
									</div>
								</td>
							</tr><!-- End Rating -->

							<tr valign="top">
								<th scope="row">
									<label for="tp_rating_color"><?php _e( 'Rating Icon Color', 'ktsttestimonialpro' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Pick a color for testimonial ratings.', 'ktsttestimonialpro' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="text" id="tp_rating_color" name="tp_rating_color" value="<?php if ( $tp_rating_color !='' ) {echo $tp_rating_color; } else{ echo "#ffa900"; } ?>" class="timezone_string">
								</td>
							</tr><!-- End Rating Color -->

							<tr valign="top">
								<th scope="row">
									<label for="tp_rating_fontsize_option"><?php _e( 'Rating Font Size', 'ktsttestimonialpro' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __('Choose a font size for testimonial ratings.', 'ktsttestimonialpro'); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="number" name="tp_rating_fontsize_option" id="tp_rating_fontsize_option" min="10" max="45" class="timezone_string" required value="<?php  if($tp_rating_fontsize_option !=''){echo $tp_rating_fontsize_option; }else{ echo '15';} ?>"> <br />
								</td>
							</tr><!-- End Content Font Size-->

							<tr valign="top">
								<th scope="row">
									<label for="tp_show_item_bg_option"><?php _e( 'Item Background', 'ktsttestimonialpro' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Choose one option whether you want to show or hide background color for an item.', 'ktsttestimonialpro' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="tp_show_item_bg_option" name="tp_show_item_bg_option" value="1" <?php if ( $tp_show_item_bg_option == 1 ) echo 'checked'; ?>/>
										<label for="tp_show_item_bg_option"><?php _e( 'Show', 'ktsttestimonialpro' ); ?></label>
										<input type="radio" id="tp_hide_item_bg_option" name="tp_show_item_bg_option" value="2" <?php if ( $tp_show_item_bg_option == 2 || $tp_show_item_bg_option == '' ) echo 'checked'; ?>/>
										<label for="tp_hide_item_bg_option"><?php _e( 'Hide', 'ktsttestimonialpro' ); ?></label>
									</div>
								</td>
							</tr><!-- End Item Background Color -->

							<tr valign="top">
								<th scope="row">
									<label for="tp_item_bg_color"><?php _e( 'Background Color', 'ktsttestimonialpro' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Pick a color for item background.', 'ktsttestimonialpro' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="text" id="tp_item_bg_color" name="tp_item_bg_color" value="<?php if ( $tp_item_bg_color !='' ) {echo $tp_item_bg_color; } else{ echo "transparent"; } ?>" class="timezone_string">
								</td>
							</tr><!-- End Item Background Color -->

							<tr valign="top">
								<th scope="row">
									<label for="tp_item_padding"><?php _e( 'Item Padding', 'ktsttestimonialpro' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Select Padding for items.', 'ktsttestimonialpro' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input size="5" type="number" name="tp_item_padding" id="tp_item_padding" maxlength="3" class="timezone_string" value="<?php if ( $tp_item_padding != '' ) { echo $tp_item_padding; } else { echo '20'; } ?>">
								</td>
							</tr> <!-- End Item Padding -->

						</table>
					</div>
				</div>
			</li>
			
			<!-- Tab 4 -->
			<li style="<?php if($nav_value == 4){echo "display: block;";} else{ echo "display: none;"; }?>" class="box4 tab-box <?php if($nav_value == 4){echo "active";}?>">
				<div class="wrap">
					<div class="option-box">
						<p class="option-title"><?php _e( 'Slider Settings','ktsttestimonialpro' ); ?></p>
						<table class="form-table">
							<tr valign="top">
								<th scope="row">
									<label for="autoplay"><?php _e( 'Autoplay', 'ktsttestimonialpro' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Choose an option whether you want the slider autoplay or not.', 'ktsttestimonialpro' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="autoplay_true" name="autoplay" value="true" <?php if ( $autoplay == 'true' || $autoplay == '' ) echo 'checked'; ?>/>
										<label for="autoplay_true"><?php _e( 'Yes', 'ktsttestimonialpro' ); ?></label>
										<input type="radio" id="autoplay_false" name="autoplay" value="false" <?php if ( $autoplay == 'false' ) echo 'checked'; ?>/>
										<label for="autoplay_false"><?php _e( 'No', 'ktsttestimonialpro' ); ?></label>
									</div>
								</td>
							</tr> <!-- End Autoplay -->

							<tr valign="top">
								<th scope="row">
									<label for="autoplay_speed"><?php _e( 'Slide Delay', 'ktsttestimonialpro' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Select a value for sliding speed.', 'ktsttestimonialpro' ); ?></span>	
								</th>
								<td style="vertical-align: middle;" class="auto_play">

									<input type="range" step="100" min="100" max="5000" value="<?php  if ( $autoplay_speed !='' ) { echo $autoplay_speed; } else{ echo '700'; } ?>" class="slider" id="myRange"><br>
									<input size="5" type="text" name="autoplay_speed" id="autoplay_speed" maxlength="4" class="timezone_string" readonly  value="<?php  if ( $autoplay_speed !='' ) {echo $autoplay_speed; }else{ echo '700'; } ?>">						
								</td>
							</tr> <!-- End Slide Delay -->

							<tr valign="top">
								<th scope="row">
									<label for="stop_hover"><?php _e( 'Stop Hover', 'ktsttestimonialpro' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Select an option whether you want to pause sliding on mouse hover.', 'ktsttestimonialpro' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="stop_hover_true" name="stop_hover" value="true" <?php if ( $stop_hover == 'true' || $stop_hover == '' ) echo 'checked'; ?>/>
										<label for="stop_hover_true"><?php _e( 'Yes', 'ktsttestimonialpro' ); ?></label>
										<input type="radio" id="stop_hover_false" name="stop_hover" value="false" <?php if ( $stop_hover == 'false' ) echo 'checked'; ?>/>
										<label for="stop_hover_false"><?php _e( 'No', 'ktsttestimonialpro' ); ?></label>
									</div>				
								</td>
							</tr> <!-- End Stop Hover -->

							<tr valign="top">
								<th scope="row">
									<label for="autoplaytimeout"><?php _e( 'Autoplay Time Out (Sec)', 'ktsttestimonialpro' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Select an option for autoplay time out.', 'ktsttestimonialpro' ); ?></span>	
								</th>
								<td style="vertical-align: middle;">
									<select name="autoplaytimeout" id="autoplaytimeout" class="timezone_string">
										<option value="3000" <?php if ( isset ( $autoplaytimeout ) ) selected( $autoplaytimeout, '3000' ); ?>><?php _e( '3', 'ktsttestimonialpro' );?></option>
										<option value="1000" <?php if ( isset ( $autoplaytimeout ) ) selected( $autoplaytimeout, '1000' ); ?>><?php _e( '1', 'ktsttestimonialpro' );?></option>
										<option value="2000" <?php if ( isset ( $autoplaytimeout ) ) selected( $autoplaytimeout, '2000' ); ?>><?php _e( '2', 'ktsttestimonialpro' );?></option>
										<option value="4000" <?php if ( isset ( $autoplaytimeout ) ) selected( $autoplaytimeout, '4000' ); ?>><?php _e( '4', 'ktsttestimonialpro' );?></option>
										<option value="5000" <?php if ( isset ( $autoplaytimeout ) ) selected( $autoplaytimeout, '5000' ); ?>><?php _e( '5', 'ktsttestimonialpro' );?></option>
										<option value="6000" <?php if ( isset ( $autoplaytimeout ) ) selected( $autoplaytimeout, '6000' ); ?>><?php _e( '6', 'ktsttestimonialpro' );?></option>
										<option value="7000" <?php if ( isset ( $autoplaytimeout ) ) selected( $autoplaytimeout, '7000' ); ?>><?php _e( '7', 'ktsttestimonialpro' );?></option>
										<option value="8000" <?php if ( isset ( $autoplaytimeout ) ) selected( $autoplaytimeout, '8000' ); ?>><?php _e( '8', 'ktsttestimonialpro' );?></option>
										<option value="9000" <?php if ( isset ( $autoplaytimeout ) ) selected( $autoplaytimeout, '9000' ); ?>><?php _e( '9', 'ktsttestimonialpro' );?></option>
										<option value="10000" <?php if ( isset ( $autoplaytimeout ) ) selected( $autoplaytimeout, '10000' ); ?>><?php _e( '10', 'ktsttestimonialpro' );?></option>
									</select>						
								</td>
							</tr> <!-- End Autoplay Time Out -->

							<tr valign="top">
								<th scope="row">
									<label for="item_no"><?php _e( 'Items No', 'ktsttestimonialpro' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Select number of items you want to show.', 'ktsttestimonialpro' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<select name="item_no" id="item_no" class="timezone_string">
										<option value="3" <?php if ( isset ( $item_no ) )  selected( $item_no, '3' ); ?>><?php _e( '3', 'ktsttestimonialpro' );?></option>
										<option value="1" <?php if ( isset ( $item_no ) )  selected( $item_no, '1' ); ?>><?php _e( '1', 'ktsttestimonialpro' );?></option>
										<option value="2" <?php if ( isset ( $item_no ) )  selected( $item_no, '2' ); ?>><?php _e( '2', 'ktsttestimonialpro' );?></option>
										<option value="4" <?php if ( isset ( $item_no ) )  selected( $item_no, '4' ); ?>><?php _e( '4', 'ktsttestimonialpro' );?></option>
										<option value="5" <?php if ( isset ( $item_no ) )  selected( $item_no, '5' ); ?>><?php _e( '5', 'ktsttestimonialpro' );?></option>
										<option value="6" <?php if ( isset ( $item_no ) )  selected( $item_no, '6' ); ?>><?php _e( '6', 'ktsttestimonialpro' );?></option>
										<option value="7" <?php if ( isset ( $item_no ) )  selected( $item_no, '7' ); ?>><?php _e( '7', 'ktsttestimonialpro' );?></option>
										<option value="8" <?php if ( isset ( $item_no ) )  selected( $item_no, '8' ); ?>><?php _e( '8', 'ktsttestimonialpro' );?></option>
										<option value="9" <?php if ( isset ( $item_no ) )  selected( $item_no, '9' ); ?>><?php _e( '9', 'ktsttestimonialpro' );?></option>
										<option value="10" <?php if ( isset ( $item_no ) ) selected( $item_no, '10' ); ?>><?php _e( '10', 'ktsttestimonialpro' );?></option>
									</select>
								</td> 
							</tr> <!-- End Items No -->

							<tr valign="top">
								<th scope="row">
									<label for="itemsdesktop"><?php _e( 'Items Desktop', 'ktsttestimonialpro' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Number of items you want to show for large desktop monitor.', 'ktsttestimonialpro' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<select name="itemsdesktop" id="itemsdesktop" class="timezone_string">
										<option value="3" <?php if ( isset ( $itemsdesktop ) ) selected( $itemsdesktop, '3' ); ?>><?php _e( '3', 'ktsttestimonialpro' );?></option>
										<option value="1" <?php if ( isset ( $itemsdesktop ) ) selected( $itemsdesktop, '1' ); ?>><?php _e( '1', 'ktsttestimonialpro' );?></option>
										<option value="2" <?php if ( isset ( $itemsdesktop ) ) selected( $itemsdesktop, '2' ); ?>><?php _e( '2', 'ktsttestimonialpro' );?></option>
										<option value="4" <?php if ( isset ( $itemsdesktop ) ) selected( $itemsdesktop, '4' ); ?>><?php _e( '4', 'ktsttestimonialpro' );?></option>
										<option value="5" <?php if ( isset ( $itemsdesktop ) ) selected( $itemsdesktop, '5' ); ?>><?php _e( '5', 'ktsttestimonialpro' );?></option>
										<option value="6" <?php if ( isset ( $itemsdesktop ) ) selected( $itemsdesktop, '6' ); ?>><?php _e( '6', 'ktsttestimonialpro' );?></option>
										<option value="7" <?php if ( isset ( $itemsdesktop ) ) selected( $itemsdesktop, '7' ); ?>><?php _e( '7', 'ktsttestimonialpro' );?></option>
										<option value="8" <?php if ( isset ( $itemsdesktop ) ) selected( $itemsdesktop, '8' ); ?>><?php _e( '8', 'ktsttestimonialpro' );?></option>
										<option value="9" <?php if ( isset ( $itemsdesktop ) ) selected( $itemsdesktop, '9' ); ?>><?php _e( '9', 'ktsttestimonialpro' );?></option>
										<option value="10" <?php if ( isset ( $itemsdesktop ) ) selected( $itemsdesktop, '10' ); ?>><?php _e( '10', 'ktsttestimonialpro' );?></option>
									</select>
								</td>
							</tr> <!-- End Items Desktop -->

							<tr valign="top">
								<th scope="row">
									<label for="itemsdesktopsmall"><?php _e( 'Items Desktop Small', 'ktsttestimonialpro' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Number of items you want to show for small desktop monitor.', 'ktsttestimonialpro' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<select name="itemsdesktopsmall" id="itemsdesktopsmall" class="timezone_string">
										<option value="1" <?php if ( isset ( $itemsdesktopsmall ) ) selected( $itemsdesktopsmall, '1' ); ?>><?php _e( '1', 'ktsttestimonialpro' );?></option>
										<option value="2" <?php if ( isset ( $itemsdesktopsmall ) ) selected( $itemsdesktopsmall, '2' ); ?>><?php _e( '2', 'ktsttestimonialpro' );?></option>
										<option value="3" <?php if ( isset ( $itemsdesktopsmall ) ) selected( $itemsdesktopsmall, '3' ); ?>><?php _e( '3', 'ktsttestimonialpro' );?></option>
										<option value="4" <?php if ( isset ( $itemsdesktopsmall ) ) selected( $itemsdesktopsmall, '4' ); ?>><?php _e( '4', 'ktsttestimonialpro' );?></option>
										<option value="5" <?php if ( isset ( $itemsdesktopsmall ) ) selected( $itemsdesktopsmall, '5' ); ?>><?php _e( '5', 'ktsttestimonialpro' );?></option>
										<option value="6" <?php if ( isset ( $itemsdesktopsmall ) ) selected( $itemsdesktopsmall, '6' ); ?>><?php _e( '6', 'ktsttestimonialpro' );?></option>
										<option value="7" <?php if ( isset ( $itemsdesktopsmall ) ) selected( $itemsdesktopsmall, '7' ); ?>><?php _e( '7', 'ktsttestimonialpro' );?></option>
										<option value="8" <?php if ( isset ( $itemsdesktopsmall ) ) selected( $itemsdesktopsmall, '8' ); ?>><?php _e( '8', 'ktsttestimonialpro' );?></option>
										<option value="9" <?php if ( isset ( $itemsdesktopsmall ) ) selected( $itemsdesktopsmall, '9' ); ?>><?php _e( '9', 'ktsttestimonialpro' );?></option>
										<option value="10" <?php if ( isset ( $itemsdesktopsmall ) ) selected( $itemsdesktopsmall, '10' ); ?>><?php _e( '10', 'ktsttestimonialpro' );?></option>
									</select>
								</td>
							</tr>
							<!-- End Items Desktop Small -->

							<tr valign="top">
								<th scope="row">
									<label for="itemsmobile"><?php _e( 'Items Mobile', 'ktsttestimonialpro' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Number of items you want to show for mobile device.', 'ktsttestimonialpro' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<select name="itemsmobile" id="itemsmobile" class="timezone_string">
										<option value="1" <?php if ( isset ( $itemsmobile ) ) selected( $itemsmobile, '1' ); ?>><?php _e( '1', 'ktsttestimonialpro' );?></option>
										<option value="2" <?php if ( isset ( $itemsmobile ) ) selected( $itemsmobile, '2' ); ?>><?php _e( '2', 'ktsttestimonialpro' );?></option>
										<option value="3" <?php if ( isset ( $itemsmobile ) ) selected( $itemsmobile, '3' ); ?>><?php _e( '3', 'ktsttestimonialpro' );?></option>
										<option value="4" <?php if ( isset ( $itemsmobile ) ) selected( $itemsmobile, '4' ); ?>><?php _e( '4', 'ktsttestimonialpro' );?></option>
										<option value="5" <?php if ( isset ( $itemsmobile ) ) selected( $itemsmobile, '5' ); ?>><?php _e( '5', 'ktsttestimonialpro' );?></option>
										<option value="6" <?php if ( isset ( $itemsmobile ) ) selected( $itemsmobile, '6' ); ?>><?php _e( '6', 'ktsttestimonialpro' );?></option>
										<option value="7" <?php if ( isset ( $itemsmobile ) ) selected( $itemsmobile, '7' ); ?>><?php _e( '7', 'ktsttestimonialpro' );?></option>
										<option value="8" <?php if ( isset ( $itemsmobile ) ) selected( $itemsmobile, '8' ); ?>><?php _e( '8', 'ktsttestimonialpro' );?></option>
										<option value="9" <?php if ( isset ( $itemsmobile ) ) selected( $itemsmobile, '9' ); ?>><?php _e( '9', 'ktsttestimonialpro' );?></option>
										<option value="10" <?php if ( isset ( $itemsmobile ) ) selected( $itemsmobile, '10' ); ?>><?php _e( '10', 'ktsttestimonialpro' );?></option>
									</select>
								</td>
							</tr>
							<!-- End Items Mobile -->

							<tr valign="top">
								<th scope="row">
									<label for="item_no"><?php _e( 'Loop', 'ktsttestimonialpro' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Choose an option whether you want to loop the sliders.', 'ktsttestimonialpro' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="loop_true" name="loop" value="true" <?php if ( $loop == 'true' || $loop == '' ) echo 'checked'; ?>/>
										<label for="loop_true"><?php _e( 'Yes', 'ktsttestimonialpro' ); ?></label>
										<input type="radio" id="loop_false" name="loop" value="false" <?php if ( $loop == 'false' ) echo 'checked'; ?>/>
										<label for="loop_false"><?php _e( 'No', 'ktsttestimonialpro' ); ?></label>
									</div>
								</td>
							</tr>
							<!-- End Loop -->

							<tr valign="top">
								<th scope="row">
									<label for="margin"><?php _e( 'Margin', 'ktsttestimonialpro' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Select margin for a slider item.', 'ktsttestimonialpro' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input size="5" type="number" name="margin" id="margin_top" maxlength="3" class="timezone_string" value="<?php if ( $margin != '' ) { echo $margin; } else { echo '15'; } ?>">
								</td>
							</tr>
							<!-- End Margin -->

							<tr valign="top">
								<th scope="row">
									<label for="navigation"><?php _e( 'Navigation', 'ktsttestimonialpro' ); ?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Choose an option whether you want navigation option or not.', 'ktsttestimonialpro' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="navigation_true" name="navigation" value="true" <?php if ( $navigation == 'true' || $navigation == '' ) echo 'checked'; ?>/>
										<label for="navigation_true"><?php _e( 'Yes', 'ktsttestimonialpro' ); ?></label>
										<input type="radio" id="navigation_false" name="navigation" value="false" <?php if ( $navigation == 'false' ) echo 'checked'; ?>/>
										<label for="navigation_false"><?php _e( 'No', 'ktsttestimonialpro' ); ?><span class="mark"><?php _e( 'Pro', 'ktsttestimonialpro' ); ?></span></label>
									</div>
								</td>
							</tr>
							<!-- End Navigation -->
							
							<tr valign="top" id="navi_align_controller" style="<?php if ( $navigation == 'false') {	echo "display:none;"; }?>">
								<th scope="row">
									<label for="navigation_align"><?php _e( 'Navigation Align', 'ktsttestimonialpro' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Set the alignment of the navigation tool.' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="navigation_align_left" name="navigation_align" value="left" <?php if ( $navigation_align == 'left' ) echo 'checked'; ?>/>
										<label for="navigation_align_left"><?php _e( 'Top Left', 'ktsttestimonialpro' ); ?></label>
										<input type="radio" id="navigation_align_center" name="navigation_align" value="center" <?php if ( $navigation_align == 'center' ) echo 'checked'; ?>/>
										<label for="navigation_align_center"><?php _e( 'Center', 'ktsttestimonialpro' ); ?></label>
										<input type="radio" id="navigation_align_right" name="navigation_align" value="right" <?php if ( $navigation_align == 'right' || $navigation_align == '' ) echo 'checked'; ?>/>
										<label for="navigation_align_right"><?php _e( 'Top Right', 'ktsttestimonialpro' ); ?></label>
									</div>						
								</td>
							</tr>
							<!-- End Pagination Align -->

							<tr valign="top" id="navi_style_controller" style="<?php if ( $navigation == 'false') {	echo "display:none;"; }?>">
								<th scope="row">
									<label for="navigation_style"><?php _e( 'Navigation Style', 'ktsttestimonialpro' );?></label>	
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Set the style of navigation tool.' ); ?></span>	
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="navigation_style_left" name="navigation_style" value="0" <?php if ( $navigation_style == '0' ) echo 'checked'; ?>/>
										<label for="navigation_style_left"><?php _e( 'Default', 'ktsttestimonialpro' ); ?></label>
										<input type="radio" id="navigation_style_center" name="navigation_style" value="50" <?php if ( $navigation_style == '50' || $navigation_style == '' ) echo 'checked'; ?>/>
										<label for="navigation_style_center"><?php _e( 'Round', 'ktsttestimonialpro' ); ?><span class="mark"><?php _e( 'Pro', 'ktsttestimonialpro' ); ?></span></label>
									</div>					
								</td>
							</tr>
							<!-- End Navigation Style -->

							<tr valign="top" id="navi_color_controller" style="<?php if ( $navigation == 'false') {	echo "display:none;"; }?>">
								<th scope="row">
									<label for="nav_text_color"><?php _e( 'Navigation Color', 'ktsttestimonialpro' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Pick a color for navigation tool.', 'ktsttestimonialpro' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="text" id="nav_text_color" size="5" type="text" name="nav_text_color" value="<?php if ( $nav_text_color != '' ) {echo $nav_text_color; } else{ echo "#020202"; } ?>" class="timezone_string">
								</td>
							</tr>
							<!-- End Navigation Color -->

							<tr valign="top" id="navi_bgcolor_controller" style="<?php if ( $navigation == 'false') {	echo "display:none;"; }?>">
								<th scope="row">
									<label for="nav_bg_color"><?php _e( 'Navigation Background', 'ktsttestimonialpro' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Pick a color for background of navigation tool.', 'ktsttestimonialpro' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input id="nav_bg_color" type="text" name="nav_bg_color" value="<?php if ( $nav_bg_color !='' ) {echo $nav_bg_color; } else{ echo "#f5f5f5"; } ?>" class="timezone_string">
								</td>
							</tr>
							<!-- End Navigation Background Color -->

							<tr valign="top" id="navi_color_hover_controller" style="<?php if ( $navigation == 'false') {	echo "display:none;"; }?>">
								<th scope="row">
									<label for="nav_text_color_hover"><?php _e( 'Navigation Color(Hover)', 'ktsttestimonialpro' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Pick a color for navigation tool on mouse hover.', 'ktsttestimonialpro' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input id="nav_text_color_hover" type="text" name="nav_text_color_hover" value="<?php if ( $nav_text_color_hover != '' ) {echo $nav_text_color_hover; } else{ echo "#020202"; } ?>" class="timezone_string">
								</td>
							</tr>
							<!-- End Navigation Color Hover -->

							<tr valign="top" id="navi_bgcolor_hover_controller" style="<?php if ( $navigation == 'false') {	echo "display:none;"; }?>">
								<th scope="row">
									<label for="nav_bg_color_hover"><?php _e( 'Navigation Background(Hover)', 'ktsttestimonialpro' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Pick a color for background of navigation tool on mouse hover.', 'ktsttestimonialpro' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input id="nav_bg_color_hover" type="text" name="nav_bg_color_hover" value="<?php if ( $nav_bg_color_hover !='' ) {echo $nav_bg_color_hover; } else{ echo "#000000"; } ?>" class="timezone_string">
								</td>
							</tr>
							<!-- End Navigation Background Color -->

							<tr valign="top">
								<th scope="row">
									<label for="pagination"><?php _e( 'Pagination', 'ktsttestimonialpro' );?></label>	
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Choose an option whether you want pagination option or not.', 'ktsttestimonialpro' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="pagination_true" name="pagination" value="true" <?php if ( $pagination == 'true' || $pagination == '' ) echo 'checked'; ?>/>
										<label for="pagination_true"><?php _e( 'Yes', 'ktsttestimonialpro' ); ?></label>
										<input type="radio" id="pagination_false" name="pagination" value="false" <?php if ( $pagination == 'false' ) echo 'checked'; ?>/>
										<label for="pagination_false"><?php _e( 'No', 'ktsttestimonialpro' ); ?><span class="mark"><?php _e( 'Pro', 'ktsttestimonialpro' ); ?></span></label>
									</div>						
								</td>
							</tr>
							<!-- End Pagination -->
							
							<tr valign="top" id="pagi_align_controller" style="<?php if ( $pagination == 'false') {	echo "display:none;"; }?>">
								<th scope="row">
									<label for="pagination_align"><?php _e( 'Pagination Align', 'ktsttestimonialpro' );?></label>	
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Set the alignment of pagination.', 'ktsttestimonialpro' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="pagination_align_left" name="pagination_align" value="left" <?php if ( $pagination_align == 'left' ) echo 'checked'; ?>/>
										<label for="pagination_align_left"><?php _e( 'Left', 'ktsttestimonialpro' ); ?><span class="mark"><?php _e( 'Pro', 'ktsttestimonialpro' ); ?></span></label>
										<input type="radio" id="pagination_align_center" name="pagination_align" value="center" <?php if ( $pagination_align == 'center' || $pagination_align == '' ) echo 'checked'; ?>/>
										<label for="pagination_align_center"><?php _e( 'Center', 'ktsttestimonialpro' ); ?></label>
										<input type="radio" id="pagination_align_right" name="pagination_align" value="right" <?php if ( $pagination_align == 'right' ) echo 'checked'; ?>/>
										<label for="pagination_align_right"><?php _e( 'Right', 'ktsttestimonialpro' ); ?><span class="mark"><?php _e( 'Pro', 'ktsttestimonialpro' ); ?></span></label>
									</div>						
								</td>
							</tr>
							<!-- End Pagination Align -->

							<tr valign="top" id="pagi_style_controller" style="<?php if ( $pagination == 'false') {	echo "display:none;"; }?>">
								<th scope="row">
									<label for="pagination_style"><?php _e( 'Pagination Style', 'ktsttestimonialpro' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Set the style of pagination tool.', 'ktsttestimonialpro' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="pagination_style_left" name="pagination_style" value="0" <?php if ( $pagination_style == '0' ) echo 'checked'; ?>/>
										<label for="pagination_style_left"><?php _e( 'Default', 'ktsttestimonialpro' ); ?></label>
										<input type="radio" id="pagination_style_center" name="pagination_style" value="50" <?php if ( $pagination_style == '50' || $pagination_style == '' ) echo 'checked'; ?>/>
										<label for="pagination_style_center"><?php _e( 'Round', 'ktsttestimonialpro' ); ?><span class="mark"><?php _e( 'Pro', 'ktsttestimonialpro' ); ?></span></label>
									</div>						
								</td>
							</tr>
							<!-- End Navigation Style -->

							<tr valign="top" id="pagi_color_controller" style="<?php if ( $pagination == 'false') {	echo "display:none;"; }?>">
								<th scope="row">
									<label for="pagination_bg_color"><?php _e( 'Pagination Background Color', 'ktsttestimonialpro' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Pick a color for pagination content.', 'ktsttestimonialpro' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input id="pagination_bg_color" type="text" name="pagination_bg_color" value="<?php if ( $pagination_bg_color !='' ) {echo $pagination_bg_color; } else{ echo "#dddddd"; } ?>" class="timezone_string">
								</td>
							</tr><!-- End Pagination Background Color -->

							<tr valign="top" id="pagi_color_active_controller" style="<?php if ( $pagination == 'false') {	echo "display:none;"; }?>">
								<th scope="row">
									<label for="pagination_bg_color_active"><?php _e( 'Pagination Background(Active)', 'ktsttestimonialpro' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Pick a color for active pagination content.', 'ktsttestimonialpro' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input id="pagination_bg_color_active" type="text" name="pagination_bg_color_active" value="<?php if ( $pagination_bg_color_active !='' ) {echo $pagination_bg_color_active; } else{ echo "#9e9e9e"; } ?>" class="timezone_string">
								</td>
							</tr><!-- End Pagination Background Color -->

						</table>
					</div>
				</div>
			</li>
			<!-- Tab 5 -->
			<li style="<?php if($nav_value == 5){echo "display: block;";} else{ echo "display: none;"; }?>" class="box5 tab-box <?php if($nav_value == 5){echo "active";}?>">
				<div class="wrap">
					<div class="option-box">
						<p class="option-title"><?php _e( 'Grid Normal Settings ( Premium Only )','ktsttestimonialpro' ); ?></p>
						<table class="form-table">
							<tr valign="top">
								<th scope="row">
									<label for="grid_normal_column"><?php _e( 'Number of columns', 'ktsttestimonialpro' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Choose an option for posts column.', 'ktsttestimonialpro' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<select name="grid_normal_column" id="grid_normal_column" class="timezone_string">
										<option value="3" <?php if ( isset ( $grid_normal_column ) ) selected( $grid_normal_column, '3' ); ?>><?php _e( '3', 'ktsttestimonialpro' );?></option>
										<option value="1" <?php if ( isset ( $grid_normal_column ) ) selected( $grid_normal_column, '1' ); ?>><?php _e( '1', 'ktsttestimonialpro' );?></option>
										<option value="2" <?php if ( isset ( $grid_normal_column ) ) selected( $grid_normal_column, '2' ); ?>><?php _e( '2', 'ktsttestimonialpro' );?></option>
										<option value="4" <?php if ( isset ( $grid_normal_column ) ) selected( $grid_normal_column, '4' ); ?>><?php _e( '4', 'ktsttestimonialpro' );?></option>
										<option value="5" <?php if ( isset ( $grid_normal_column ) ) selected( $grid_normal_column, '5' ); ?>><?php _e( '5', 'ktsttestimonialpro' );?></option>
										<option value="6" <?php if ( isset ( $grid_normal_column ) ) selected( $grid_normal_column, '6' ); ?>><?php _e( '6', 'ktsttestimonialpro' );?></option>
									</select>
								</td>
							</tr>

							<tr valign="top">
								<th scope="row">
									<label for="filter_menu_styles"><?php _e( 'Filter Menu Style', 'ktsttestimonialpro' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Choose an option for filter menu style.', 'ktsttestimonialpro' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<select name="filter_menu_styles" id="filter_menu_styles" class="timezone_string">
										
										<option value="1" <?php if ( isset ( $filter_menu_styles ) ) selected( $filter_menu_styles, '1' ); ?>><?php _e( 'Normal', 'ktsttestimonialpro' );?></option>
										<option value="2" <?php if ( isset ( $filter_menu_styles ) ) selected( $filter_menu_styles, '2' ); ?>><?php _e( 'Checkbox', 'ktsttestimonialpro' );?></option>
										<option value="3" <?php if ( isset ( $filter_menu_styles ) ) selected( $filter_menu_styles, '3' ); ?>><?php _e( 'Drop Down', 'ktsttestimonialpro' );?></option>
									</select>
								</td>
							</tr>

							<tr>
								<th><u><?php echo __( 'Menu Styling', 'ktsttestimonialpro' ); ?></u></th>
								<td></td>
							</tr>

							<tr valign="top">
								<th scope="row">
									<label for="filter_menu_alignment"><?php _e( 'Menu Align', 'ktsttestimonialpro' ); ?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Choose an option for the alignment of filter menu.', 'ktsttestimonialpro' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="filter_menu_alignment1" name="filter_menu_alignment" value="left" <?php if ( $filter_menu_alignment == 'left' ) echo 'checked'; ?>/>
										<label for="filter_menu_alignment1"><?php _e( 'Left', 'ktsttestimonialpro' ); ?></label>
										<input type="radio" id="filter_menu_alignment2" name="filter_menu_alignment" value="center" <?php if ( $filter_menu_alignment == 'center' || $filter_menu_alignment == '' ) echo 'checked'; ?>/>
										<label for="filter_menu_alignment2"><?php _e( 'Center', 'ktsttestimonialpro' ); ?></label>
										<input type="radio" id="filter_menu_alignment3" name="filter_menu_alignment" value="right" <?php if ( $filter_menu_alignment == 'right' ) echo 'checked'; ?>/>
										<label for="filter_menu_alignment3"><?php _e( 'Right', 'ktsttestimonialpro' ); ?></label>
									</div>
								</td>
							</tr><!-- End Menu Align -->

							<tr valign="top">
								<th scope="row">
									<label for="filter_menu_bg_color"><?php _e( 'Background Color', 'ktsttestimonialpro' ); ?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Pick a color for filter menu background.', 'ktsttestimonialpro' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="text" id="filter_menu_bg_color" name="filter_menu_bg_color" value="<?php if ( $filter_menu_bg_color != '' ) { echo $filter_menu_bg_color; } else { echo "#f8f8f8"; } ?>" class="timezone_string">
								</td>
							</tr><!-- End Menu bg color -->

							<tr valign="top">
								<th scope="row">
									<label for="filter_menu_font_color"><?php _e( 'Font Color', 'ktsttestimonialpro' ); ?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Pick a color for text of filter menu.', 'ktsttestimonialpro' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="text" id="filter_menu_font_color" name="filter_menu_font_color" value="<?php if ( $filter_menu_font_color != '' ) { echo $filter_menu_font_color; } else { echo "#777777"; } ?>" class="timezone_string">
								</td>
							</tr><!-- End Menu text color -->

							<tr valign="top">
								<th scope="row">
									<label for="filter_menu_bg_color_hover"><?php _e( 'Background Color(Hover)', 'ktsttestimonialpro' ); ?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Pick a color for filter menu background on hover.', 'ktsttestimonialpro' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="text" id="filter_menu_bg_color_hover" name="filter_menu_bg_color_hover" value="<?php if ( $filter_menu_bg_color_hover != '' ) { echo $filter_menu_bg_color_hover; } else { echo "#003478"; } ?>" class="timezone_string">
								</td>
							</tr><!-- End Menu bg color on hover -->

							<tr valign="top">
								<th scope="row">
									<label for="filter_menu_font_color_hover"><?php _e( 'Font Color(Hover)', 'ktsttestimonialpro' ); ?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Pick a color for text of filter menu on hover.', 'ktsttestimonialpro' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="text" id="filter_menu_font_color_hover" name="filter_menu_font_color_hover" value="<?php if ( $filter_menu_font_color_hover != '' ) { echo $filter_menu_font_color_hover; } else { echo "#ffffff"; } ?>" class="timezone_string">
								</td>
							</tr><!-- End Menu text color on hover -->

							<tr valign="top">
								<th scope="row">
									<label for="filter_menu_bg_color_active"><?php _e( 'Background Color(Active)', 'ktsttestimonialpro' ); ?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Pick a color for filter menu background on hover.', 'ktsttestimonialpro' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="text" id="filter_menu_bg_color_active" name="filter_menu_bg_color_active" value="<?php if ( $filter_menu_bg_color_active != '' ) { echo $filter_menu_bg_color_active; } else { echo "#003478"; } ?>" class="timezone_string">
								</td>
							</tr><!-- End Menu bg color when active -->

							<tr valign="top">
								<th scope="row">
									<label for="filter_menu_font_color_active"><?php _e( 'Font Color(Active)', 'ktsttestimonialpro' ); ?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Pick a color for text of filter menu on hover.', 'ktsttestimonialpro' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="text" id="filter_menu_font_color_active" name="filter_menu_font_color_active" value="<?php if ( $filter_menu_font_color_active != '' ) { echo $filter_menu_font_color_active; } else { echo "#ffffff"; } ?>" class="timezone_string">
								</td>
							</tr><!-- End Menu text color when active -->

						</table>
					</div>
				</div>
			</li>
		</ul>
	</div>
	<script type="text/javascript">
		jQuery( document ).ready( function( jQuery ) {
			jQuery( '#tp_item_bg_color, #tp_rating_color, #tp_content_bg_color, #tp_content_color, #tp_company_url_color, #tp_designation_color_option, #tp_name_color_option, #tp_imgborder_color_option, #nav_text_color, #nav_bg_color, #nav_text_color_hover, #nav_bg_color_hover, #pagination_bg_color, #pagination_bg_color_active, #filter_menu_bg_color, #filter_menu_font_color, #filter_menu_font_color_active, #filter_menu_bg_color_active, #filter_menu_font_color_hover, #filter_menu_bg_color_hover' ).wpColorPicker();
		} );
	</script>
	<?php }   //	

# Data save in custom metabox field
function tp_testimonial_meta_box_save_func( $post_id ) {

	# Doing autosave then return.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return;

	#Checks for input and saves if needed
	if ( isset( $_POST[ 'testimonial_cat_name' ] ) ) {
	    update_post_meta( $post_id, 'testimonial_cat_name', $_POST['testimonial_cat_name'] );
	}
	else {
    	delete_post_meta( $post_id, 'testimonial_cat_name' );
  	}
	
	#Checks for input and saves if needed
	if ( isset( $_POST[ 'tp_name_color_option' ] ) ) {
	    update_post_meta( $post_id, 'tp_name_color_option', $_POST['tp_name_color_option'] );
	}
	
	#Checks for input and saves if needed
	if ( isset( $_POST[ 'tp_designation_color_option' ] ) ) {
	    update_post_meta( $post_id, 'tp_designation_color_option', $_POST['tp_designation_color_option'] );
	}

	#Checks for input and saves if needed
	if ( isset( $_POST[ 'tp_testimonial_themes' ] ) ) {
	    update_post_meta( $post_id, 'tp_testimonial_themes', $_POST['tp_testimonial_themes'] );
	}

	#Checks for input and saves if needed
	if ( isset( $_POST[ 'tp_testimonial_theme_style' ] ) ) {
	    update_post_meta( $post_id, 'tp_testimonial_theme_style', $_POST['tp_testimonial_theme_style'] );
	}
	
	#Checks for input and saves if needed
	if ( isset( $_POST[ 'tp_testimonial_textalign' ] ) ) {
	    update_post_meta( $post_id, 'tp_testimonial_textalign', $_POST['tp_testimonial_textalign'] );
	}

	#Checks for input and saves if needed
	if ( isset( $_POST[ 'tp_order_by_option' ] ) ) {
	    update_post_meta( $post_id, 'tp_order_by_option', $_POST[ 'tp_order_by_option' ] );
	}

	#Checks for input and saves if needed
	if ( isset( $_POST[ 'tp_order_option' ] ) ) {
	    update_post_meta( $post_id, 'tp_order_option', $_POST[ 'tp_order_option' ] );
	}


	#Checks for input and saves if needed
	if ( isset( $_POST[ 'tp_image_sizes' ] ) ) {
	    update_post_meta( $post_id, 'tp_image_sizes', $_POST[ 'tp_image_sizes' ] );
	}

	#Checks for input and saves if needed
	if ( isset( $_POST[ 'dpstotoal_items' ] ) ) {
	    update_post_meta( $post_id, 'dpstotoal_items', $_POST[ 'dpstotoal_items' ] );
	}

	#Checks for input and saves if needed
	if ( isset( $_POST[ 'tp_img_show_hide' ] ) ) {
	    update_post_meta( $post_id, 'tp_img_show_hide', $_POST[ 'tp_img_show_hide' ] );
	}

	#Checks for input and saves if needed
	if ( isset( $_POST[ 'tp_img_border_radius' ] ) ) {
	    update_post_meta( $post_id, 'tp_img_border_radius', $_POST[ 'tp_img_border_radius' ] );
	}
	
	#Checks for input and saves if needed
	if ( isset( $_POST[ 'tp_imgborder_width_option' ] ) ) {
	    update_post_meta( $post_id, 'tp_imgborder_width_option', $_POST[ 'tp_imgborder_width_option' ] );
	}

	#Checks for input and saves if needed
	if ( isset( $_POST[ 'tp_imgborder_color_option' ] ) ) {
	    update_post_meta( $post_id, 'tp_imgborder_color_option', $_POST[ 'tp_imgborder_color_option' ] );
	}
	
	#Checks for input and saves if needed
	if ( isset( $_POST[ 'tp_designation_show_hide' ] ) ) {
	    update_post_meta( $post_id, 'tp_designation_show_hide', $_POST[ 'tp_designation_show_hide' ] );
	}
	
	#Checks for input and saves if needed
	if ( isset( $_POST[ 'tp_company_show_hide' ] ) ) {
	    update_post_meta( $post_id, 'tp_company_show_hide', $_POST[ 'tp_company_show_hide' ] );
	}
	
	#Checks for input and saves if needed
	if ( isset( $_POST[ 'tp_company_url_color' ] ) ) {
	    update_post_meta( $post_id, 'tp_company_url_color', $_POST[ 'tp_company_url_color' ] );
	}
	
	#Checks for input and saves
	if ( isset( $_POST[ 'tp_name_fontsize_option' ] ) ) {
	    update_post_meta( $post_id, 'tp_name_fontsize_option', esc_html( $_POST['tp_name_fontsize_option'] ) );
	}

	#Checks for input and saves
	if ( isset( $_POST[ 'tp_name_font_case' ] ) ) {
	    update_post_meta( $post_id, 'tp_name_font_case', esc_html( $_POST['tp_name_font_case'] ) );
	}

	#Checks for input and saves
	if ( isset( $_POST[ 'tp_name_font_style' ] ) ) {
	    update_post_meta( $post_id, 'tp_name_font_style', esc_html( $_POST['tp_name_font_style'] ) );
	}

	#Checks for input and saves
	if ( isset( $_POST[ 'tp_designation_case' ] ) ) {
	    update_post_meta( $post_id, 'tp_designation_case', esc_html( $_POST['tp_designation_case'] ) );
	}

	#Checks for input and saves
	if ( isset( $_POST[ 'tp_designation_font_style' ] ) ) {
	    update_post_meta( $post_id, 'tp_designation_font_style', esc_html( $_POST['tp_designation_font_style'] ) );
	}
	
	#Checks for input and saves
	if ( isset( $_POST[ 'tp_desig_fontsize_option' ] ) ) {
	    update_post_meta( $post_id, 'tp_desig_fontsize_option', esc_html( $_POST['tp_desig_fontsize_option'] ) );
	}
	
	#Checks for input and saves
	if ( isset( $_POST[ 'tp_content_fontsize_option' ] ) ) {
	    update_post_meta( $post_id, 'tp_content_fontsize_option', esc_html( $_POST['tp_content_fontsize_option'] ) );
	}
	
	#Checks for input and saves
	if ( isset( $_POST[ 'tp_content_bg_color' ] ) ) {
	    update_post_meta( $post_id, 'tp_content_bg_color', esc_html( $_POST['tp_content_bg_color'] ) );
	}
	
	#Checks for input and saves
	if ( isset( $_POST[ 'tp_rating_fontsize_option' ] ) ) {
	    update_post_meta( $post_id, 'tp_rating_fontsize_option', esc_html( $_POST['tp_rating_fontsize_option'] ) );
	}
	
	#Checks for input and saves
	if ( isset( $_POST[ 'tp_content_color' ] ) ) {
	    update_post_meta( $post_id, 'tp_content_color', esc_html( $_POST['tp_content_color'] ) );
	}

	#Checks for input and saves if needed
	if ( isset( $_POST[ 'tp_show_rating_option' ] ) ) {
	    update_post_meta( $post_id, 'tp_show_rating_option', $_POST[ 'tp_show_rating_option' ] );
	}

	#Checks for input and saves if needed
	if ( isset( $_POST[ 'tp_show_item_bg_option' ] ) ) {
	    update_post_meta( $post_id, 'tp_show_item_bg_option', $_POST[ 'tp_show_item_bg_option' ] );
	}

	#Checks for input and saves
	if ( isset( $_POST[ 'tp_rating_color' ] ) ) {
	    update_post_meta( $post_id, 'tp_rating_color', esc_html( $_POST['tp_rating_color'] ) );
	}

	#Checks for input and saves
	if ( isset( $_POST[ 'tp_item_bg_color' ] ) ) {
	    update_post_meta( $post_id, 'tp_item_bg_color', esc_html( $_POST['tp_item_bg_color'] ) );
	}
	#Checks for input and saves
	if ( isset( $_POST[ 'tp_item_padding' ] ) ) {
	    update_post_meta( $post_id, 'tp_item_padding', esc_html( $_POST['tp_item_padding'] ) );
	}

    // Carousal Settings

	#Checks for input and sanitizes/saves if needed
    if ( isset( $_POST['item_no'] ) && ( $_POST['item_no'] != '' ) ) {
        update_post_meta( $post_id, 'item_no', esc_html( $_POST['item_no'] ) );
    }

 	#Checks for input and sanitizes/saves if needed    
    if ( isset( $_POST['loop'] ) && ( $_POST['loop'] != '' ) ) {
        update_post_meta( $post_id, 'loop', esc_html( $_POST['loop'] ) );
    }

 	#Checks for input and sanitizes/saves if needed    
    if ( isset( $_POST['margin'] ) ) {
    	//print_r($_POST['margin']);die();
    	update_post_meta( $post_id, 'margin', $_POST['margin'] );
    }

 	#Checks for input and sanitizes/saves if needed    
    if ( isset( $_POST['navigation'] ) && ( $_POST['navigation'] != '' ) ) {
        update_post_meta( $post_id, 'navigation', esc_html( $_POST['navigation'] ) );
    }
	
 	#Checks for input and sanitizes/saves if needed    
    if ( isset( $_POST['navigation_align'] ) && ( $_POST['navigation_align'] != '' ) ) {
        update_post_meta( $post_id, 'navigation_align', esc_html( $_POST['navigation_align'] ) );
    }

    #Checks for input and sanitizes/saves if needed    
    if ( isset( $_POST['navigation_style'] ) && ( $_POST['navigation_style'] != '' ) ) {
        update_post_meta( $post_id, 'navigation_style', esc_html( $_POST['navigation_style'] ) );
    }

 	#Checks for input and sanitizes/saves if needed    
    if ( isset( $_POST['pagination'] ) && ( $_POST['pagination'] != '' ) ) {
        update_post_meta( $post_id, 'pagination', esc_html( $_POST['pagination'] ) );
    }

 	#Checks for input and sanitizes/saves if needed    
    if ( isset( $_POST['pagination_align'] ) && ( $_POST['pagination_align'] != '' ) ) {
        update_post_meta( $post_id, 'pagination_align', esc_html( $_POST['pagination_align'] ) );
    }

    #Checks for input and sanitizes/saves if needed    
    if ( isset( $_POST['pagination_style'] ) && ( $_POST['pagination_style'] != '' ) ) {
        update_post_meta( $post_id, 'pagination_style', esc_html( $_POST['pagination_style'] ) );
    }  

 	#Checks for input and sanitizes/saves if needed    
    if ( isset( $_POST['grid_normal_column'] ) && ( $_POST['grid_normal_column'] != '' ) ) {
        update_post_meta( $post_id, 'grid_normal_column', esc_html( $_POST['grid_normal_column'] ) );
    }

    #Checks for input and sanitizes/saves if needed    
    if ( isset( $_POST['filter_menu_styles'] ) && ( $_POST['filter_menu_styles'] != '' ) ) {
        update_post_meta( $post_id, 'filter_menu_styles', esc_html( $_POST['filter_menu_styles'] ) );
    }

    #Checks for input and sanitizes/saves if needed    
    if ( isset( $_POST['filter_menu_alignment'] ) && ( $_POST['filter_menu_alignment'] != '' ) ) {
        update_post_meta( $post_id, 'filter_menu_alignment', esc_html( $_POST['filter_menu_alignment'] ) );
    }

    #Checks for input and sanitizes/saves if needed    
    if ( isset( $_POST['filter_menu_bg_color'] ) && ( $_POST['filter_menu_bg_color'] != '' ) ) {
        update_post_meta( $post_id, 'filter_menu_bg_color', esc_html( $_POST['filter_menu_bg_color'] ) );
    } 

    #Checks for input and sanitizes/saves if needed    
    if ( isset( $_POST['filter_menu_bg_color_hover'] ) && ( $_POST['filter_menu_bg_color_hover'] != '' ) ) {
        update_post_meta( $post_id, 'filter_menu_bg_color_hover', esc_html( $_POST['filter_menu_bg_color_hover'] ) );
    } 

    #Checks for input and sanitizes/saves if needed    
    if ( isset( $_POST['filter_menu_bg_color_active'] ) && ( $_POST['filter_menu_bg_color_active'] != '' ) ) {
        update_post_meta( $post_id, 'filter_menu_bg_color_active', esc_html( $_POST['filter_menu_bg_color_active'] ) );
    } 

    #Checks for input and sanitizes/saves if needed    
    if ( isset( $_POST['filter_menu_font_color'] ) && ( $_POST['filter_menu_font_color'] != '' ) ) {
        update_post_meta( $post_id, 'filter_menu_font_color', esc_html( $_POST['filter_menu_font_color'] ) );
    } 

    #Checks for input and sanitizes/saves if needed    
    if ( isset( $_POST['filter_menu_font_color_hover'] ) && ( $_POST['filter_menu_font_color_hover'] != '' ) ) {
        update_post_meta( $post_id, 'filter_menu_font_color_hover', esc_html( $_POST['filter_menu_font_color_hover'] ) );
    } 

    #Checks for input and sanitizes/saves if needed    
    if ( isset( $_POST['filter_menu_font_color_active'] ) && ( $_POST['filter_menu_font_color_active'] != '' ) ) {
        update_post_meta( $post_id, 'filter_menu_font_color_active', esc_html( $_POST['filter_menu_font_color_active'] ) );
    } 

    #Checks for input and sanitizes/saves if needed    
    if ( isset( $_POST['pagination_bg_color'] ) && ( $_POST['pagination_bg_color'] != '' ) ) {
        update_post_meta( $post_id, 'pagination_bg_color', esc_html( $_POST['pagination_bg_color'] ) );
    } 

    #Checks for input and sanitizes/saves if needed    
    if ( isset( $_POST['pagination_bg_color_active'] ) && ( $_POST['pagination_bg_color_active'] != '' ) ) {
        update_post_meta( $post_id, 'pagination_bg_color_active', esc_html( $_POST['pagination_bg_color_active'] ) );
    }    
    
 	#Checks for input and sanitizes/saves if needed    
    if ( isset( $_POST['autoplay'] ) && ( $_POST['autoplay'] != '' ) ) {
        update_post_meta( $post_id, 'autoplay', esc_html( $_POST['autoplay'] ) );
    }
    
 	#Checks for input and sanitizes/saves if needed    
    if ( ! empty( $_POST['autoplay_speed'] ) ) {
    	if (strlen( $_POST['autoplay_speed'] ) > 4 ) {
    		
    	} else {

    		if ( $_POST['autoplay_speed'] == '' || is_null( $_POST['autoplay_speed'] ) ) {
    			
    			update_post_meta( $post_id, 'autoplay_speed', 700 );
    		}
    		else{
	    		if ( is_numeric( $_POST['autoplay_speed'] ) && strlen( $_POST['autoplay_speed'] ) <= 4 ) {

	    			update_post_meta( $post_id, 'autoplay_speed', esc_html( $_POST['autoplay_speed'] ) );

	    		}
    		}
    	}
    }

 	#Checks for input and sanitizes/saves if needed    
    if ( isset( $_POST['stop_hover'] ) && ( $_POST['stop_hover'] != '' ) ) {
        update_post_meta( $post_id, 'stop_hover', esc_html( $_POST['stop_hover'] ) );
    }

 	#Checks for input and sanitizes/saves if needed    
    if ( isset( $_POST['itemsdesktop'] ) && ( $_POST['itemsdesktop'] != '' ) ) {
        update_post_meta( $post_id, 'itemsdesktop', esc_html( $_POST['itemsdesktop'] ) );
    }

 	#Checks for input and sanitizes/saves if needed    
    if ( isset( $_POST['itemsdesktopsmall'] ) && ( $_POST['itemsdesktopsmall'] != '' ) ) {
        update_post_meta( $post_id, 'itemsdesktopsmall', esc_html( $_POST['itemsdesktopsmall'] ) );
    }

 	#Checks for input and sanitizes/saves if needed    
    if ( isset( $_POST['itemsmobile'] ) && ( $_POST['itemsmobile'] != '' ) ) {
        update_post_meta( $post_id, 'itemsmobile', esc_html( $_POST['itemsmobile'] ) );
    }

 	#Checks for input and sanitizes/saves if needed    
    if ( isset( $_POST['autoplaytimeout'] ) && ( $_POST['autoplaytimeout'] != '' ) ) {
        update_post_meta( $post_id, 'autoplaytimeout', esc_html( $_POST['autoplaytimeout'] ) );
    }

 	#Checks for input and sanitizes/saves if needed    
    if ( isset( $_POST['nav_text_color'] ) && ( $_POST['nav_text_color'] != '' ) ) {
        update_post_meta( $post_id, 'nav_text_color', esc_html( $_POST['nav_text_color'] ) );
    }

    #Checks for input and sanitizes/saves if needed    
    if ( isset( $_POST['nav_text_color_hover'] ) && ( $_POST['nav_text_color_hover'] != '' ) ) {
        update_post_meta( $post_id, 'nav_text_color_hover', esc_html( $_POST['nav_text_color_hover'] ) );
    }

 	#Checks for input and sanitizes/saves if needed    
    if ( isset( $_POST['nav_bg_color'] ) && ( $_POST['nav_bg_color'] != '' ) ) {
        update_post_meta( $post_id, 'nav_bg_color', esc_html( $_POST['nav_bg_color'] ) );
    }

    #Checks for input and sanitizes/saves if needed    
    if ( isset( $_POST['nav_bg_color_hover'] ) && ( $_POST['nav_bg_color_hover'] != '' ) ) {
        update_post_meta( $post_id, 'nav_bg_color_hover', esc_html( $_POST['nav_bg_color_hover'] ) );
    }

    #Value check and saves if needed
    if ( isset( $_POST[ 'nav_value' ] ) ) {
    	update_post_meta( $post_id, 'nav_value', $_POST['nav_value'] );
    } else {
    	update_post_meta( $post_id, 'nav_value', 1 );
    }
}
add_action( 'save_post', 'tp_testimonial_meta_box_save_func' );
# Custom metabox field end