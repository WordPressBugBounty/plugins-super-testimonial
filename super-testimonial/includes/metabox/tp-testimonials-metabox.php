<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Function to add submenu page under Testimonia
function tps_super_testimonials_add_submenu_items() {
	add_submenu_page( 'edit.php?post_type=ktsprotype', __( 'Generate Shortcode', 'ktsttestimonial' ), __( 'Generate Shortcode', 'ktsttestimonial' ), 'manage_options', 'post-new.php?post_type=tptscode' );
}
add_action( 'admin_menu', 'tps_super_testimonials_add_submenu_items' );

// Function to register the custom post type 'tptscode' for Shortcode generation
function ps_super_testimonials_shortcode_generator_type() {
	// Set UI labels for Custom Post Type
	$labels = array(
		'name'                => _x( 'Testimonials', 'Post Type General Name', 'ktsttestimonial' ),
		'singular_name'       => _x( 'Testimonial', 'Post Type Singular Name', 'ktsttestimonial' ),
		'menu_name'           => __( 'Testimonials', 'ktsttestimonial' ),
		'parent_item_colon'   => __( 'Parent Shortcode', 'ktsttestimonial' ),
		'all_items'           => __( 'All Shortcode', 'ktsttestimonial' ),
		'view_item'           => __( 'View Shortcode', 'ktsttestimonial' ),
		'add_new_item'        => __( 'Generate Shortcode', 'ktsttestimonial' ),
		'add_new'             => __( 'Generate New Shortcode', 'ktsttestimonial' ),
		'edit_item'           => __( 'Edit Testimonial', 'ktsttestimonial' ),
		'update_item'         => __( 'Update Testimonial', 'ktsttestimonial' ),
		'search_items'        => __( 'Search Testimonial', 'ktsttestimonial' ),
		'not_found'           => __( 'Shortcode Not Found', 'ktsttestimonial' ),
		'not_found_in_trash'  => __( 'Shortcode Not found in Trash', 'ktsttestimonial' ),
	);

	// Set other options for Custom Post Type
	$args = array(
		'label'               => __( 'Testimonial Shortcode', 'ktsttestimonial' ),
		'description'         => __( 'Shortcode news and reviews', 'ktsttestimonial' ),
		'labels'              => $labels,
		'supports'            => array( 'title' ), // Only title is needed
		'hierarchical'        => false, // This post type doesn't need hierarchy (no parent-child posts)
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu' 		  => 'edit.php?post_type=ktsprotype', // Show under the existing Testimonials menu
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5, // Position in the admin menu
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page', // Uses the same capabilities as pages
	);

	// Registering the custom post type for the shortcode generator
	register_post_type( 'tptscode', $args );
}
add_action( 'init', 'ps_super_testimonials_shortcode_generator_type' );	

// Adding custom columns to display the shortcode in the admin post list
function tps_super_testimonials_shortcode_clmn( $columns ) {
	// Merge the existing columns with the new ones for Shortcode and Template Shortcode
	return array_merge( $columns, 
	    array( 
	  		'shortcode' 	=> __( 'Shortcode', 'ktsttestimonial' ),
	  		'doshortcode' 	=> __( 'Template Shortcode', 'ktsttestimonial' ) 
	  	)
	);
}
add_filter( 'manage_tptscode_posts_columns' , 'tps_super_testimonials_shortcode_clmn' );

// Display content for the custom columns in the post list
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


// Register meta box for the 'tptscode' custom post type
function tp_testimonial_shortcode_register_meta_boxes() {
	$attend = array( 'tptscode' ); // Define post types where this meta box will appear

	// Add the meta box
    add_meta_box( 
        'custom_meta_box_id', // Meta box ID
        __( 'Testimonial Settings', 'ktsttestimonial' ), // Meta box title
        'tp_testimonials_display_post_type_func', // Callback function that displays the meta box content
       	$attend, // The post types for which the meta box is added
        'normal' // The part of the page where the meta box should be displayed (normal, side, advanced)
    );
}
add_action( 'add_meta_boxes', 'tp_testimonial_shortcode_register_meta_boxes' );


# Call Back Function...
function tp_testimonials_display_post_type_func( $post, $args ) {

	#Call get post meta.
	$testimonial_cat_name          = get_post_meta( $post->ID, 'testimonial_cat_name', true );
	$tp_testimonial_themes         = get_post_meta( $post->ID, 'tp_testimonial_themes', true );
	$tp_testimonial_theme_style    = get_post_meta( $post->ID, 'tp_testimonial_theme_style', true );
	$tp_order_by_option            = get_post_meta( $post->ID, 'tp_order_by_option', true );
	$tp_order_option               = get_post_meta( $post->ID, 'tp_order_option', true );
	$tp_image_sizes                = get_post_meta( $post->ID, 'tp_image_sizes', true );
	$dpstotoal_items               = get_post_meta( $post->ID, 'dpstotoal_items', true );
	$tp_testimonial_textalign      = get_post_meta( $post->ID, 'tp_testimonial_textalign', true );
	$tp_img_show_hide              = get_post_meta( $post->ID, 'tp_img_show_hide', true );
	$tp_img_border_radius          = get_post_meta( $post->ID, 'tp_img_border_radius', true );
	$tp_imgborder_width_option     = get_post_meta( $post->ID, 'tp_imgborder_width_option', true );
	$tp_imgborder_color_option     = get_post_meta( $post->ID, 'tp_imgborder_color_option', true );
	$tp_title_color_option         = get_post_meta( $post->ID, 'tp_title_color_option', true );
	$tp_title_fontsize_option      = get_post_meta( $post->ID, 'tp_title_fontsize_option', true );
	$tp_title_font_case            = get_post_meta( $post->ID, 'tp_title_font_case', true );
	$tp_title_font_style           = get_post_meta( $post->ID, 'tp_title_font_style', true );
	$tp_name_color_option          = get_post_meta( $post->ID, 'tp_name_color_option', true );
	$tp_name_fontsize_option       = get_post_meta( $post->ID, 'tp_name_fontsize_option', true );
	$tp_name_font_case             = get_post_meta( $post->ID, 'tp_name_font_case', true );
	$tp_name_font_style            = get_post_meta( $post->ID, 'tp_name_font_style', true );
	$tp_designation_show_hide      = get_post_meta( $post->ID, 'tp_designation_show_hide', true );
	$tp_desig_fontsize_option      = get_post_meta( $post->ID, 'tp_desig_fontsize_option', true );
	$tp_designation_color_option   = get_post_meta( $post->ID, 'tp_designation_color_option', true );
	$tp_designation_case           = get_post_meta( $post->ID, 'tp_designation_case', true );
	$tp_designation_font_style     = get_post_meta( $post->ID, 'tp_designation_font_style', true );
	$tp_content_color              = get_post_meta( $post->ID, 'tp_content_color', true );
	$tp_content_fontsize_option    = get_post_meta( $post->ID, 'tp_content_fontsize_option', true );
	$tp_content_bg_color           = get_post_meta( $post->ID, 'tp_content_bg_color', true );
	$tp_company_show_hide          = get_post_meta( $post->ID, 'tp_company_show_hide', true );
	$tp_company_url_color          = get_post_meta( $post->ID, 'tp_company_url_color', true );
	$tp_show_rating_option         = get_post_meta( $post->ID, 'tp_show_rating_option', true );
	$tp_show_item_bg_option        = get_post_meta( $post->ID, 'tp_show_item_bg_option', true );
	$tp_rating_color               = get_post_meta( $post->ID, 'tp_rating_color', true );
	$tp_item_bg_color              = get_post_meta( $post->ID, 'tp_item_bg_color', true );
	$tp_item_padding               = get_post_meta( $post->ID, 'tp_item_padding', true );
	$tp_rating_fontsize_option     = get_post_meta( $post->ID, 'tp_rating_fontsize_option', true );
	
	#Call get post meta for slider settings.
	$item_no                       = get_post_meta( $post->ID, 'item_no', true );
	$loop                          = get_post_meta( $post->ID, 'loop', true );
	$margin                        = get_post_meta( $post->ID, 'margin', true );
	$navigation                    = get_post_meta( $post->ID, 'navigation', true );
	$pagination                    = get_post_meta( $post->ID, 'pagination', true );
	$autoplay                      = get_post_meta( $post->ID, 'autoplay', true );
	$autoplay_speed                = get_post_meta( $post->ID, 'autoplay_speed', true );
	$stop_hover                    = get_post_meta( $post->ID, 'stop_hover', true );
	$itemsdesktop                  = get_post_meta( $post->ID, 'itemsdesktop', true );
	$itemsdesktopsmall             = get_post_meta( $post->ID, 'itemsdesktopsmall', true );
	$itemsmobile                   = get_post_meta( $post->ID, 'itemsmobile', true );
	$autoplaytimeout               = get_post_meta( $post->ID, 'autoplaytimeout', true );
	$nav_text_color                = get_post_meta( $post->ID, 'nav_text_color', true );	
	$nav_text_color_hover          = get_post_meta( $post->ID, 'nav_text_color_hover', true );	
	$nav_bg_color                  = get_post_meta( $post->ID, 'nav_bg_color', true );
	$nav_bg_color_hover            = get_post_meta( $post->ID, 'nav_bg_color_hover', true );
	$navigation_align              = get_post_meta( $post->ID, 'navigation_align', true );
	$navigation_style              = get_post_meta( $post->ID, 'navigation_style', true );
	$pagination_bg_color           = get_post_meta( $post->ID, 'pagination_bg_color', true );
	$pagination_bg_color_active    = get_post_meta( $post->ID, 'pagination_bg_color_active', true );
	$grid_normal_column            = get_post_meta( $post->ID, 'grid_normal_column', true );
	$filter_menu_styles            = get_post_meta( $post->ID, 'filter_menu_styles', true );
	$testimonial_filter_menu_text  = get_post_meta( $post->ID, 'testimonial_filter_menu_text', true );
	$filter_menu_alignment         = get_post_meta( $post->ID, 'filter_menu_alignment', true );
	$filter_menu_bg_color          = get_post_meta( $post->ID, 'filter_menu_bg_color', true );
	$filter_menu_bg_color_hover    = get_post_meta( $post->ID, 'filter_menu_bg_color_hover', true );
	$filter_menu_bg_color_active   = get_post_meta( $post->ID, 'filter_menu_bg_color_active', true );
	$filter_menu_font_color        = get_post_meta( $post->ID, 'filter_menu_font_color', true );
	$filter_menu_font_color_hover  = get_post_meta( $post->ID, 'filter_menu_font_color_hover', true );
	$filter_menu_font_color_active = get_post_meta( $post->ID, 'filter_menu_font_color_active', true );
	$pagination_align              = get_post_meta( $post->ID, 'pagination_align', true );
	$pagination_style              = get_post_meta( $post->ID, 'pagination_style', true );
	$nav_value                     = get_post_meta( $post->ID, 'nav_value', true );
	
	$tp_testimonial_theme_style    = ($tp_testimonial_theme_style) ? $tp_testimonial_theme_style : 1;
	$grid_normal_column            = ($grid_normal_column) ? $grid_normal_column : 3;
	$filter_menu_styles            = ($filter_menu_styles) ? $filter_menu_styles : 1;
	$filter_menu_alignment         = ($filter_menu_alignment) ? $filter_menu_alignment : 'center';
	$filter_menu_bg_color          = ($filter_menu_bg_color) ? $filter_menu_bg_color : '#f8f8f8';
	$filter_menu_bg_color_hover    = ($filter_menu_bg_color_hover) ? $filter_menu_bg_color_hover : '#003478';
	$filter_menu_bg_color_active   = ($filter_menu_bg_color_active) ? $filter_menu_bg_color_active : '#003478';
	$filter_menu_font_color        = ($filter_menu_font_color) ? $filter_menu_font_color : '#777777';
	$filter_menu_font_color_hover  = ($filter_menu_font_color_hover) ? $filter_menu_font_color_hover : '#ffffff';
	$filter_menu_font_color_active = ($filter_menu_font_color_active) ? $filter_menu_font_color_active : '#ffffff';
	$nav_text_color_hover          = ($nav_text_color_hover) ? $nav_text_color_hover : '#020202';
	$nav_bg_color_hover            = ($nav_bg_color_hover) ? $nav_bg_color_hover : '#dddddd';
	$pagination_bg_color_active    = ($pagination_bg_color_active) ? $pagination_bg_color_active : '#9e9e9e';
	$navigation_style              = ($navigation_style) ? $navigation_style : '0';
	$pagination_style              = ($pagination_style) ? $pagination_style : '0';
	$testimonial_filter_menu_text  = ($testimonial_filter_menu_text) ? $testimonial_filter_menu_text : 'All';

	?>

	<div class="tupsetings post-grid-metabox">
		<!-- <div class="wrap"> -->
		<ul class="tab-nav">
			<li nav="1" class="nav1 <?php if ( $nav_value == 1 ) { echo "active"; } ?>"><?php _e( 'Shortcodes','ktsttestimonial' ); ?></li>
			<li nav="2" class="nav2 <?php if ( $nav_value == 2 ) { echo "active"; } ?>"><?php _e( 'Testimonial Query ','ktsttestimonial' ); ?></li>
			<li nav="3" class="nav3 <?php if ( $nav_value == 3 ) { echo "active"; } ?>"><?php _e( 'General Settings ','ktsttestimonial' ); ?></li>
			<li nav="4" class="nav4 <?php if ( $nav_value == 4 ) { echo "active"; } ?>"><?php _e( 'Slider Settings','ktsttestimonial' ); ?></li>
			<li nav="5" class="nav5 <?php if ( $nav_value == 5 ) { echo "active"; } ?>"><?php _e( 'Grid Settings','ktsttestimonial' ); ?></li>
		</ul> <!-- tab-nav end -->

		<?php 
		$getNavValue = "";
		if ( ! empty( $nav_value ) ) { $getNavValue = $nav_value; } else { $getNavValue = 1; }
		?>
		<input type="hidden" name="nav_value" id="nav_value" value="<?php echo esc_attr( $getNavValue ); ?>">

		<ul class="box">
			<!-- Tab 1 -->
			<li style="<?php if ( $nav_value == 1 ) { echo "display: block;"; } else { echo "display: none;"; } ?>" class="box1 tab-box <?php if ( $nav_value == 1 ) { echo "active"; } ?>">
				<div class="option-box">
					<p class="option-title"><?php _e( 'Shortcode','ktsttestimonial' ); ?></p>
					<p class="option-info"><?php _e( 'Copy this shortcode and paste on post, page or text widgets where you want to display Testimonial Showcase.','ktsttestimonial' ); ?></p>
					<textarea cols="50" rows="1" onClick="this.select();" >[tptpro <?php echo 'id="'.$post->ID.'"';?>]</textarea>
					<br /><br />
					<p class="option-info"><?php _e( 'PHP Code:','ktsttestimonial' ); ?></p>
					<p class="option-info"><?php _e( 'Use PHP code to your themes file to display Testimonial Showcase.','ktsttestimonial' ); ?></p>
					<textarea cols="50" rows="2" onClick="this.select();" ><?php echo '<?php echo do_shortcode("[tptpro id='; echo "'".$post->ID."']"; echo '"); ?>'; ?></textarea>  
				</div>
			</li>
			<!-- Tab 2 -->
			<li style="<?php if($nav_value == 2){echo "display: block;";} else{ echo "display: none;"; }?>" class="box2 tab-box <?php if($nav_value == 2){echo "active";}?>">
				<div class="wrap">
					<div class="option-box">
						<p class="option-title"><?php _e( 'Testimonial Query','ktsttestimonial' ); ?></p>
						<table class="form-table">
							<tr valign="top">
								<th scope="row">
									<label for="testimonial_cat_name"><?php _e( 'Select Categories', 'ktsttestimonial' ); ?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __('The category names will only be visible when testimonials are published within specific categories.', 'ktsttestimonial' ); ?></span>
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
											        echo'<li id="cat-'.$cat_id.'"><input type="checkbox" name="testimonial_cat_name[]" id="'.$cat_id.'" value="'.$cat_id.'"'.$checked.'> <label for="'.$cat_id.'">'.__( $category->cat_name, 'ktsttestimonial' ).'</label></li>';
											endforeach;
										?>
									</ul>
									<span class="tpstestimonial_manager_hint"><?php echo __('Choose multiple categories for each testimonial.', 'ktsttestimonial' ); ?></span>
								</td>
							</tr><!-- End Testimonial Categories -->

							<tr valign="top">
								<th scope="row">
									<label for="tp_testimonial_themes"><?php _e( 'Select Theme', 'ktsttestimonial' ); ?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __('Select a theme which you want to display.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<select name="tp_testimonial_themes" id="tp_testimonial_themes" class="timezone_string">
										<option value="1" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '1' ); ?>><?php _e( 'Theme 1', 'ktsttestimonial' );?></option>
										<option value="2" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '2' ); ?>><?php _e( 'Theme 2', 'ktsttestimonial' );?></option>
										<option value="3" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '3' ); ?>><?php _e( 'Theme 3', 'ktsttestimonial' );?></option>
										<option value="4" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '4' ); ?>><?php _e( 'Theme 4', 'ktsttestimonial' );?></option>
										<option value="5" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '5' ); ?>><?php _e( 'Theme 5', 'ktsttestimonial' );?></option>
										<option value="6" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '6' ); ?>><?php _e( 'Theme 6 (Pro)', 'ktsttestimonial' );?></option>
										<option value="7" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '7' ); ?>><?php _e( 'Theme 7 (Pro)', 'ktsttestimonial' );?></option>
										<option value="8" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '8' ); ?>><?php _e( 'Theme 8 (Pro)', 'ktsttestimonial' );?></option>
										<option value="9" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '9' ); ?>><?php _e( 'Theme 9 (Pro)', 'ktsttestimonial' );?></option>
										<option value="10" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '10' ); ?>><?php _e( 'Theme 10 (Pro)', 'ktsttestimonial' );?></option>
										<option value="11" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '11' ); ?>><?php _e( 'Theme 11 (Pro)', 'ktsttestimonial' );?></option>
										<option value="12" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '12' ); ?>><?php _e( 'Theme 12 (Pro)', 'ktsttestimonial' );?></option>
										<option value="13" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '13' ); ?>><?php _e( 'Theme 13 (Pro)', 'ktsttestimonial' );?></option>
										<option value="14" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '14' ); ?>><?php _e( 'Theme 14 (Pro)', 'ktsttestimonial' );?></option>
										<option value="15" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '15' ); ?>><?php _e( 'Theme 15 (Pro)', 'ktsttestimonial' );?></option>
										<option value="16" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '16' ); ?>><?php _e( 'Theme 16 (Pro)', 'ktsttestimonial' );?></option>
										<option value="17" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '17' ); ?>><?php _e( 'Theme 17 (Pro)', 'ktsttestimonial' );?></option>
										<option value="18" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '18' ); ?>><?php _e( 'Theme 18 (Pro)', 'ktsttestimonial' );?></option>
										<option value="19" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '19' ); ?>><?php _e( 'Theme 19 (Pro)', 'ktsttestimonial' );?></option>
										<option value="20" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '20' ); ?>><?php _e( 'Theme 20(List - Free)', 'ktsttestimonial' );?></option>
										<option value="21" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '21' ); ?>><?php _e( 'Theme 21(List - Pro)', 'ktsttestimonial' );?></option>
										<option value="22" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '22' ); ?>><?php _e( 'Theme 22(List - Pro)', 'ktsttestimonial' );?></option>
										<option value="23" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '23' ); ?>><?php _e( 'Theme 23(List - Pro)', 'ktsttestimonial' );?></option>
										<option value="24" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '24' ); ?>><?php _e( 'Theme 24(List - Pro)', 'ktsttestimonial' );?></option>
										<option value="25" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '25' ); ?>><?php _e( 'Theme 25(List - Pro)', 'ktsttestimonial' );?></option>
										<option value="26" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '26' ); ?>><?php _e( 'Theme 26(List - Pro)', 'ktsttestimonial' );?></option>
										<option value="27" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '27' ); ?>><?php _e( 'Theme 27(List - Pro)', 'ktsttestimonial' );?></option>
										<option value="28" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '28' ); ?>><?php _e( 'Theme 28(List - Pro)', 'ktsttestimonial' );?></option>
										<option value="29" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '29' ); ?>><?php _e( 'Theme 29(List - Pro)', 'ktsttestimonial' );?></option>
										<option value="30" <?php if ( isset ( $tp_testimonial_themes ) ) selected( $tp_testimonial_themes, '30' ); ?>><?php _e( 'Theme 30(List - Pro)', 'ktsttestimonial' );?></option>
									</select>
									<span class="tpstestimonial_manager_hint"><?php _e( 'To unlock all Testimonial Themes,', 'ktsttestimonial' ); ?> <a href="https://www.themepoints.com/shop/super-testimonial-pro/" target="_blank"><?php _e( 'Upgrade To Pro!', 'ktsttestimonial' ); ?></a></span>
								</td>
							</tr><!-- End Testimonial Themes -->

							<tr valign="top">
								<th scope="row">
									<label for="tp_testimonial_theme_style"><?php _e( 'Select Layout', 'ktsttestimonial' ); ?></label>
									<span class="tpstestimonial_manager_hint toss"><?php _e( 'Select a layout to display the testimonials.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<select name="tp_testimonial_theme_style" id="tp_testimonial_theme_style" class="timezone_string">
										<option value="1" <?php if ( isset ( $tp_testimonial_theme_style ) ) selected( $tp_testimonial_theme_style, '1' ); ?>><?php _e( 'Slider', 'ktsttestimonial' );?></option>
										<option value="2" <?php if ( isset ( $tp_testimonial_theme_style ) ) selected( $tp_testimonial_theme_style, '2' ); ?>><?php _e( 'Normal Grid ( Pro )', 'ktsttestimonial' );?></option>
										<option value="3" <?php if ( isset ( $tp_testimonial_theme_style ) ) selected( $tp_testimonial_theme_style, '3' ); ?>><?php _e( 'Filter Grid ( Pro )', 'ktsttestimonial' );?></option>
									</select>
									<span class="tpstestimonial_manager_hint"><?php echo __( 'To unlock all Testimonial Layouts,', 'ktsttestimonial' ) . ' '; ?> <a href="https://www.themepoints.com/shop/super-testimonial-pro/" target="_blank"><?php _e( 'Upgrade To Pro!', 'ktsttestimonial' ); ?></a>.</span>
								</td>
							</tr>

							<tr valign="top">
								<th scope="row">
									<label for="dpstotoal_items"><?php _e( 'Limit Items', 'ktsttestimonial' ); ?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __('Limit number of testimonials to show.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="number" name="dpstotoal_items" id="dpstotoal_items" maxlength="4" class="timezone_string" value="<?php  if ( $dpstotoal_items !='' ) { echo $dpstotoal_items; } else { echo '12'; } ?>">
								</td>
							</tr><!-- End Order By -->

							<tr valign="top">
								<th scope="row">
									<label for="tp_order_by_option"><?php _e( 'Order By', 'ktsttestimonial' ); ?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Select an order option.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<select name="tp_order_by_option" id="tp_order_by_option" class="timezone_string">
										<option value="title" <?php if ( isset ( $tp_order_by_option ) ) selected( $tp_order_by_option, 'title' ); ?>><?php _e( 'Title', 'ktsttestimonial' );?></option>
										<option value="modified" <?php if ( isset ( $tp_order_by_option ) ) selected( $tp_order_by_option, 'modified' ); ?>><?php _e( 'Modified', 'ktsttestimonial' );?></option>
										<option value="rand" <?php if ( isset ( $tp_order_by_option ) ) selected( $tp_order_by_option, 'rand' ); ?>><?php _e( 'Rand', 'ktsttestimonial' );?></option>
										<option value="comment_count" <?php if ( isset ( $tp_order_by_option ) ) selected( $tp_order_by_option, 'comment_count' ); ?>><?php _e( 'Popularity', 'ktsttestimonial' ); ?></option>
									</select>									
								</td>
							</tr><!-- End Order By -->

							<tr valign="top">
								<th scope="row">
									<label for="tp_order_option"><?php _e( 'Order Type', 'ktsttestimonial' ); ?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Select an order option.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<select name="tp_order_option" id="tp_order_option" class="timezone_string">
										<option value="DESC" <?php if ( isset ( $tp_order_option ) ) selected( $tp_order_option, 'DESC' ); ?>><?php _e( 'Descending', 'ktsttestimonial' );?></option>
										<option value="ASC" <?php if ( isset ( $tp_order_option ) ) selected( $tp_order_option, 'ASC' ); ?>><?php _e( 'Ascending', 'ktsttestimonial' );?></option>
									</select>
								</td>
							</tr><!-- End Order By -->

							<tr>
								<th>
									<label for="tp_image_sizes"><?php _e( 'Image Sizes', 'ktsttestimonial' ); ?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Choose an image size to display perfectly', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<select name="tp_image_sizes" id="tp_image_sizes" class="tp_image_sizes">
										<option value="thumbnail" <?php if ( isset ( $tp_image_sizes ) ) selected( $tp_image_sizes, 'thumbnail' ); ?>><?php _e( 'Thumbnail', 'ktsttestimonial' );?></option>
										<option value="medium" <?php if ( isset ( $tp_image_sizes ) ) selected( $tp_image_sizes, 'medium' ); ?>><?php _e( 'Medium', 'ktsttestimonial' );?></option>
										<option value="medium_large" <?php if ( isset ( $tp_image_sizes ) ) selected( $tp_image_sizes, 'medium_large' ); ?>><?php _e( 'Medium large', 'ktsttestimonial' );?></option>
										<option value="large" <?php if ( isset ( $tp_image_sizes ) ) selected( $tp_image_sizes, 'large' ); ?>><?php _e( 'Large', 'ktsttestimonial' );?></option>
										<option value="full" <?php if ( isset ( $tp_image_sizes ) ) selected( $tp_image_sizes, 'full' ); ?>><?php _e( 'Full', 'ktsttestimonial' );?></option>
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
						<p class="option-title"><?php _e( 'General Settings','ktsttestimonial' ); ?></p>
						<table class="form-table">
							<tr valign="top">
								<th scope="row">
									<label for="tp_testimonial_textalign"><?php _e( 'Text Align', 'ktsttestimonial' ); ?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Choose an option for the alignment of testimonials content.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="radio-three" name="tp_testimonial_textalign" value="left" <?php if ( $tp_testimonial_textalign == 'left' ) echo 'checked'; ?>/>
										<label for="radio-three"><?php _e( 'Left', 'ktsttestimonial' ); ?><span class="mark"><?php _e( 'Pro', 'ktsttestimonial' ); ?></span></label>
										<input type="radio" id="radio-four" name="tp_testimonial_textalign" value="center" <?php if ( $tp_testimonial_textalign == 'center' || $tp_testimonial_textalign == '' ) echo 'checked'; ?>/>
										<label for="radio-four"><?php _e( 'Center', 'ktsttestimonial' ); ?></label>
										<input type="radio" id="radio-five" name="tp_testimonial_textalign" value="right" <?php if ( $tp_testimonial_textalign == 'right' ) echo 'checked'; ?>/>
										<label for="radio-five"><?php _e( 'Right', 'ktsttestimonial' ); ?><span class="mark"><?php _e( 'Pro', 'ktsttestimonial' ); ?></span></label>
									</div>
								</td>
							</tr><!-- End Text Align -->
							
							<tr valign="top">
								<th scope="row">
									<label for="tp_img_show_hide"><?php _e( 'Image', 'ktsttestimonial' ); ?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Please select whether you would like to display or hide the image of the testimonial.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="tp_img_show" name="tp_img_show_hide" value="1" <?php if ( $tp_img_show_hide == 1 || $tp_img_show_hide == '' ) echo 'checked'; ?>/>
										<label for="tp_img_show"><?php _e( 'Show', 'ktsttestimonial' ); ?></label>
										<input type="radio" id="tp_img_hide" name="tp_img_show_hide" value="2" <?php if ( $tp_img_show_hide == 2 ) echo 'checked'; ?>/>
										<label for="tp_img_hide"><?php _e( 'Hide', 'ktsttestimonial' ); ?><span class="mark"><?php _e( 'Pro', 'ktsttestimonial' ); ?></span></label>
									</div>
								</td>
							</tr><!-- End Image -->

							<tr valign="top" id="imgBorderController" style="<?php if ( $tp_img_show_hide == 2) {	echo "display:none;"; }?>">
								<th scope="row">
									<label for="tp_imgborder_width_option"><?php _e( 'Image Border Width', 'ktsttestimonial' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Set image border Width.', 'ktsttestimonial' ); ?></span>
								</th>
								<td>
									<input type="number" name="tp_imgborder_width_option" min="0" max="10" value="<?php if ( $tp_imgborder_width_option !='' ) {echo $tp_imgborder_width_option; }else{echo 0; } ?>">
								</td>
							</tr> <!-- End of image border width -->

							<tr valign="top" id="imgColor_controller" style="<?php if ( $tp_img_show_hide == 2) {	echo "display:none;"; }?>">
								<th scope="row">
									<label for="tp_imgborder_color_option"><?php _e( 'Image Border Color', 'ktsttestimonial' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Choose a color for the image border.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="text" id="tp_imgborder_color_option" name="tp_imgborder_color_option" value="<?php if ( $tp_imgborder_color_option !='' ) {echo $tp_imgborder_color_option; }else{echo "#f5f5f5"; } ?>" class="timezone_string">
								</td>
							</tr><!-- End Name Color -->
							
							<tr valign="top" id="imgRadius_controller" style="<?php if ( $tp_img_show_hide == 2 ) {	echo "display:none;"; } ?>">
								<th scope="row">
									<label for="tp_testimonial_textalign"><?php _e( 'Image Border Radius', 'ktsttestimonial' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Select an option for border radius of the images.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<select name="tp_img_border_radius" id="tp_img_border_radius" class="timezone_string">
										<option value="0%" <?php if ( isset ( $tp_img_border_radius ) ) selected( $tp_img_border_radius, '0%' ); ?>><?php _e( 'Default', 'ktsttestimonial' );?></option>
										<option value="10%" <?php if ( isset ( $tp_img_border_radius ) ) selected( $tp_img_border_radius, '10%' ); ?>><?php _e( '10%', 'ktsttestimonial' );?></option>
										<option value="15%" <?php if ( isset ( $tp_img_border_radius ) ) selected( $tp_img_border_radius, '15%' ); ?>><?php _e( '15%', 'ktsttestimonial' );?></option>
										<option value="20%" <?php if ( isset ( $tp_img_border_radius ) ) selected( $tp_img_border_radius, '20%' ); ?>><?php _e( '20%', 'ktsttestimonial' );?></option>
										<option value="25%" <?php if ( isset ( $tp_img_border_radius ) ) selected( $tp_img_border_radius, '25%' ); ?>><?php _e( '25%', 'ktsttestimonial' );?></option>
										<option value="30%" <?php if ( isset ( $tp_img_border_radius ) ) selected( $tp_img_border_radius, '30%' ); ?>><?php _e( '30%', 'ktsttestimonial' );?></option>
										<option value="40%" <?php if ( isset ( $tp_img_border_radius ) ) selected( $tp_img_border_radius, '40%' ); ?>><?php _e( '40%', 'ktsttestimonial' );?></option>
										<option value="50%" <?php if ( isset ( $tp_img_border_radius ) ) selected( $tp_img_border_radius, '50%' ); ?>><?php _e( '50%', 'ktsttestimonial' );?></option>
									</select>
								</td>
							</tr><!-- End Border Radius -->

							<tr valign="top">
								<th scope="row">
									<label for="tp_title_color_option"><?php _e( 'Title Font Color', 'ktsttestimonial' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Pick a color for testimonial Title.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="text" id="tp_title_color_option" name="tp_title_color_option" value="<?php if ( $tp_title_color_option !='' ) {echo $tp_title_color_option; }else{echo "#000000"; } ?>" class="timezone_string">
								</td>
							</tr><!-- End Title Color -->
							
							<tr valign="top">
								<th scope="row">
									<label for="tp_title_fontsize_option"><?php _e( 'Title Font Size', 'ktsttestimonial' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __('Choose a font size for testimonial Title.', 'ktsttestimonial'); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="number" name="tp_title_fontsize_option" id="tp_title_fontsize_option" min="10" max="45" class="timezone_string" required value="<?php  if($tp_title_fontsize_option !=''){echo $tp_title_fontsize_option; }else{ echo '20';} ?>"> <br />
								</td>
							</tr><!-- End Title Font Size-->

							<tr valign="top">
								<th scope="row">
									<label for="tp_title_font_case"><?php _e('Title Text Transform', 'ktsttestimonial');?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __('Select Title Text Transform', 'ktsttestimonial'); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<select name="tp_title_font_case" id="tp_title_font_case" class="timezone_string">
										<option value="none" <?php if ( isset ( $tp_title_font_case ) ) selected( $tp_title_font_case, 'none' ); ?>><?php _e('Default', 'ktsttestimonial');?></option>
										<option value="capitalize" <?php if ( isset ( $tp_title_font_case ) ) selected( $tp_title_font_case, 'capitalize' ); ?>><?php _e('Capitalize', 'ktsttestimonial');?></option>
										<option value="lowercase" <?php if ( isset ( $tp_title_font_case ) ) selected( $tp_title_font_case, 'lowercase' ); ?>><?php _e('Lowercase', 'ktsttestimonial');?></option>
										<option value="uppercase" <?php if ( isset ( $tp_title_font_case ) ) selected( $tp_title_font_case, 'uppercase' ); ?>><?php _e('Uppercase', 'ktsttestimonial');?></option>
									</select><br>
								</td>
							</tr><!-- End Title text Transform -->

							<tr valign="top">
								<th scope="row">
									<label for="tp_title_font_style"><?php _e('Title Text Style', 'ktsttestimonial');?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __('Select Title Text style', 'ktsttestimonial'); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<select name="tp_title_font_style" id="tp_title_font_style" class="timezone_string">
										<option value="normal" <?php if ( isset ( $tp_title_font_style ) ) selected( $tp_title_font_style, 'normal' ); ?>><?php _e('Default', 'ktsttestimonial');?></option>
										<option value="italic" <?php if ( isset ( $tp_title_font_style ) ) selected( $tp_title_font_style, 'italic' ); ?>><?php _e('Italic', 'ktsttestimonial');?></option>
									</select><br>
								</td>
							</tr> <!-- End Title text style -->
							
							<tr valign="top">
								<th scope="row">
									<label for="tp_name_color_option"><?php _e( 'Name Font Color', 'ktsttestimonial' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Pick a color for testimonial givers name.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="text" id="tp_name_color_option" name="tp_name_color_option" value="<?php if ( $tp_name_color_option !='' ) {echo $tp_name_color_option; }else{echo "#020202"; } ?>" class="timezone_string">
								</td>
							</tr><!-- End Name Color -->
							
							<tr valign="top">
								<th scope="row">
									<label for="tp_name_fontsize_option"><?php _e( 'Name Font Size', 'ktsttestimonial' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __('Choose a font size for testimonial name.', 'ktsttestimonial'); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="number" name="tp_name_fontsize_option" id="tp_name_fontsize_option" min="10" max="45" class="timezone_string" required value="<?php  if($tp_name_fontsize_option !=''){echo $tp_name_fontsize_option; }else{ echo '18';} ?>"> <br />
								</td>
							</tr><!-- End Name Font Size-->

							<tr valign="top">
								<th scope="row">
									<label for="tp_name_font_case"><?php _e('Name Text Transform', 'ktsttestimonial');?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __('Select Name Text Transform', 'ktsttestimonial'); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<select name="tp_name_font_case" id="tp_name_font_case" class="timezone_string">
										<option value="none" <?php if ( isset ( $tp_name_font_case ) ) selected( $tp_name_font_case, 'none' ); ?>><?php _e('Default', 'ktsttestimonial');?></option>
										<option value="capitalize" <?php if ( isset ( $tp_name_font_case ) ) selected( $tp_name_font_case, 'capitalize' ); ?>><?php _e('Capitalize', 'ktsttestimonial');?></option>
										<option value="lowercase" <?php if ( isset ( $tp_name_font_case ) ) selected( $tp_name_font_case, 'lowercase' ); ?>><?php _e('Lowercase', 'ktsttestimonial');?></option>
										<option value="uppercase" <?php if ( isset ( $tp_name_font_case ) ) selected( $tp_name_font_case, 'uppercase' ); ?>><?php _e('Uppercase', 'ktsttestimonial');?></option>
									</select><br>
								</td>
							</tr><!-- End name text Transform -->

							<tr valign="top">
								<th scope="row">
									<label for="tp_name_font_style"><?php _e('Name Text Style', 'ktsttestimonial');?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __('Select Name Text style', 'ktsttestimonial'); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<select name="tp_name_font_style" id="tp_name_font_style" class="timezone_string">
										<option value="normal" <?php if ( isset ( $tp_name_font_style ) ) selected( $tp_name_font_style, 'normal' ); ?>><?php _e('Default', 'ktsttestimonial');?></option>
										<option value="italic" <?php if ( isset ( $tp_name_font_style ) ) selected( $tp_name_font_style, 'italic' ); ?>><?php _e('Italic', 'ktsttestimonial');?></option>
									</select><br>
								</td>
							</tr> <!-- End name text style -->

							<tr valign="top">
								<th scope="row">
									<label for="tp_designation_show_hide"><?php _e( 'Designation', 'ktsttestimonial' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Choose one option whether you want to show or hide the designation of testimonial giver.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="tp_designation_show" name="tp_designation_show_hide" value="1" <?php if ( $tp_designation_show_hide == 1 || $tp_designation_show_hide == '' ) echo 'checked'; ?>/>
										<label for="tp_designation_show"><?php _e( 'Show', 'ktsttestimonial' ); ?></label>
										<input type="radio" id="tp_designation_hide" name="tp_designation_show_hide" value="2" <?php if ( $tp_designation_show_hide == 2 ) echo 'checked'; ?>/>
										<label for="tp_designation_hide"><?php _e( 'Hide', 'ktsttestimonial' ); ?><span class="mark"><?php _e( 'Pro', 'ktsttestimonial' ); ?></span></label>
									</div>
								</td>
							</tr><!-- End Designation Show/Hide -->
							
							<tr valign="top">
								<th scope="row">
									<label for="tp_desig_fontsize_option"><?php _e( 'Designation Font Size', 'ktsttestimonial' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __('Choose a font size for testimonial designation.', 'ktsttestimonial'); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="number" name="tp_desig_fontsize_option" id="tp_desig_fontsize_option" min="10" max="45" class="timezone_string" required value="<?php  if($tp_desig_fontsize_option !=''){echo $tp_desig_fontsize_option; }else{ echo '15';} ?>"> <br />
								</td>
							</tr><!-- End Designation Font Size-->
							
							<tr valign="top">
								<th scope="row">
									<label for="tp_designation_color_option"><?php _e( 'Designation Font Color', 'ktsttestimonial' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Pick a color for testimonial givers designation.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="text" id="tp_designation_color_option" name="tp_designation_color_option" value="<?php if ( $tp_designation_color_option !='' ) {echo $tp_designation_color_option; }else{echo "#666666"; } ?>" class="timezone_string">
								</td>
							</tr><!-- End Designation Font Color -->

							<tr valign="top">
								<th scope="row">
									<label for="tp_designation_case"><?php _e('Designation Text Transform', 'ktsttestimonial');?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __('Select Designation Text Transform', 'ktsttestimonial'); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<select name="tp_designation_case" id="tp_designation_case" class="timezone_string">
										<option value="none" <?php if ( isset ( $tp_designation_case ) ) selected( $tp_designation_case, 'none' ); ?>><?php _e('Default', 'ktsttestimonial');?></option>
										<option value="capitalize" <?php if ( isset ( $tp_designation_case ) ) selected( $tp_designation_case, 'capitalize' ); ?>><?php _e('Capitalize', 'ktsttestimonial');?></option>
										<option value="lowercase" <?php if ( isset ( $tp_designation_case ) ) selected( $tp_designation_case, 'lowercase' ); ?>><?php _e('Lowercase', 'ktsttestimonial');?></option>
										<option value="uppercase" <?php if ( isset ( $tp_designation_case ) ) selected( $tp_designation_case, 'uppercase' ); ?>><?php _e('Uppercase', 'ktsttestimonial');?></option>
									</select><br>
								</td>
							</tr><!-- End name text Transform -->

							<tr valign="top">
								<th scope="row">
									<label for="tp_designation_font_style"><?php _e('Designation Text Style', 'ktsttestimonial'); ?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __('Select Designation Text style', 'ktsttestimonial'); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<select name="tp_designation_font_style" id="tp_designation_font_style" class="timezone_string">
										<option value="normal" <?php if ( isset ( $tp_designation_font_style ) ) selected( $tp_designation_font_style, 'normal' ); ?>><?php _e('Default', 'ktsttestimonial');?></option>
										<option value="italic" <?php if ( isset ( $tp_designation_font_style ) ) selected( $tp_designation_font_style, 'italic' ); ?>><?php _e('Italic', 'ktsttestimonial');?></option>
									</select><br>
								</td>
							</tr> <!-- End name text style -->

							<tr valign="top">
								<th scope="row">
									<label for="tp_company_show_hide"><?php _e( 'Company URL', 'ktsttestimonial' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Choose one option whether you want to show or hide the company name and URL of testimonial giver.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="tp_company_show" name="tp_company_show_hide" value="1" <?php if ( $tp_company_show_hide == 1 || $tp_company_show_hide == '' ) echo 'checked'; ?>/>
										<label for="tp_company_show"><?php _e( 'Show', 'ktsttestimonial' ); ?></label>
										<input type="radio" id="tp_company_hide" name="tp_company_show_hide" value="2" <?php if ( $tp_company_show_hide == 2 ) echo 'checked'; ?>/>
										<label for="tp_company_hide"><?php _e( 'Hide', 'ktsttestimonial' ); ?><span class="mark"><?php _e( 'Pro', 'ktsttestimonial' ); ?></span></label>
									</div>
								</td>
							</tr><!-- End Company Profiles Show/Hide -->

							<tr valign="top">
								<th scope="row">
									<label for="tp_company_url_color"><?php _e( 'Company URL Color', 'ktsttestimonial' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Pick a color for testimonial givers company name.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="text" id="tp_company_url_color" name="tp_company_url_color" value="<?php if ( $tp_company_url_color !='' ) {echo $tp_company_url_color; }else{echo "#666666"; } ?>" class="timezone_string">
								</td>
							</tr><!-- End Url  Color -->

							<tr valign="top">
								<th scope="row">
									<label for="tp_content_color"><?php _e( 'Content Color', 'ktsttestimonial' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Pick a color for testimonial message.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="text" id="tp_content_color" name="tp_content_color" value="<?php if ( $tp_content_color !='' ) {echo $tp_content_color; } else{ echo "#666666"; } ?>" class="timezone_string">
								</td>
							</tr><!-- End Content Color -->

							<tr valign="top">
								<th scope="row">
									<label for="tp_content_fontsize_option"><?php _e( 'Content Font Size', 'ktsttestimonial' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __('Choose a font size for testimonial message.', 'ktsttestimonial'); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="number" name="tp_content_fontsize_option" id="tp_content_fontsize_option" min="10" max="45" class="timezone_string" required value="<?php  if($tp_content_fontsize_option !=''){echo $tp_content_fontsize_option; }else{ echo '15';} ?>"> <br />
								</td>
							</tr><!-- End Content Font Size-->
							
							<tr valign="top">
								<th scope="row">
									<label for="tp_content_bg_color"><?php _e( 'Content Background Color', 'ktsttestimonial' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Pick a color for content background.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="text" id="tp_content_bg_color" name="tp_content_bg_color" value="<?php if ( $tp_content_bg_color !='' ) {echo $tp_content_bg_color; } else{ echo "#ffffff"; } ?>" class="timezone_string">
								</td>
							</tr><!-- End Content Background Color -->

							<tr valign="top">
								<th scope="row">
									<label for="tp_show_rating_option"><?php _e( 'Rating', 'ktsttestimonial' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Choose one option whether you want to show or hide the rating of testimonial giver.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="tp_show_rating_option" name="tp_show_rating_option" value="1" <?php if ( $tp_show_rating_option == 1 || $tp_show_rating_option == '' ) echo 'checked'; ?>/>
										<label for="tp_show_rating_option"><?php _e( 'Show', 'ktsttestimonial' ); ?></label>
										<input type="radio" id="tp_hide_rating_option" name="tp_show_rating_option" value="2" <?php if ( $tp_show_rating_option == 2 ) echo 'checked'; ?>/>
										<label for="tp_hide_rating_option"><?php _e( 'Hide', 'ktsttestimonial' ); ?><span class="mark"><?php _e( 'Pro', 'ktsttestimonial' ); ?></span></label>
									</div>
								</td>
							</tr><!-- End Rating -->

							<tr valign="top">
								<th scope="row">
									<label for="tp_rating_color"><?php _e( 'Rating Icon Color', 'ktsttestimonial' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Pick a color for testimonial ratings.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="text" id="tp_rating_color" name="tp_rating_color" value="<?php if ( $tp_rating_color !='' ) {echo $tp_rating_color; } else{ echo "#ffa900"; } ?>" class="timezone_string">
								</td>
							</tr><!-- End Rating Color -->

							<tr valign="top">
								<th scope="row">
									<label for="tp_rating_fontsize_option"><?php _e( 'Rating Font Size', 'ktsttestimonial' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __('Choose a font size for testimonial ratings.', 'ktsttestimonial'); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="number" name="tp_rating_fontsize_option" id="tp_rating_fontsize_option" min="10" max="45" class="timezone_string" required value="<?php  if($tp_rating_fontsize_option !=''){echo $tp_rating_fontsize_option; }else{ echo '15';} ?>"> <br />
								</td>
							</tr><!-- End Content Font Size-->

							<tr valign="top">
								<th scope="row">
									<label for="tp_show_item_bg_option"><?php _e( 'Item Background', 'ktsttestimonial' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Choose one option whether you want to show or hide background color for an item.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="tp_show_item_bg_option" name="tp_show_item_bg_option" value="1" <?php if ( $tp_show_item_bg_option == 1 ) echo 'checked'; ?>/>
										<label for="tp_show_item_bg_option"><?php _e( 'Show', 'ktsttestimonial' ); ?></label>
										<input type="radio" id="tp_hide_item_bg_option" name="tp_show_item_bg_option" value="2" <?php if ( $tp_show_item_bg_option == 2 || $tp_show_item_bg_option == '' ) echo 'checked'; ?>/>
										<label for="tp_hide_item_bg_option"><?php _e( 'Hide', 'ktsttestimonial' ); ?></label>
									</div>
								</td>
							</tr><!-- End Item Background Color -->

							<tr valign="top">
								<th scope="row">
									<label for="tp_item_bg_color"><?php _e( 'Background Color', 'ktsttestimonial' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Pick a color for item background.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="text" id="tp_item_bg_color" name="tp_item_bg_color" value="<?php if ( $tp_item_bg_color !='' ) {echo $tp_item_bg_color; } else{ echo "transparent"; } ?>" class="timezone_string">
								</td>
							</tr><!-- End Item Background Color -->

							<tr valign="top">
								<th scope="row">
									<label for="tp_item_padding"><?php _e( 'Item Padding', 'ktsttestimonial' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Select Padding for items.', 'ktsttestimonial' ); ?></span>
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
						<p class="option-title"><?php _e( 'Slider Settings','ktsttestimonial' ); ?></p>
						<table class="form-table">
							<tr valign="top">
								<th scope="row">
									<label for="autoplay"><?php _e( 'Autoplay', 'ktsttestimonial' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Choose an option whether you want the slider autoplay or not.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="autoplay_true" name="autoplay" value="true" <?php if ( $autoplay == 'true' || $autoplay == '' ) echo 'checked'; ?>/>
										<label for="autoplay_true"><?php _e( 'Yes', 'ktsttestimonial' ); ?></label>
										<input type="radio" id="autoplay_false" name="autoplay" value="false" <?php if ( $autoplay == 'false' ) echo 'checked'; ?>/>
										<label for="autoplay_false"><?php _e( 'No', 'ktsttestimonial' ); ?></label>
									</div>
								</td>
							</tr> <!-- End Autoplay -->

							<tr valign="top">
								<th scope="row">
									<label for="autoplay_speed"><?php _e( 'Slide Delay', 'ktsttestimonial' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Select a value for sliding speed.', 'ktsttestimonial' ); ?></span>	
								</th>
								<td style="vertical-align: middle;" class="auto_play">

									<input type="range" step="100" min="100" max="5000" value="<?php  if ( $autoplay_speed !='' ) { echo $autoplay_speed; } else{ echo '700'; } ?>" class="slider" id="myRange"><br>
									<input size="5" type="text" name="autoplay_speed" id="autoplay_speed" maxlength="4" class="timezone_string" readonly  value="<?php  if ( $autoplay_speed !='' ) {echo $autoplay_speed; }else{ echo '700'; } ?>">						
								</td>
							</tr> <!-- End Slide Delay -->

							<tr valign="top">
								<th scope="row">
									<label for="stop_hover"><?php _e( 'Stop Hover', 'ktsttestimonial' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Select an option whether you want to pause sliding on mouse hover.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="stop_hover_true" name="stop_hover" value="true" <?php if ( $stop_hover == 'true' || $stop_hover == '' ) echo 'checked'; ?>/>
										<label for="stop_hover_true"><?php _e( 'Yes', 'ktsttestimonial' ); ?></label>
										<input type="radio" id="stop_hover_false" name="stop_hover" value="false" <?php if ( $stop_hover == 'false' ) echo 'checked'; ?>/>
										<label for="stop_hover_false"><?php _e( 'No', 'ktsttestimonial' ); ?></label>
									</div>				
								</td>
							</tr> <!-- End Stop Hover -->

							<tr valign="top">
								<th scope="row">
									<label for="autoplaytimeout"><?php _e( 'Autoplay Time Out (Sec)', 'ktsttestimonial' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Select an option for autoplay time out.', 'ktsttestimonial' ); ?></span>	
								</th>
								<td style="vertical-align: middle;">
									<select name="autoplaytimeout" id="autoplaytimeout" class="timezone_string">
										<option value="3000" <?php if ( isset ( $autoplaytimeout ) ) selected( $autoplaytimeout, '3000' ); ?>><?php _e( '3', 'ktsttestimonial' );?></option>
										<option value="1000" <?php if ( isset ( $autoplaytimeout ) ) selected( $autoplaytimeout, '1000' ); ?>><?php _e( '1', 'ktsttestimonial' );?></option>
										<option value="2000" <?php if ( isset ( $autoplaytimeout ) ) selected( $autoplaytimeout, '2000' ); ?>><?php _e( '2', 'ktsttestimonial' );?></option>
										<option value="4000" <?php if ( isset ( $autoplaytimeout ) ) selected( $autoplaytimeout, '4000' ); ?>><?php _e( '4', 'ktsttestimonial' );?></option>
										<option value="5000" <?php if ( isset ( $autoplaytimeout ) ) selected( $autoplaytimeout, '5000' ); ?>><?php _e( '5', 'ktsttestimonial' );?></option>
										<option value="6000" <?php if ( isset ( $autoplaytimeout ) ) selected( $autoplaytimeout, '6000' ); ?>><?php _e( '6', 'ktsttestimonial' );?></option>
										<option value="7000" <?php if ( isset ( $autoplaytimeout ) ) selected( $autoplaytimeout, '7000' ); ?>><?php _e( '7', 'ktsttestimonial' );?></option>
										<option value="8000" <?php if ( isset ( $autoplaytimeout ) ) selected( $autoplaytimeout, '8000' ); ?>><?php _e( '8', 'ktsttestimonial' );?></option>
										<option value="9000" <?php if ( isset ( $autoplaytimeout ) ) selected( $autoplaytimeout, '9000' ); ?>><?php _e( '9', 'ktsttestimonial' );?></option>
										<option value="10000" <?php if ( isset ( $autoplaytimeout ) ) selected( $autoplaytimeout, '10000' ); ?>><?php _e( '10', 'ktsttestimonial' );?></option>
									</select>						
								</td>
							</tr> <!-- End Autoplay Time Out -->

							<tr valign="top">
								<th scope="row">
									<label for="item_no"><?php _e( 'Items No', 'ktsttestimonial' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Select number of items you want to show.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<select name="item_no" id="item_no" class="timezone_string">
										<option value="3" <?php if ( isset ( $item_no ) )  selected( $item_no, '3' ); ?>><?php _e( '3', 'ktsttestimonial' );?></option>
										<option value="1" <?php if ( isset ( $item_no ) )  selected( $item_no, '1' ); ?>><?php _e( '1', 'ktsttestimonial' );?></option>
										<option value="2" <?php if ( isset ( $item_no ) )  selected( $item_no, '2' ); ?>><?php _e( '2', 'ktsttestimonial' );?></option>
										<option value="4" <?php if ( isset ( $item_no ) )  selected( $item_no, '4' ); ?>><?php _e( '4', 'ktsttestimonial' );?></option>
										<option value="5" <?php if ( isset ( $item_no ) )  selected( $item_no, '5' ); ?>><?php _e( '5', 'ktsttestimonial' );?></option>
										<option value="6" <?php if ( isset ( $item_no ) )  selected( $item_no, '6' ); ?>><?php _e( '6', 'ktsttestimonial' );?></option>
										<option value="7" <?php if ( isset ( $item_no ) )  selected( $item_no, '7' ); ?>><?php _e( '7', 'ktsttestimonial' );?></option>
										<option value="8" <?php if ( isset ( $item_no ) )  selected( $item_no, '8' ); ?>><?php _e( '8', 'ktsttestimonial' );?></option>
										<option value="9" <?php if ( isset ( $item_no ) )  selected( $item_no, '9' ); ?>><?php _e( '9', 'ktsttestimonial' );?></option>
										<option value="10" <?php if ( isset ( $item_no ) ) selected( $item_no, '10' ); ?>><?php _e( '10', 'ktsttestimonial' );?></option>
									</select>
								</td> 
							</tr> <!-- End Items No -->

							<tr valign="top">
								<th scope="row">
									<label for="itemsdesktop"><?php _e( 'Items Desktop', 'ktsttestimonial' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Number of items you want to show for large desktop monitor.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<select name="itemsdesktop" id="itemsdesktop" class="timezone_string">
										<option value="3" <?php if ( isset ( $itemsdesktop ) ) selected( $itemsdesktop, '3' ); ?>><?php _e( '3', 'ktsttestimonial' );?></option>
										<option value="1" <?php if ( isset ( $itemsdesktop ) ) selected( $itemsdesktop, '1' ); ?>><?php _e( '1', 'ktsttestimonial' );?></option>
										<option value="2" <?php if ( isset ( $itemsdesktop ) ) selected( $itemsdesktop, '2' ); ?>><?php _e( '2', 'ktsttestimonial' );?></option>
										<option value="4" <?php if ( isset ( $itemsdesktop ) ) selected( $itemsdesktop, '4' ); ?>><?php _e( '4', 'ktsttestimonial' );?></option>
										<option value="5" <?php if ( isset ( $itemsdesktop ) ) selected( $itemsdesktop, '5' ); ?>><?php _e( '5', 'ktsttestimonial' );?></option>
										<option value="6" <?php if ( isset ( $itemsdesktop ) ) selected( $itemsdesktop, '6' ); ?>><?php _e( '6', 'ktsttestimonial' );?></option>
										<option value="7" <?php if ( isset ( $itemsdesktop ) ) selected( $itemsdesktop, '7' ); ?>><?php _e( '7', 'ktsttestimonial' );?></option>
										<option value="8" <?php if ( isset ( $itemsdesktop ) ) selected( $itemsdesktop, '8' ); ?>><?php _e( '8', 'ktsttestimonial' );?></option>
										<option value="9" <?php if ( isset ( $itemsdesktop ) ) selected( $itemsdesktop, '9' ); ?>><?php _e( '9', 'ktsttestimonial' );?></option>
										<option value="10" <?php if ( isset ( $itemsdesktop ) ) selected( $itemsdesktop, '10' ); ?>><?php _e( '10', 'ktsttestimonial' );?></option>
									</select>
								</td>
							</tr> <!-- End Items Desktop -->

							<tr valign="top">
								<th scope="row">
									<label for="itemsdesktopsmall"><?php _e( 'Items Desktop Small', 'ktsttestimonial' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Number of items you want to show for small desktop monitor.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<select name="itemsdesktopsmall" id="itemsdesktopsmall" class="timezone_string">
										<option value="1" <?php if ( isset ( $itemsdesktopsmall ) ) selected( $itemsdesktopsmall, '1' ); ?>><?php _e( '1', 'ktsttestimonial' );?></option>
										<option value="2" <?php if ( isset ( $itemsdesktopsmall ) ) selected( $itemsdesktopsmall, '2' ); ?>><?php _e( '2', 'ktsttestimonial' );?></option>
										<option value="3" <?php if ( isset ( $itemsdesktopsmall ) ) selected( $itemsdesktopsmall, '3' ); ?>><?php _e( '3', 'ktsttestimonial' );?></option>
										<option value="4" <?php if ( isset ( $itemsdesktopsmall ) ) selected( $itemsdesktopsmall, '4' ); ?>><?php _e( '4', 'ktsttestimonial' );?></option>
										<option value="5" <?php if ( isset ( $itemsdesktopsmall ) ) selected( $itemsdesktopsmall, '5' ); ?>><?php _e( '5', 'ktsttestimonial' );?></option>
										<option value="6" <?php if ( isset ( $itemsdesktopsmall ) ) selected( $itemsdesktopsmall, '6' ); ?>><?php _e( '6', 'ktsttestimonial' );?></option>
										<option value="7" <?php if ( isset ( $itemsdesktopsmall ) ) selected( $itemsdesktopsmall, '7' ); ?>><?php _e( '7', 'ktsttestimonial' );?></option>
										<option value="8" <?php if ( isset ( $itemsdesktopsmall ) ) selected( $itemsdesktopsmall, '8' ); ?>><?php _e( '8', 'ktsttestimonial' );?></option>
										<option value="9" <?php if ( isset ( $itemsdesktopsmall ) ) selected( $itemsdesktopsmall, '9' ); ?>><?php _e( '9', 'ktsttestimonial' );?></option>
										<option value="10" <?php if ( isset ( $itemsdesktopsmall ) ) selected( $itemsdesktopsmall, '10' ); ?>><?php _e( '10', 'ktsttestimonial' );?></option>
									</select>
								</td>
							</tr>
							<!-- End Items Desktop Small -->

							<tr valign="top">
								<th scope="row">
									<label for="itemsmobile"><?php _e( 'Items Mobile', 'ktsttestimonial' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Number of items you want to show for mobile device.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<select name="itemsmobile" id="itemsmobile" class="timezone_string">
										<option value="1" <?php if ( isset ( $itemsmobile ) ) selected( $itemsmobile, '1' ); ?>><?php _e( '1', 'ktsttestimonial' );?></option>
										<option value="2" <?php if ( isset ( $itemsmobile ) ) selected( $itemsmobile, '2' ); ?>><?php _e( '2', 'ktsttestimonial' );?></option>
										<option value="3" <?php if ( isset ( $itemsmobile ) ) selected( $itemsmobile, '3' ); ?>><?php _e( '3', 'ktsttestimonial' );?></option>
										<option value="4" <?php if ( isset ( $itemsmobile ) ) selected( $itemsmobile, '4' ); ?>><?php _e( '4', 'ktsttestimonial' );?></option>
										<option value="5" <?php if ( isset ( $itemsmobile ) ) selected( $itemsmobile, '5' ); ?>><?php _e( '5', 'ktsttestimonial' );?></option>
										<option value="6" <?php if ( isset ( $itemsmobile ) ) selected( $itemsmobile, '6' ); ?>><?php _e( '6', 'ktsttestimonial' );?></option>
										<option value="7" <?php if ( isset ( $itemsmobile ) ) selected( $itemsmobile, '7' ); ?>><?php _e( '7', 'ktsttestimonial' );?></option>
										<option value="8" <?php if ( isset ( $itemsmobile ) ) selected( $itemsmobile, '8' ); ?>><?php _e( '8', 'ktsttestimonial' );?></option>
										<option value="9" <?php if ( isset ( $itemsmobile ) ) selected( $itemsmobile, '9' ); ?>><?php _e( '9', 'ktsttestimonial' );?></option>
										<option value="10" <?php if ( isset ( $itemsmobile ) ) selected( $itemsmobile, '10' ); ?>><?php _e( '10', 'ktsttestimonial' );?></option>
									</select>
								</td>
							</tr>
							<!-- End Items Mobile -->

							<tr valign="top">
								<th scope="row">
									<label for="loop"><?php _e( 'Loop', 'ktsttestimonial' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Choose an option whether you want to loop the sliders.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="loop_true" name="loop" value="true" <?php if ( $loop == 'true' || $loop == '' ) echo 'checked'; ?>/>
										<label for="loop_true"><?php _e( 'Yes', 'ktsttestimonial' ); ?></label>
										<input type="radio" id="loop_false" name="loop" value="false" <?php if ( $loop == 'false' ) echo 'checked'; ?>/>
										<label for="loop_false"><?php _e( 'No', 'ktsttestimonial' ); ?></label>
									</div>
								</td>
							</tr>
							<!-- End Loop -->

							<tr valign="top">
								<th scope="row">
									<label for="margin"><?php _e( 'Margin', 'ktsttestimonial' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Select margin for a slider item.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input size="5" type="number" name="margin" id="margin_top" maxlength="3" class="timezone_string" value="<?php if ( $margin != '' ) { echo $margin; } else { echo '15'; } ?>">
								</td>
							</tr>
							<!-- End Margin -->

							<tr valign="top">
								<th scope="row">
									<label for="navigation"><?php _e( 'Navigation', 'ktsttestimonial' ); ?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Choose an option whether you want navigation option or not.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="navigation_true" name="navigation" value="true" <?php if ( $navigation == 'true' || $navigation == '' ) echo 'checked'; ?>/>
										<label for="navigation_true"><?php _e( 'Yes', 'ktsttestimonial' ); ?></label>
										<input type="radio" id="navigation_false" name="navigation" value="false" <?php if ( $navigation == 'false' ) echo 'checked'; ?>/>
										<label for="navigation_false"><?php _e( 'No', 'ktsttestimonial' ); ?><span class="mark"><?php _e( 'Pro', 'ktsttestimonial' ); ?></span></label>
									</div>
								</td>
							</tr>
							<!-- End Navigation -->
							
							<tr valign="top" id="navi_align_controller" style="<?php if ( $navigation == 'false') {	echo "display:none;"; }?>">
								<th scope="row">
									<label for="navigation_align"><?php _e( 'Navigation Align', 'ktsttestimonial' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Set the alignment of the navigation tool.' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="navigation_align_left" name="navigation_align" value="left" <?php if ( $navigation_align == 'left' ) echo 'checked'; ?>/>
										<label for="navigation_align_left"><?php _e( 'Top Left', 'ktsttestimonial' ); ?></label>
										<input type="radio" id="navigation_align_center" name="navigation_align" value="center" <?php if ( $navigation_align == 'center' ) echo 'checked'; ?>/>
										<label for="navigation_align_center"><?php _e( 'Center', 'ktsttestimonial' ); ?></label>
										<input type="radio" id="navigation_align_right" name="navigation_align" value="right" <?php if ( $navigation_align == 'right' || $navigation_align == '' ) echo 'checked'; ?>/>
										<label for="navigation_align_right"><?php _e( 'Top Right', 'ktsttestimonial' ); ?></label>
									</div>						
								</td>
							</tr>
							<!-- End Pagination Align -->

							<tr valign="top" id="navi_style_controller" style="<?php if ( $navigation == 'false') {	echo "display:none;"; }?>">
								<th scope="row">
									<label for="navigation_style"><?php _e( 'Navigation Style', 'ktsttestimonial' );?></label>	
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Set the style of navigation tool.' ); ?></span>	
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="navigation_style_left" name="navigation_style" value="0" <?php if ( $navigation_style == '0' ) echo 'checked'; ?>/>
										<label for="navigation_style_left"><?php _e( 'Default', 'ktsttestimonial' ); ?></label>
										<input type="radio" id="navigation_style_center" name="navigation_style" value="50" <?php if ( $navigation_style == '50' || $navigation_style == '' ) echo 'checked'; ?>/>
										<label for="navigation_style_center"><?php _e( 'Round', 'ktsttestimonial' ); ?><span class="mark"><?php _e( 'Pro', 'ktsttestimonial' ); ?></span></label>
									</div>					
								</td>
							</tr>
							<!-- End Navigation Style -->

							<tr valign="top" id="navi_color_controller" style="<?php if ( $navigation == 'false') {	echo "display:none;"; }?>">
								<th scope="row">
									<label for="nav_text_color"><?php _e( 'Navigation Color', 'ktsttestimonial' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Pick a color for navigation tool.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="text" id="nav_text_color" size="5" type="text" name="nav_text_color" value="<?php if ( $nav_text_color != '' ) {echo $nav_text_color; } else{ echo "#020202"; } ?>" class="timezone_string">
								</td>
							</tr>
							<!-- End Navigation Color -->

							<tr valign="top" id="navi_bgcolor_controller" style="<?php if ( $navigation == 'false') {	echo "display:none;"; }?>">
								<th scope="row">
									<label for="nav_bg_color"><?php _e( 'Navigation Background', 'ktsttestimonial' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Pick a color for background of navigation tool.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input id="nav_bg_color" type="text" name="nav_bg_color" value="<?php if ( $nav_bg_color !='' ) {echo $nav_bg_color; } else{ echo "#f5f5f5"; } ?>" class="timezone_string">
								</td>
							</tr>
							<!-- End Navigation Background Color -->

							<tr valign="top" id="navi_color_hover_controller" style="<?php if ( $navigation == 'false') {	echo "display:none;"; }?>">
								<th scope="row">
									<label for="nav_text_color_hover"><?php _e( 'Navigation Color(Hover)', 'ktsttestimonial' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Pick a color for navigation tool on mouse hover.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input id="nav_text_color_hover" type="text" name="nav_text_color_hover" value="<?php if ( $nav_text_color_hover != '' ) {echo $nav_text_color_hover; } else{ echo "#020202"; } ?>" class="timezone_string">
								</td>
							</tr>
							<!-- End Navigation Color Hover -->

							<tr valign="top" id="navi_bgcolor_hover_controller" style="<?php if ( $navigation == 'false') {	echo "display:none;"; }?>">
								<th scope="row">
									<label for="nav_bg_color_hover"><?php _e( 'Navigation Background(Hover)', 'ktsttestimonial' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Pick a color for background of navigation tool on mouse hover.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input id="nav_bg_color_hover" type="text" name="nav_bg_color_hover" value="<?php if ( $nav_bg_color_hover !='' ) {echo $nav_bg_color_hover; } else{ echo "#000000"; } ?>" class="timezone_string">
								</td>
							</tr>
							<!-- End Navigation Background Color -->

							<tr valign="top">
								<th scope="row">
									<label for="pagination"><?php _e( 'Pagination', 'ktsttestimonial' );?></label>	
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Choose an option whether you want pagination option or not.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="pagination_true" name="pagination" value="true" <?php if ( $pagination == 'true' || $pagination == '' ) echo 'checked'; ?>/>
										<label for="pagination_true"><?php _e( 'Yes', 'ktsttestimonial' ); ?></label>
										<input type="radio" id="pagination_false" name="pagination" value="false" <?php if ( $pagination == 'false' ) echo 'checked'; ?>/>
										<label for="pagination_false"><?php _e( 'No', 'ktsttestimonial' ); ?><span class="mark"><?php _e( 'Pro', 'ktsttestimonial' ); ?></span></label>
									</div>						
								</td>
							</tr>
							<!-- End Pagination -->
							
							<tr valign="top" id="pagi_align_controller" style="<?php if ( $pagination == 'false') {	echo "display:none;"; }?>">
								<th scope="row">
									<label for="pagination_align"><?php _e( 'Pagination Align', 'ktsttestimonial' );?></label>	
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Set the alignment of pagination.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="pagination_align_left" name="pagination_align" value="left" <?php if ( $pagination_align == 'left' ) echo 'checked'; ?>/>
										<label for="pagination_align_left"><?php _e( 'Left', 'ktsttestimonial' ); ?><span class="mark"><?php _e( 'Pro', 'ktsttestimonial' ); ?></span></label>
										<input type="radio" id="pagination_align_center" name="pagination_align" value="center" <?php if ( $pagination_align == 'center' || $pagination_align == '' ) echo 'checked'; ?>/>
										<label for="pagination_align_center"><?php _e( 'Center', 'ktsttestimonial' ); ?></label>
										<input type="radio" id="pagination_align_right" name="pagination_align" value="right" <?php if ( $pagination_align == 'right' ) echo 'checked'; ?>/>
										<label for="pagination_align_right"><?php _e( 'Right', 'ktsttestimonial' ); ?><span class="mark"><?php _e( 'Pro', 'ktsttestimonial' ); ?></span></label>
									</div>						
								</td>
							</tr>
							<!-- End Pagination Align -->

							<tr valign="top" id="pagi_style_controller" style="<?php if ( $pagination == 'false') {	echo "display:none;"; }?>">
								<th scope="row">
									<label for="pagination_style"><?php _e( 'Pagination Style', 'ktsttestimonial' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Set the style of pagination tool.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="pagination_style_left" name="pagination_style" value="0" <?php if ( $pagination_style == '0' ) echo 'checked'; ?>/>
										<label for="pagination_style_left"><?php _e( 'Default', 'ktsttestimonial' ); ?></label>
										<input type="radio" id="pagination_style_center" name="pagination_style" value="50" <?php if ( $pagination_style == '50' || $pagination_style == '' ) echo 'checked'; ?>/>
										<label for="pagination_style_center"><?php _e( 'Round', 'ktsttestimonial' ); ?><span class="mark"><?php _e( 'Pro', 'ktsttestimonial' ); ?></span></label>
									</div>						
								</td>
							</tr>
							<!-- End Navigation Style -->

							<tr valign="top" id="pagi_color_controller" style="<?php if ( $pagination == 'false') {	echo "display:none;"; }?>">
								<th scope="row">
									<label for="pagination_bg_color"><?php _e( 'Pagination Background Color', 'ktsttestimonial' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Pick a color for pagination content.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input id="pagination_bg_color" type="text" name="pagination_bg_color" value="<?php if ( $pagination_bg_color !='' ) {echo $pagination_bg_color; } else{ echo "#dddddd"; } ?>" class="timezone_string">
								</td>
							</tr><!-- End Pagination Background Color -->

							<tr valign="top" id="pagi_color_active_controller" style="<?php if ( $pagination == 'false') {	echo "display:none;"; }?>">
								<th scope="row">
									<label for="pagination_bg_color_active"><?php _e( 'Pagination Background(Active)', 'ktsttestimonial' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Pick a color for active pagination content.', 'ktsttestimonial' ); ?></span>
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
						<p class="option-title"><?php _e( 'Grid Normal Settings ( Premium Only )','ktsttestimonial' ); ?></p>
						<table class="form-table">
							<tr valign="top">
								<th scope="row">
									<label for="grid_normal_column"><?php _e( 'Number of columns', 'ktsttestimonial' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Choose an option for posts column.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<select name="grid_normal_column" id="grid_normal_column" class="timezone_string">
										<option value="3" <?php if ( isset ( $grid_normal_column ) ) selected( $grid_normal_column, '3' ); ?>><?php _e( '3', 'ktsttestimonial' );?></option>
										<option value="1" <?php if ( isset ( $grid_normal_column ) ) selected( $grid_normal_column, '1' ); ?>><?php _e( '1', 'ktsttestimonial' );?></option>
										<option value="2" <?php if ( isset ( $grid_normal_column ) ) selected( $grid_normal_column, '2' ); ?>><?php _e( '2', 'ktsttestimonial' );?></option>
										<option value="4" <?php if ( isset ( $grid_normal_column ) ) selected( $grid_normal_column, '4' ); ?>><?php _e( '4', 'ktsttestimonial' );?></option>
										<option value="5" <?php if ( isset ( $grid_normal_column ) ) selected( $grid_normal_column, '5' ); ?>><?php _e( '5', 'ktsttestimonial' );?></option>
										<option value="6" <?php if ( isset ( $grid_normal_column ) ) selected( $grid_normal_column, '6' ); ?>><?php _e( '6', 'ktsttestimonial' );?></option>
									</select>
								</td>
							</tr>

							<tr valign="top">
								<th scope="row">
									<label for="filter_menu_styles"><?php _e( 'Filter Menu Style', 'ktsttestimonial' );?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Choose an option for filter menu style.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<select name="filter_menu_styles" id="filter_menu_styles" class="timezone_string">
										
										<option value="1" <?php if ( isset ( $filter_menu_styles ) ) selected( $filter_menu_styles, '1' ); ?>><?php _e( 'Normal', 'ktsttestimonial' ); ?></option>
										<option value="2" <?php if ( isset ( $filter_menu_styles ) ) selected( $filter_menu_styles, '2' ); ?>><?php _e( 'Checkbox', 'ktsttestimonial' ); ?></option>
										<option value="3" <?php if ( isset ( $filter_menu_styles ) ) selected( $filter_menu_styles, '3' ); ?>><?php _e( 'Drop Down', 'ktsttestimonial' ); ?></option>
									</select>
								</td>
							</tr>

							<tr valign="top">
							    <th scope="row">
							        <label for="testimonial_filter_menu_text"><?php _e( 'Filter Menu Text:', 'ktsttestimonial' ); ?></label>
							        <span class="tpstestimonial_manager_hint toss"><?php echo __('Set the text for the filter menu.', 'ktsttestimonial'); ?></span>
							    </th>
							    <td style="vertical-align: middle;">
							        <input type="text" name="testimonial_filter_menu_text" id="testimonial_filter_menu_text" class="timezone_string" value="<?php echo esc_attr( $testimonial_filter_menu_text ); ?>"> <br />
							    </td>
							</tr><!-- End Filter Menu Text -->

							<tr>
								<th><u><?php echo __( 'Menu Styling', 'ktsttestimonial' ); ?></u></th>
								<td></td>
							</tr>

							<tr valign="top">
								<th scope="row">
									<label for="filter_menu_alignment"><?php _e( 'Menu Align', 'ktsttestimonial' ); ?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Choose an option for the alignment of filter menu.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="filter_menu_alignment1" name="filter_menu_alignment" value="left" <?php if ( $filter_menu_alignment == 'left' ) echo 'checked'; ?>/>
										<label for="filter_menu_alignment1"><?php _e( 'Left', 'ktsttestimonial' ); ?></label>
										<input type="radio" id="filter_menu_alignment2" name="filter_menu_alignment" value="center" <?php if ( $filter_menu_alignment == 'center' || $filter_menu_alignment == '' ) echo 'checked'; ?>/>
										<label for="filter_menu_alignment2"><?php _e( 'Center', 'ktsttestimonial' ); ?></label>
										<input type="radio" id="filter_menu_alignment3" name="filter_menu_alignment" value="right" <?php if ( $filter_menu_alignment == 'right' ) echo 'checked'; ?>/>
										<label for="filter_menu_alignment3"><?php _e( 'Right', 'ktsttestimonial' ); ?></label>
									</div>
								</td>
							</tr><!-- End Menu Align -->

							<tr valign="top">
								<th scope="row">
									<label for="filter_menu_bg_color"><?php _e( 'Background Color', 'ktsttestimonial' ); ?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Pick a color for filter menu background.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="text" id="filter_menu_bg_color" name="filter_menu_bg_color" value="<?php if ( $filter_menu_bg_color != '' ) { echo $filter_menu_bg_color; } else { echo "#f8f8f8"; } ?>" class="timezone_string">
								</td>
							</tr><!-- End Menu bg color -->

							<tr valign="top">
								<th scope="row">
									<label for="filter_menu_font_color"><?php _e( 'Font Color', 'ktsttestimonial' ); ?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Pick a color for text of filter menu.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="text" id="filter_menu_font_color" name="filter_menu_font_color" value="<?php if ( $filter_menu_font_color != '' ) { echo $filter_menu_font_color; } else { echo "#777777"; } ?>" class="timezone_string">
								</td>
							</tr><!-- End Menu text color -->

							<tr valign="top">
								<th scope="row">
									<label for="filter_menu_bg_color_hover"><?php _e( 'Background Color(Hover)', 'ktsttestimonial' ); ?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Pick a color for filter menu background on hover.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="text" id="filter_menu_bg_color_hover" name="filter_menu_bg_color_hover" value="<?php if ( $filter_menu_bg_color_hover != '' ) { echo $filter_menu_bg_color_hover; } else { echo "#003478"; } ?>" class="timezone_string">
								</td>
							</tr><!-- End Menu bg color on hover -->

							<tr valign="top">
								<th scope="row">
									<label for="filter_menu_font_color_hover"><?php _e( 'Font Color(Hover)', 'ktsttestimonial' ); ?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Pick a color for text of filter menu on hover.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="text" id="filter_menu_font_color_hover" name="filter_menu_font_color_hover" value="<?php if ( $filter_menu_font_color_hover != '' ) { echo $filter_menu_font_color_hover; } else { echo "#ffffff"; } ?>" class="timezone_string">
								</td>
							</tr><!-- End Menu text color on hover -->

							<tr valign="top">
								<th scope="row">
									<label for="filter_menu_bg_color_active"><?php _e( 'Background Color(Active)', 'ktsttestimonial' ); ?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Pick a color for filter menu background on hover.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="text" id="filter_menu_bg_color_active" name="filter_menu_bg_color_active" value="<?php if ( $filter_menu_bg_color_active != '' ) { echo $filter_menu_bg_color_active; } else { echo "#003478"; } ?>" class="timezone_string">
								</td>
							</tr><!-- End Menu bg color when active -->

							<tr valign="top">
								<th scope="row">
									<label for="filter_menu_font_color_active"><?php _e( 'Font Color(Active)', 'ktsttestimonial' ); ?></label>
									<span class="tpstestimonial_manager_hint toss"><?php echo __( 'Pick a color for text of filter menu on hover.', 'ktsttestimonial' ); ?></span>
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
			jQuery( '#tp_item_bg_color, #tp_rating_color, #tp_content_bg_color, #tp_content_color, #tp_company_url_color, #tp_designation_color_option, #tp_title_color_option, #tp_name_color_option, #tp_imgborder_color_option, #nav_text_color, #nav_bg_color, #nav_text_color_hover, #nav_bg_color_hover, #pagination_bg_color, #pagination_bg_color_active, #filter_menu_bg_color, #filter_menu_font_color, #filter_menu_font_color_active, #filter_menu_bg_color_active, #filter_menu_font_color_hover, #filter_menu_bg_color_hover' ).wpColorPicker();
		} );
	</script>
	<?php }   //	

# Data save in custom metabox field
function tp_testimonial_meta_box_save_func( $post_id ) {

	// Doing autosave then return.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check if current user has permission to edit the post
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }


    // Sanitize and Save 'testimonial_cat_name' (multiple checkbox values)
    if ( isset( $_POST['testimonial_cat_name'] ) ) {
        $testimonial_cat_name = array_map( 'sanitize_text_field', $_POST['testimonial_cat_name'] );
        update_post_meta( $post_id, 'testimonial_cat_name', $testimonial_cat_name );
    } else {
        delete_post_meta( $post_id, 'testimonial_cat_name' );
    }

	// Sanitize and save 'tp_name_color_option' field (hex color or text)
	if ( isset( $_POST[ 'tp_name_color_option' ] ) ) {
		$tp_name_color_option = sanitize_hex_color( $_POST['tp_name_color_option'] );
		update_post_meta( $post_id, 'tp_name_color_option', $tp_name_color_option );
	}

	// Sanitize and save 'tp_designation_color_option' field
	if ( isset( $_POST[ 'tp_designation_color_option' ] ) ) {
		$tp_designation_color_option = sanitize_hex_color( $_POST['tp_designation_color_option'] );
		update_post_meta( $post_id, 'tp_designation_color_option', $tp_designation_color_option );
	}

	// Sanitize and save 'tp_testimonial_themes' field
	if ( isset( $_POST[ 'tp_testimonial_themes' ] ) ) {
		$tp_testimonial_themes = sanitize_text_field( $_POST['tp_testimonial_themes'] );
		update_post_meta( $post_id, 'tp_testimonial_themes', $tp_testimonial_themes );
	}

	// Sanitize and save 'tp_testimonial_theme_style' field
	if ( isset( $_POST[ 'tp_testimonial_theme_style' ] ) ) {
		$tp_testimonial_theme_style = sanitize_text_field( $_POST['tp_testimonial_theme_style'] );
		update_post_meta( $post_id, 'tp_testimonial_theme_style', $tp_testimonial_theme_style );
	}

	// Sanitize and save 'tp_testimonial_textalign' field
	if ( isset( $_POST[ 'tp_testimonial_textalign' ] ) ) {
		$tp_testimonial_textalign = sanitize_text_field( $_POST['tp_testimonial_textalign'] );
		update_post_meta( $post_id, 'tp_testimonial_textalign', $tp_testimonial_textalign );
	}

	// Sanitize and save 'tp_order_by_option' field
	if ( isset( $_POST[ 'tp_order_by_option' ] ) ) {
		$tp_order_by_option = sanitize_text_field( $_POST['tp_order_by_option'] );
		update_post_meta( $post_id, 'tp_order_by_option', $tp_order_by_option );
	}

	// Sanitize and save 'tp_order_option' field
	if ( isset( $_POST[ 'tp_order_option' ] ) ) {
		$tp_order_option = sanitize_text_field( $_POST['tp_order_option'] );
		update_post_meta( $post_id, 'tp_order_option', $tp_order_option );
	}

	// Sanitize and save 'tp_image_sizes' field
	if ( isset( $_POST[ 'tp_image_sizes' ] ) ) {
		$tp_image_sizes = sanitize_text_field( $_POST['tp_image_sizes'] );
		update_post_meta( $post_id, 'tp_image_sizes', $tp_image_sizes );
	}

	// Sanitize and save 'dpstotoal_items' field (assuming it's an integer)
	if ( isset( $_POST[ 'dpstotoal_items' ] ) ) {
		$dpstotoal_items = intval( $_POST['dpstotoal_items'] );
		update_post_meta( $post_id, 'dpstotoal_items', $dpstotoal_items );
	}

	// Sanitize and save 'tp_img_show_hide' field (assuming it's a boolean or integer flag)
	if ( isset( $_POST[ 'tp_img_show_hide' ] ) ) {
		$tp_img_show_hide = sanitize_text_field( $_POST['tp_img_show_hide'] );
		update_post_meta( $post_id, 'tp_img_show_hide', $tp_img_show_hide );
	}

	// Sanitize and save 'tp_img_border_radius' field (assuming it's a numeric value)
	if ( isset( $_POST[ 'tp_img_border_radius' ] ) ) {
		$tp_img_border_radius = sanitize_text_field( $_POST['tp_img_border_radius'] );
		update_post_meta( $post_id, 'tp_img_border_radius', $tp_img_border_radius );
	}

	// Sanitize and save 'tp_imgborder_width_option' field
	if ( isset( $_POST[ 'tp_imgborder_width_option' ] ) ) {
		$tp_imgborder_width_option = intval( $_POST['tp_imgborder_width_option'] );
		update_post_meta( $post_id, 'tp_imgborder_width_option', $tp_imgborder_width_option );
	}

	// Sanitize and save 'tp_imgborder_color_option' field
	if ( isset( $_POST[ 'tp_imgborder_color_option' ] ) ) {
		$tp_imgborder_color_option = sanitize_hex_color( $_POST['tp_imgborder_color_option'] );
		update_post_meta( $post_id, 'tp_imgborder_color_option', $tp_imgborder_color_option );
	}

	// Sanitize and save 'tp_designation_show_hide' field
	if ( isset( $_POST[ 'tp_designation_show_hide' ] ) ) {
		$tp_designation_show_hide = sanitize_text_field( $_POST['tp_designation_show_hide'] );
		update_post_meta( $post_id, 'tp_designation_show_hide', $tp_designation_show_hide );
	}

	// Sanitize and save 'tp_company_show_hide' field
	if ( isset( $_POST[ 'tp_company_show_hide' ] ) ) {
		$tp_company_show_hide = sanitize_text_field( $_POST['tp_company_show_hide'] );
		update_post_meta( $post_id, 'tp_company_show_hide', $tp_company_show_hide );
	}

	// Sanitize and save 'tp_company_url_color' field
	if ( isset( $_POST[ 'tp_company_url_color' ] ) ) {
		$tp_company_url_color = sanitize_hex_color( $_POST['tp_company_url_color'] );
		update_post_meta( $post_id, 'tp_company_url_color', $tp_company_url_color );
	}

	// Sanitize and save 'tp_title_color_option' field (hex color or text)
	if ( isset( $_POST[ 'tp_title_color_option' ] ) ) {
		$tp_title_color_option = sanitize_hex_color( $_POST['tp_title_color_option'] );
		update_post_meta( $post_id, 'tp_title_color_option', $tp_title_color_option );
	}

	// Sanitize and save 'tp_title_fontsize_option' field
	if ( isset( $_POST['tp_title_fontsize_option'] ) ) {
	    $tp_title_fontsize_option = intval( $_POST['tp_title_fontsize_option'] );
	    update_post_meta( $post_id, 'tp_title_fontsize_option', $tp_title_fontsize_option );
	}

	// Sanitize and save 'tp_title_font_case' field
	if ( isset( $_POST['tp_title_font_case'] ) ) {
	    $tp_title_font_case = sanitize_text_field( $_POST['tp_title_font_case'] );
	    update_post_meta( $post_id, 'tp_title_font_case', $tp_title_font_case );
	}

	// Sanitize and save 'tp_title_font_style' field
	if ( isset( $_POST['tp_title_font_style'] ) ) {
	    $tp_title_font_style = sanitize_text_field( $_POST['tp_title_font_style'] );
	    update_post_meta( $post_id, 'tp_title_font_style', $tp_title_font_style );
	}

	// Sanitize and save 'tp_name_fontsize_option' field
	if ( isset( $_POST['tp_name_fontsize_option'] ) ) {
	    $tp_name_fontsize_option = intval( $_POST['tp_name_fontsize_option'] );
	    update_post_meta( $post_id, 'tp_name_fontsize_option', $tp_name_fontsize_option );
	}

	// Sanitize and save 'tp_name_font_case' field
	if ( isset( $_POST['tp_name_font_case'] ) ) {
	    $tp_name_font_case = sanitize_text_field( $_POST['tp_name_font_case'] );
	    update_post_meta( $post_id, 'tp_name_font_case', $tp_name_font_case );
	}

	// Sanitize and save 'tp_name_font_style' field
	if ( isset( $_POST['tp_name_font_style'] ) ) {
	    $tp_name_font_style = sanitize_text_field( $_POST['tp_name_font_style'] );
	    update_post_meta( $post_id, 'tp_name_font_style', $tp_name_font_style );
	}

	// Sanitize and save 'tp_designation_case' field
	if ( isset( $_POST['tp_designation_case'] ) ) {
	    $tp_designation_case = sanitize_text_field( $_POST['tp_designation_case'] );
	    update_post_meta( $post_id, 'tp_designation_case', $tp_designation_case );
	}

	// Sanitize and save 'tp_designation_font_style' field
	if ( isset( $_POST[ 'tp_designation_font_style' ] ) ) {
	    $tp_designation_font_style = sanitize_text_field( $_POST['tp_designation_font_style'] );
	    update_post_meta( $post_id, 'tp_designation_font_style', $tp_designation_font_style );
	}

	// Sanitize and save 'tp_desig_fontsize_option' field
	if ( isset( $_POST[ 'tp_desig_fontsize_option' ] ) ) {
	    $tp_desig_fontsize_option = intval( $_POST['tp_desig_fontsize_option'] );
	    update_post_meta( $post_id, 'tp_desig_fontsize_option', $tp_desig_fontsize_option );
	}

	// Sanitize and save 'tp_content_fontsize_option' field
	if ( isset( $_POST[ 'tp_content_fontsize_option' ] ) ) {
	    $tp_content_fontsize_option = intval( $_POST['tp_content_fontsize_option'] );
	    update_post_meta( $post_id, 'tp_content_fontsize_option', $tp_content_fontsize_option );
	}

	// Sanitize and save 'tp_content_bg_color' field
	if ( isset( $_POST[ 'tp_content_bg_color' ] ) ) {
	    $tp_content_bg_color = sanitize_hex_color( $_POST['tp_content_bg_color'] );
	    update_post_meta( $post_id, 'tp_content_bg_color', $tp_content_bg_color );
	}

	// Sanitize and save 'tp_rating_fontsize_option' field
	if ( isset( $_POST[ 'tp_rating_fontsize_option' ] ) ) {
	    $tp_rating_fontsize_option = intval( $_POST['tp_rating_fontsize_option'] );
	    update_post_meta( $post_id, 'tp_rating_fontsize_option', $tp_rating_fontsize_option );
	}

	// Sanitize and save 'tp_content_color' field
	if ( isset( $_POST[ 'tp_content_color' ] ) ) {
	    $tp_content_color = sanitize_hex_color( $_POST['tp_content_color'] );
	    update_post_meta( $post_id, 'tp_content_color', $tp_content_color );
	}

	// Sanitize and save 'tp_show_rating_option' field
	if ( isset( $_POST[ 'tp_show_rating_option' ] ) ) {
		$tp_show_rating_option = intval( $_POST[ 'tp_show_rating_option' ] );
		update_post_meta( $post_id, 'tp_show_rating_option', $tp_show_rating_option );
	}

	// Sanitize and save 'tp_show_item_bg_option' field
	if ( isset( $_POST[ 'tp_show_item_bg_option' ] ) ) {
		$tp_show_item_bg_option = sanitize_text_field( $_POST['tp_show_item_bg_option'] );
		update_post_meta( $post_id, 'tp_show_item_bg_option', $tp_show_item_bg_option );
	}

	// Sanitize and save 'tp_rating_color' field
	if ( isset( $_POST['tp_rating_color'] ) ) {
	    $tp_rating_color = sanitize_hex_color( $_POST['tp_rating_color'] );
	    update_post_meta( $post_id, 'tp_rating_color', $tp_rating_color );
	}

	// Sanitize and save 'tp_item_bg_color' field
	if ( isset( $_POST['tp_item_bg_color'] ) ) {
	    $tp_item_bg_color = sanitize_hex_color( $_POST['tp_item_bg_color'] );
	    update_post_meta( $post_id, 'tp_item_bg_color', $tp_item_bg_color );
	}

	// Sanitize and save 'tp_item_padding' field
	if ( isset( $_POST['tp_item_padding'] ) ) {
	    $tp_item_padding = sanitize_text_field( $_POST['tp_item_padding'] );
	    update_post_meta( $post_id, 'tp_item_padding', $tp_item_padding );
	}

    // Carousal Settings

	#Checks for input and sanitizes/saves if needed
	if ( isset( $_POST['item_no'] ) && !empty( $_POST['item_no'] ) ) {
	    $item_no = sanitize_text_field( $_POST['item_no'] );
	    update_post_meta( $post_id, 'item_no', $item_no );
	}

	#Checks for input and sanitizes/saves if needed    
	if ( isset( $_POST['loop'] ) && !empty( $_POST['loop'] ) ) {
	    $loop = sanitize_text_field( $_POST['loop'] );
	    update_post_meta( $post_id, 'loop', $loop );
	}

	#Checks for input and sanitizes/saves if needed    
	if ( isset( $_POST['margin'] ) ) {
	    $margin = sanitize_text_field( $_POST['margin'] ); // Assuming margin is a text field
	    update_post_meta( $post_id, 'margin', $margin );
	}

	#Checks for input and sanitizes/saves if needed    
	if ( isset( $_POST['navigation'] ) && !empty( $_POST['navigation'] ) ) {
	    $navigation = sanitize_text_field( $_POST['navigation'] );
	    update_post_meta( $post_id, 'navigation', $navigation );
	}

	#Checks for input and sanitizes/saves if needed    
	if ( isset( $_POST['navigation_align'] ) && !empty( $_POST['navigation_align'] ) ) {
	    $navigation_align = sanitize_text_field( $_POST['navigation_align'] );
	    update_post_meta( $post_id, 'navigation_align', $navigation_align );
	}

	#Checks for input and sanitizes/saves if needed    
	if ( isset( $_POST['navigation_style'] ) && !empty( $_POST['navigation_style'] ) ) {
	    $navigation_style = sanitize_text_field( $_POST['navigation_style'] );
	    update_post_meta( $post_id, 'navigation_style', $navigation_style );
	}

	#Checks for input and sanitizes/saves if needed    
	if ( isset( $_POST['pagination'] ) && !empty( $_POST['pagination'] ) ) {
	    $pagination = sanitize_text_field( $_POST['pagination'] );
	    update_post_meta( $post_id, 'pagination', $pagination );
	}

	#Checks for input and sanitizes/saves if needed    
	if ( isset( $_POST['pagination_align'] ) && !empty( $_POST['pagination_align'] ) ) {
	    $pagination_align = sanitize_text_field( $_POST['pagination_align'] );
	    update_post_meta( $post_id, 'pagination_align', $pagination_align );
	}

	#Checks for input and sanitizes/saves if needed    
	if ( isset( $_POST['pagination_style'] ) && !empty( $_POST['pagination_style'] ) ) {
	    $pagination_style = sanitize_text_field( $_POST['pagination_style'] );
	    update_post_meta( $post_id, 'pagination_style', $pagination_style );
	}  

	#Checks for input and sanitizes/saves if needed    
	if ( isset( $_POST['grid_normal_column'] ) && !empty( $_POST['grid_normal_column'] ) ) {
	    $grid_normal_column = sanitize_text_field( $_POST['grid_normal_column'] );
	    update_post_meta( $post_id, 'grid_normal_column', $grid_normal_column );
	}

	#Checks for input and sanitizes/saves if needed    
	if ( isset( $_POST['filter_menu_styles'] ) && !empty( $_POST['filter_menu_styles'] ) ) {
	    $filter_menu_styles = sanitize_text_field( $_POST['filter_menu_styles'] );
	    update_post_meta( $post_id, 'filter_menu_styles', $filter_menu_styles );
	}

	#Checks for input and sanitizes/saves if needed    
	if ( isset( $_POST['testimonial_filter_menu_text'] ) && !empty( $_POST['testimonial_filter_menu_text'] ) ) {
	    $testimonial_filter_menu_text = sanitize_text_field( $_POST['testimonial_filter_menu_text'] );
	    update_post_meta( $post_id, 'testimonial_filter_menu_text', $testimonial_filter_menu_text );
	}

	#Checks for input and sanitizes/saves if needed    
	if ( isset( $_POST['filter_menu_alignment'] ) && !empty( $_POST['filter_menu_alignment'] ) ) {
	    $filter_menu_alignment = sanitize_text_field( $_POST['filter_menu_alignment'] );
	    update_post_meta( $post_id, 'filter_menu_alignment', $filter_menu_alignment );
	}

	#Checks for input and sanitizes/saves if needed    
	if ( isset( $_POST['filter_menu_bg_color'] ) && !empty( $_POST['filter_menu_bg_color'] ) ) {
	    $filter_menu_bg_color = sanitize_hex_color( $_POST['filter_menu_bg_color'] );
	    update_post_meta( $post_id, 'filter_menu_bg_color', $filter_menu_bg_color );
	}

	#Checks for input and sanitizes/saves if needed    
	if ( isset( $_POST['filter_menu_bg_color_hover'] ) && !empty( $_POST['filter_menu_bg_color_hover'] ) ) {
	    $filter_menu_bg_color_hover = sanitize_hex_color( $_POST['filter_menu_bg_color_hover'] );
	    update_post_meta( $post_id, 'filter_menu_bg_color_hover', $filter_menu_bg_color_hover );
	} 

	#Checks for input and sanitizes/saves if needed    
	if ( isset( $_POST['filter_menu_bg_color_active'] ) && !empty( $_POST['filter_menu_bg_color_active'] ) ) {
	    $filter_menu_bg_color_active = sanitize_hex_color( $_POST['filter_menu_bg_color_active'] );
	    update_post_meta( $post_id, 'filter_menu_bg_color_active', $filter_menu_bg_color_active );
	} 

	#Checks for input and sanitizes/saves if needed    
	if ( isset( $_POST['filter_menu_font_color'] ) && !empty( $_POST['filter_menu_font_color'] ) ) {
	    $filter_menu_font_color = sanitize_hex_color( $_POST['filter_menu_font_color'] );
	    update_post_meta( $post_id, 'filter_menu_font_color', $filter_menu_font_color );
	} 

	#Checks for input and sanitizes/saves if needed    
	if ( isset( $_POST['filter_menu_font_color_hover'] ) && !empty( $_POST['filter_menu_font_color_hover'] ) ) {
	    $filter_menu_font_color_hover = sanitize_hex_color( $_POST['filter_menu_font_color_hover'] );
	    update_post_meta( $post_id, 'filter_menu_font_color_hover', $filter_menu_font_color_hover );
	} 

	#Checks for input and sanitizes/saves if needed    
	if ( isset( $_POST['filter_menu_font_color_active'] ) && !empty( $_POST['filter_menu_font_color_active'] ) ) {
	    $filter_menu_font_color_active = sanitize_hex_color( $_POST['filter_menu_font_color_active'] );
	    update_post_meta( $post_id, 'filter_menu_font_color_active', $filter_menu_font_color_active );
	} 

	#Checks for input and sanitizes/saves if needed    
	if ( isset( $_POST['pagination_bg_color'] ) && !empty( $_POST['pagination_bg_color'] ) ) {
	    $pagination_bg_color = sanitize_hex_color( $_POST['pagination_bg_color'] );
	    update_post_meta( $post_id, 'pagination_bg_color', $pagination_bg_color );
	} 

	#Checks for input and sanitizes/saves if needed    
	if ( isset( $_POST['pagination_bg_color_active'] ) && !empty( $_POST['pagination_bg_color_active'] ) ) {
	    $pagination_bg_color_active = sanitize_hex_color( $_POST['pagination_bg_color_active'] );
	    update_post_meta( $post_id, 'pagination_bg_color_active', $pagination_bg_color_active );
	}
	    
	#Checks for input and sanitizes/saves if needed    
	if ( isset( $_POST['autoplay'] ) && ( $_POST['autoplay'] != '' ) ) {
	    $autoplay = sanitize_text_field( $_POST['autoplay'] ); // Sanitize autoplay input
	    update_post_meta( $post_id, 'autoplay', $autoplay );
	}

	#Checks for input and sanitizes/saves if needed    
	if ( ! empty( $_POST['autoplay_speed'] ) ) {
	    $autoplay_speed = sanitize_text_field( $_POST['autoplay_speed'] ); // Sanitize autoplay speed input

	    if ( strlen( $autoplay_speed ) > 4 ) {
	        // Handle cases where length is more than 4 if needed
	        // You may want to log this or handle it differently based on requirements
	    } else {
	        if ( $autoplay_speed == '' || is_null( $autoplay_speed ) ) {
	            // Default value if input is empty or null
	            update_post_meta( $post_id, 'autoplay_speed', 700 );
	        } else {
	            if ( is_numeric( $autoplay_speed ) && strlen( $autoplay_speed ) <= 4 ) {
	                // Save sanitized autoplay speed
	                update_post_meta( $post_id, 'autoplay_speed', intval( $autoplay_speed ) ); // Use intval for numeric value
	            }
	        }
	    }
	}

	#Checks for input and sanitizes/saves if needed    
	if ( isset( $_POST['stop_hover'] ) && ( $_POST['stop_hover'] != '' ) ) {
	    $stop_hover = sanitize_text_field( $_POST['stop_hover'] ); // Sanitize stop hover input
	    update_post_meta( $post_id, 'stop_hover', $stop_hover );
	}

	#Checks for input and sanitizes/saves if needed    
	if ( isset( $_POST['itemsdesktop'] ) && ( $_POST['itemsdesktop'] != '' ) ) {
	    $itemsdesktop = sanitize_text_field( $_POST['itemsdesktop'] ); // Sanitize itemsdesktop input
	    update_post_meta( $post_id, 'itemsdesktop', $itemsdesktop );
	}

	#Checks for input and sanitizes/saves if needed    
	if ( isset( $_POST['itemsdesktopsmall'] ) && ( $_POST['itemsdesktopsmall'] != '' ) ) {
	    $itemsdesktopsmall = sanitize_text_field( $_POST['itemsdesktopsmall'] ); // Sanitize itemsdesktopsmall input
	    update_post_meta( $post_id, 'itemsdesktopsmall', $itemsdesktopsmall );
	}

	#Checks for input and sanitizes/saves if needed    
	if ( isset( $_POST['itemsmobile'] ) && ( $_POST['itemsmobile'] != '' ) ) {
	    $itemsmobile = sanitize_text_field( $_POST['itemsmobile'] ); // Sanitize itemsmobile input
	    update_post_meta( $post_id, 'itemsmobile', $itemsmobile );
	}

	#Checks for input and sanitizes/saves if needed    
	if ( isset( $_POST['autoplaytimeout'] ) && ( $_POST['autoplaytimeout'] != '' ) ) {
	    $autoplaytimeout = sanitize_text_field( $_POST['autoplaytimeout'] ); // Sanitize autoplaytimeout input
	    update_post_meta( $post_id, 'autoplaytimeout', $autoplaytimeout );
	}

	#Checks for input and sanitizes/saves if needed    
	if ( isset( $_POST['nav_text_color'] ) && ( $_POST['nav_text_color'] != '' ) ) {
	    $nav_text_color = sanitize_text_field( $_POST['nav_text_color'] ); // Sanitize nav text color input
	    update_post_meta( $post_id, 'nav_text_color', $nav_text_color );
	}

	#Checks for input and sanitizes/saves if needed    
	if ( isset( $_POST['nav_text_color_hover'] ) && ( $_POST['nav_text_color_hover'] != '' ) ) {
	    $nav_text_color_hover = sanitize_text_field( $_POST['nav_text_color_hover'] ); // Sanitize nav text color hover input
	    update_post_meta( $post_id, 'nav_text_color_hover', $nav_text_color_hover );
	}

	#Checks for input and sanitizes/saves if needed    
	if ( isset( $_POST['nav_bg_color'] ) && ( $_POST['nav_bg_color'] != '' ) ) {
	    $nav_bg_color = sanitize_text_field( $_POST['nav_bg_color'] ); // Sanitize nav background color input
	    update_post_meta( $post_id, 'nav_bg_color', $nav_bg_color );
	}

	#Checks for input and sanitizes/saves if needed    
	if ( isset( $_POST['nav_bg_color_hover'] ) && ( $_POST['nav_bg_color_hover'] != '' ) ) {
	    $nav_bg_color_hover = sanitize_text_field( $_POST['nav_bg_color_hover'] ); // Sanitize nav background color hover input
	    update_post_meta( $post_id, 'nav_bg_color_hover', $nav_bg_color_hover );
	}

	#Value check and saves if needed
	if ( isset( $_POST[ 'nav_value' ] ) ) {
	    $nav_value = sanitize_text_field( $_POST['nav_value'] ); // Sanitize nav_value input
	    update_post_meta( $post_id, 'nav_value', $nav_value );
	} else {
	    update_post_meta( $post_id, 'nav_value', 1 ); // Default value
	}

}
add_action( 'save_post', 'tp_testimonial_meta_box_save_func' );
# Custom metabox field end