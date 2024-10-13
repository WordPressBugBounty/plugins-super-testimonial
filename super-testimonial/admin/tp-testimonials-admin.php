<?php

	// Prevent direct access to this file
	if (!defined('ABSPATH')) {
	    exit; // Exit if accessed directly
	}

	function tps_super_testimonials_init() {
		$labels = array(
			'name' 					=> _x('Testimonials', 'Post type general name', 'ktsttestimonial'),
			'singular_name' 		=> _x('Testimonials', 'Post type singular name', 'ktsttestimonial'),
			'add_new' 				=> _x('Add New', 'Testimonial Item', 'ktsttestimonial'),
			'add_new_item' 			=> __('Add New', 'ktsttestimonial'),
			'edit_item' 			=> __('Edit testimonial', 'ktsttestimonial'),
			'update_item'           => __( 'Update Testimonial', 'ktsttestimonial' ),
			'view_item'             => __( 'View Testimonial', 'ktsttestimonial' ),
			'new_item' 				=> __('Add New', 'ktsttestimonial'),
			'all_items' 			=> __('All Testimonials', 'ktsttestimonial'),
			'search_items' 			=> __('Search Testimonial', 'ktsttestimonial'),
			'not_found' 			=>  __('No Testimonials found.', 'ktsttestimonial'),
			'not_found_in_trash' 	=> __('No Testimonials found.', 'ktsttestimonial'), 
			'parent_item_colon' 	=> '',
			'menu_name' 			=> _x( 'Super Testimonial', 'admin menu', 'ktsttestimonial' ),
			'name_admin_bar'        => __( 'Super Testimonial', 'ktsttestimonial' ),
		);
		$args = array(
			'labels' 				=> $labels,
			'public' 				=> false,
			'publicly_queryable' 	=> false,
			'show_ui' 				=> true, 
			'show_in_menu' 			=> true, 
			'query_var' 			=> true,
			'rewrite' 				=> true,
			'capability_type' 		=> 'post',
			'has_archive' 			=> true, 
			'hierarchical' 			=> false,
			'menu_position' 		=> null,
			'supports' 				=> array('thumbnail'),
			'menu_icon' 			=> 'dashicons-format-chat',
		);		
		register_post_type('ktsprotype',$args);
		
		// register taxonomy
		register_taxonomy("ktspcategory", array("ktsprotype"), array("hierarchical" => true, "label" => __('Categories', 'ktsttestimonial'), "singular_label" => __('Category', 'ktsttestimonial'), "rewrite" => false, "slug" => 'ktspcategory',"show_in_nav_menus"=>false)); 
	}
	add_action('init', 'tps_super_testimonials_init');

	/*----------------------------------------------------------------------
		Columns Declaration Function
	----------------------------------------------------------------------*/
	function ktps_columns($ktps_columns){
		$order='asc';
		if( isset( $_GET['order'] ) && $_GET['order'] =='asc' ) {
			$order='desc';
		}
		$ktps_columns = array(
			"cb" 				=> "<input type=\"checkbox\" />",
			"thumbnail" 		=> __('Image', 'ktsttestimonial'),
			"title" 			=> __('Name', 'ktsttestimonial'),
			"main_title" 			=> __('Title', 'ktsttestimonial'),
			"description" 		=> __('Testimonial Description', 'ktsttestimonial'),
			"clientratings" 	=> __('Rating', 'ktsttestimonial'),
			"position" 			=> __('Position', 'ktsttestimonial'),
			"ktstcategories" 	=> __('Categories', 'ktsttestimonial'),
			"date" 				=> __('Date', 'ktsttestimonial'),
		);
		return $ktps_columns;
	}

	/*----------------------------------------------------------------------
		testimonial Value Function
	----------------------------------------------------------------------*/
	function ktps_columns_display($ktps_columns, $post_id){
		global $post;
		$width = (int) 80;
		$height = (int) 80;
		if ( 'thumbnail' == $ktps_columns ) {
			if ( has_post_thumbnail($post_id)) {
				$thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true );
				$thumb = wp_get_attachment_image( $thumbnail_id, array($width, $height), true );
				echo $thumb;
			}else{
				echo __('None');
			}
		}
		if ( 'position' == $ktps_columns ) {
			echo esc_attr( get_post_meta($post_id, 'position', true) );
		}
		if ( 'main_title' == $ktps_columns ) {
			echo esc_attr( get_post_meta($post_id, 'main_title', true) );
		}
		if ( 'description' == $ktps_columns ) {
			echo esc_attr( get_post_meta($post_id, 'testimonial_text', true) );
		}
		if ( 'clientratings' == $ktps_columns ) {
			$column_rating = esc_attr( get_post_meta( $post_id, 'company_rating_target', true ) );
			for( $i=0; $i <=4 ; $i++ ) {
			   	if ($i < $column_rating) {
			      	$full = 'fa fa-star';
			    } else {
			      	$full = 'fa fa-star-o';
			    }
			   	echo "<i class=\"$full\"></i>";
			}
		}
		if ( 'ktstcategories' == $ktps_columns ) {
			$terms = get_the_terms( $post_id , 'ktspcategory');
			$count = count( array( $terms ) );
			if ( $terms ) {
				$i = 0;
				foreach ( $terms as $term ) {
					if ( $i+1 != $count ) {
						echo ", ";
					}
					echo '<a href="'.admin_url( 'edit.php?post_type=ktsprotype&ktspcategory='.$term->slug ).'">'.$term->name.'</a>';
					$i++;
				}
			}
		}
	}

	/*----------------------------------------------------------------------
		Add manage_tmls_posts_columns Filter 
	----------------------------------------------------------------------*/
	add_filter("manage_ktsprotype_posts_columns", "ktps_columns");

	/*----------------------------------------------------------------------
		Add manage_tmls_posts_custom_column Action
	----------------------------------------------------------------------*/
	add_action("manage_ktsprotype_posts_custom_column",  "ktps_columns_display", 10, 2 );	

	/*----------------------------------------------------------------------
		Add Meta Box 
	----------------------------------------------------------------------*/
	function tps_super_testimonials_meta_box() {
		add_meta_box(
			'custom_meta_box', // $id
			'Testimonial Reviewer Information <a target="_blank" style="color:red;font-size:15px;font-weight:bold" href="https://www.themepoints.com/shop/super-testimonial-pro/">Upgrade to Pro!</a>', // $title
			'tps_super_testimonials_inner_custom_box', // $callback
			'ktsprotype', // $page
			'normal', // $context
			'high'); // $priority
	}
	add_action('add_meta_boxes', 'tps_super_testimonials_meta_box');

	/*----------------------------------------------------------------------
		Content Of Testimonials Options Meta Box 
	----------------------------------------------------------------------*/

	function tps_super_testimonials_inner_custom_box( $post ) {

		$main_title            = get_post_meta($post->ID, 'main_title', true);
		$post_title            = get_post_meta($post->ID, 'name', true);
		$position_input        = get_post_meta($post->ID, 'position', true);
		$company_input         = get_post_meta($post->ID, 'company', true);
		$company_website       = get_post_meta($post->ID, 'company_website', true);
		$company_rating_target = get_post_meta($post->ID, 'company_rating_target', true);
		$testimonial_text      = get_post_meta($post->ID, 'testimonial_text', true);

		?>

		<!-- Name -->
		<p><label for="main_title"><strong><?php _e('Title:', 'ktsttestimonial');?></strong></label></p>
		
		<input type="text" name="main_title" id="main_title" class="regular-text code" value="<?php echo esc_attr( $main_title ); ?>" />
		
		<hr class="horizontalRuler"/>
		
		<!-- Name -->
		<p><label for="title"><strong><?php _e('Full Name:', 'ktsttestimonial');?></strong></label></p>
		
		<input type="text" name="post_title" id="title" class="regular-text code" value="<?php echo esc_attr( $post_title ); ?>" />
		
		<hr class="horizontalRuler"/>

		<!-- Position -->
		<p><label for="position_input"><strong><?php _e('Position:', 'ktsttestimonial');?></strong></label></p>
		
		<input type="text" name="position_input" id="position_input" class="regular-text code" value="<?php echo esc_attr( $position_input ); ?>" />
		
		<hr class="horizontalRuler"/>
		
		<!-- Company Name -->
		<p><label for="company_input"><strong><?php _e('Company Name:', 'ktsttestimonial');?></strong></label></p>
		
		<input type="text" name="company_input" id="company_input" class="regular-text code" value="<?php echo esc_attr( $company_input ); ?>" />
		
		<hr class="horizontalRuler"/>
		
		<!-- Company Website -->
		<p><label for="company_website_input"><strong><?php _e('Company URL:', 'ktsttestimonial');?></strong></label></p>
		
		<input type="text" name="company_website_input" id="company_website_input" class="regular-text code" value="<?php echo esc_url( $company_website ); ?>" />
							
		<p><span class="description"><?php _e('Example: (www.example.com)', 'ktsttestimonial');?></span></p>
		
		<hr class="horizontalRuler"/>
		
		<!-- Rating -->
		
		<p><label for="company_rating_target_list"><strong><?php _e('Rating:', 'ktsttestimonial');?></strong></label></p>

        <select id="company_rating_target_list" name="company_rating_target_list">
            <option value="5" <?php selected($company_rating_target, '5'); ?>><?php _e('5 Star', 'ktsttestimonial');?></option>
            <option value="4.5" <?php selected($company_rating_target, '4.5'); ?>><?php _e('4.5 Star', 'ktsttestimonial');?></option>
            <option value="4" <?php selected($company_rating_target, '4'); ?>><?php _e('4 Star', 'ktsttestimonial');?></option>
            <option value="3.5" <?php selected($company_rating_target, '3.5'); ?>><?php _e('3.5 Star', 'ktsttestimonial');?></option>
            <option value="3" <?php selected($company_rating_target, '3'); ?>><?php _e('3 Star', 'ktsttestimonial');?></option>
            <option value="2" <?php selected($company_rating_target, '2'); ?>><?php _e('2 Star', 'ktsttestimonial');?></option>
            <option value="1" <?php selected($company_rating_target, '1'); ?>><?php _e('1 Star', 'ktsttestimonial');?></option>
        </select>
		
		<hr class="horizontalRuler"/>
		
		<!-- Testimonial Text -->
							
		<p><label for="testimonial_text_input"><strong><?php _e('Testimonial Text:', 'ktsttestimonial');?></strong></label></p>
		
		<textarea type="text" name="testimonial_text_input" id="testimonial_text_input" class="regular-text code" rows="5" cols="100" ><?php echo esc_textarea( $testimonial_text ); ?></textarea>

		<?php
	}
	
	/*===============================================
		Save testimonial Options Meta Box Function
	=================================================*/
	
	function tps_super_testimonials_save_meta_box($post_id){

	    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
	    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
	        return;
	    }

	    // Check if current user has permission to edit the post
	    if ( ! current_user_can( 'edit_post', $post_id ) ) {
	        return;
	    }

		/*----------------------------------------------------------------------
			Name
		----------------------------------------------------------------------*/
		if(isset($_POST['main_title'])) {
			update_post_meta($post_id, 'main_title', sanitize_text_field($_POST['main_title']));
		}

		/*----------------------------------------------------------------------
			Name
		----------------------------------------------------------------------*/
		if(isset($_POST['post_title'])) {
			update_post_meta($post_id, 'name', sanitize_text_field($_POST['post_title']));
		}
	
		/*----------------------------------------------------------------------
			Position
		----------------------------------------------------------------------*/
		if(isset($_POST['position_input'])) {
			update_post_meta($post_id, 'position', sanitize_text_field($_POST['position_input']));
		}
		
		/*----------------------------------------------------------------------
			Company
		----------------------------------------------------------------------*/
		if(isset($_POST['company_input'])) {
			update_post_meta($post_id, 'company', sanitize_text_field($_POST['company_input']));
		}
		
		/*----------------------------------------------------------------------
			company website
		----------------------------------------------------------------------*/
	    if (isset($_POST['company_website_input'])) {
	        update_post_meta($post_id, 'company_website', esc_url($_POST['company_website_input']));
	    }

		/*----------------------------------------------------------------------
			Rating
		----------------------------------------------------------------------*/
		if(isset($_POST['company_rating_target_list'])) {
			update_post_meta($post_id, 'company_rating_target', sanitize_text_field($_POST['company_rating_target_list']));
		}
		
		/*----------------------------------------------------------------------
			testimonial text
		----------------------------------------------------------------------*/
		if(isset($_POST['testimonial_text_input'])) {
			update_post_meta($post_id, 'testimonial_text', sanitize_text_field($_POST['testimonial_text_input']));
		}
	}
	
	/*----------------------------------------------------------------------
		Save testimonial Options Meta Box Action
	----------------------------------------------------------------------*/
	add_action('save_post', 'tps_super_testimonials_save_meta_box');

	function tps_super_testimonials_updated_messages( $messages ) {
		global $post, $post_id;
		$messages['ktsprotype'] = array( 
			1 => __('Super Testimonial updated.', 'ktsttestimonial'),
			2 => $messages['post'][2], 
			3 => $messages['post'][3], 
			4 => __('Super Testimonial updated.', 'ktsttestimonial'), 
			5 => isset($_GET['revision']) ? sprintf( __('Testimonial restored to revision from %s', 'ktsttestimonial'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6 => __('Super Testimonial published.', 'ktsttestimonial'),
			7 => __('Super Testimonial saved.', 'ktsttestimonial'),
			8 => __('Super Testimonial submitted.', 'ktsttestimonial'),
			9 => sprintf( __('Super Testimonial scheduled for: <strong>%1$s</strong>.', 'ktsttestimonial'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) )),
			10 => __('Super Testimonial draft updated.', 'ktsttestimonial'),
		);
		return $messages;
	}
	add_filter( 'post_updated_messages', 'tps_super_testimonials_updated_messages' );


	// Hook to run when the plugin is activated
	register_activation_hook(__FILE__, 'tps_super_testimonials_review_notification_plugin_activate');

	function tps_super_testimonials_review_notification_plugin_activate() {
	    // Store the current UTC time as the activation time for new installs
	    if (!get_option('tps_super_testimonials_plugin_installed_time')) {
	        update_option('tps_super_testimonials_plugin_installed_time', current_time('timestamp', 1)); // Store in UTC
	    }
	}

	// Check the installed time for both new and existing users
	add_action('admin_init', 'tps_super_testimonials_check_plugin_installed_time');

	function tps_super_testimonials_check_plugin_installed_time() {
	    // For existing users, if the time is not already set, set it to the current UTC time
	    if (!get_option('tps_super_testimonials_plugin_installed_time')) {
	        update_option('tps_super_testimonials_plugin_installed_time', current_time('timestamp', 1)); // Store in UTC
	    }
	}

	// Add an admin notice if the plugin has been installed for more than 7 days
	add_action('admin_notices', 'tps_super_testimonials_ask_for_review');

	function tps_super_testimonials_ask_for_review() {
	    // Get the installation time and user dismiss choice
	    $installed_time = get_option('tps_super_testimonials_plugin_installed_time');
	    $current_time = current_time('timestamp', 1); // Get the current UTC time
	    $remind_later_time = get_option('tps_super_testimonials_plugin_remind_later_time'); // Time when to remind again
	    $user_action = get_option('tps_super_testimonials_plugin_review_action'); // 'dismissed' or 'later'

	    // Time difference for 7 days
	    $time_diff = $current_time - $installed_time;

	    // Show the review notice if:
	    // - Installed time exceeds 7 days
	    // - User hasn't dismissed
	    // - Current time is beyond the "remind me later" time or it hasn't been set
	    if ($installed_time && $time_diff > TPS_REVIEW_REMIND_TIME && $user_action !== 'dismissed' && (!$remind_later_time || $current_time > $remind_later_time)) {
	        ?>
	        <div class="notice notice-success is-dismissible" id="tps-super-testimonials-plugin-review-notice">
	            <p>
	                <?php
	                echo __('Hey! You\'ve been using this plugin for more than 7 days. May we ask you to give it a <strong>5-star rating</strong> on WordPress?', 'ktsttestimonial');
	                ?>
	                <a href="https://wordpress.org/support/plugin/super-testimonial/reviews/#new-post" target="_blank"><?php echo __('Click here to leave a review', 'ktsttestimonial'); ?></a>. <?php echo __('Thank you!', 'ktsttestimonial'); ?>
	            </p>
	            <p>
	                <button class="button-primary" id="tps-super-testimonials-ok-you-deserved-it"><?php echo __('Ok, you deserved it', 'ktsttestimonial'); ?></button>
	                <button class="button-secondary" id="tps-super-testimonials-remind-later"><?php echo __('Remind me later', 'ktsttestimonial'); ?></button>
	                <button class="button-secondary" id="tps-super-testimonials-dismiss-forever"><?php echo __('Dismiss forever', 'ktsttestimonial'); ?></button>
	            </p>
	        </div>
	        <script type="text/javascript">
	        jQuery(document).ready(function($) {
	            $('#tps-super-testimonials-dismiss-forever').on('click', function() {
	                $.post(ajaxurl, { 
	                    action: 'tps_super_testimonials_plugin_review_dismiss', 
	                    option: 'dismissed' 
	                }, function() {
	                    $('#tps-super-testimonials-plugin-review-notice').remove(); // Remove the notice
	                });
	            });
	            
	            $('#tps-super-testimonials-remind-later').on('click', function() {
	                $.post(ajaxurl, { 
	                    action: 'tps_super_testimonials_plugin_review_dismiss', 
	                    option: 'later' 
	                }, function() {
	                    $('#tps-super-testimonials-plugin-review-notice').remove(); // Remove the notice
	                });
	            });

	            $('#tps-super-testimonials-ok-you-deserved-it').on('click', function() {
	                $.post(ajaxurl, { 
	                    action: 'tps_super_testimonials_plugin_review_dismiss', 
	                    option: 'dismissed' 
	                }, function() {
	                    window.open('https://wordpress.org/support/plugin/super-testimonial/reviews/#new-post', '_blank');
	                    $('#tps-super-testimonials-plugin-review-notice').remove(); // Remove the notice
	                });
	            });
	        });
	        </script>
	        <?php
	    }
	}

	// Handle AJAX request for dismissing or reminding later
	add_action('wp_ajax_tps_super_testimonials_plugin_review_dismiss', 'tps_super_testimonials_plugin_review_dismiss');

	function tps_super_testimonials_plugin_review_dismiss() {
	    if (isset($_POST['option'])) {
	        if ($_POST['option'] === 'dismissed') {
	            update_option('tps_super_testimonials_plugin_review_action', 'dismissed');
	        } elseif ($_POST['option'] === 'later') {
	            // Set "remind me later" for 7 more days
	            $remind_time = current_time('timestamp', 1) + TPS_REVIEW_REMIND_TIME; // Set to 7 days from now
	            update_option('tps_super_testimonials_plugin_remind_later_time', $remind_time);
	            update_option('tps_super_testimonials_plugin_review_action', 'later');
	        }
	    }
	    wp_die();
	}