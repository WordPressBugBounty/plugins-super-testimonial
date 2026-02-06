<?php

	// Prevent direct access to this file
	if (!defined('ABSPATH')) {
	    exit;
	}

	function tps_super_testimonials_init() {
		$labels = array(
			'name' 					=> _x('Testimonials', 'Post type general name', 'super-testimonial'),
			'singular_name' 		=> _x('Testimonials', 'Post type singular name', 'super-testimonial'),
			'add_new' 				=> _x('Add New', 'Testimonial Item', 'super-testimonial'),
			'add_new_item' 			=> __('Add New', 'super-testimonial'),
			'edit_item' 			=> __('Edit testimonial', 'super-testimonial'),
			'update_item'           => __('Update Testimonial', 'super-testimonial' ),
			'view_item'             => __('View Testimonial', 'super-testimonial' ),
			'new_item' 				=> __('Add New', 'super-testimonial'),
			'all_items' 			=> __('All Testimonials', 'super-testimonial'),
			'search_items' 			=> __('Search Testimonial', 'super-testimonial'),
			'not_found' 			=> __('No Testimonials found.', 'super-testimonial'),
			'not_found_in_trash' 	=> __('No Testimonials found.', 'super-testimonial'), 
			'parent_item_colon' 	=> '',
			'menu_name' 			=> _x('Super Testimonial', 'admin menu', 'super-testimonial'),
			'name_admin_bar'        => __('Super Testimonial', 'super-testimonial'),
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
			'supports' 				=> array('thumbnail', 'page-attributes'),
			'menu_icon' 			=> 'dashicons-format-chat',
		);
		register_post_type('ktsprotype',$args);
		
		// register taxonomy
		register_taxonomy("ktspcategory", array("ktsprotype"), array("hierarchical" => true, "label" => __('Categories', 'super-testimonial'), "singular_label" => __('Category', 'super-testimonial'), "rewrite" => false, "slug" => 'ktspcategory',"show_in_nav_menus"=>false)); 
	}
	add_action('init', 'tps_super_testimonials_init');

	/*----------------------------------------------------------------------
		Columns Declaration Function
	----------------------------------------------------------------------*/
	function ktps_columns($columns) {
		// Ensure sanitization of order query parameter if needed in the future.
		$order = 'asc';
		if (isset($_GET['order']) && sanitize_text_field($_GET['order']) === 'asc') {
			$order = 'desc';
		}

		// Define custom columns
		$custom_columns = array(
			"cb"              => "<input type=\"checkbox\" />",
			"thumbnail"       => __('Image', 'super-testimonial'),
			"title"           => __('Name', 'super-testimonial'),
			"main_title"      => __('Title', 'super-testimonial'),
			"description"     => __('Testimonial Description', 'super-testimonial'),
			"clientratings"   => __('Rating', 'super-testimonial'),
			"position"        => __('Position', 'super-testimonial'),
			"ktstcategories"  => __('Categories', 'super-testimonial'),
			"date"            => __('Date', 'super-testimonial'),
		);

		/**
		 * Filter the columns for the custom post type.
		 * Allows developers to add/remove columns dynamically.
		 */
		return apply_filters('ktps_columns', $custom_columns);
	}

	/*----------------------------------------------------------------------
		testimonial Value Function
	----------------------------------------------------------------------*/
	function ktps_columns_display($ktps_columns, $post_id) {
	    $width = 80; // Image width
	    $height = 80; // Image height

	    switch ($ktps_columns) {
	        case 'thumbnail':
	            if (has_post_thumbnail($post_id)) {
	                echo get_the_post_thumbnail($post_id, array($width, $height));
	            } else {
	                esc_html_e('None', 'super-testimonial');
	            }
	            break;

	        case 'position':
	            echo esc_html(get_post_meta($post_id, 'position', true));
	            break;

	        case 'main_title':
	            echo esc_html(get_post_meta($post_id, 'main_title', true));
	            break;

	        case 'description':
			    $testimonial_text = get_post_meta( $post_id, 'testimonial_text', true );
			    echo esc_html( wp_trim_words( $testimonial_text, 20, '...' ) );
	            break;

			case 'clientratings':
			    $column_rating = (float) get_post_meta( $post_id, 'company_rating_target', true );
			    for ( $i = 0; $i < 5; $i++ ) {
			        $icon_class = ( $i < $column_rating ) ? 'fa fa-star' : 'fa fa-star-o';
			        echo '<i class="' . esc_attr( $icon_class ) . '"></i>';
			    }
			    break;

			case 'ktstcategories':
			    $terms = get_the_terms( $post_id, 'ktspcategory' );

			    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
			        $term_links = array_map( function ( $term ) {
			            return '<a href="' . esc_url( admin_url( 'edit.php?post_type=ktsprotype&ktspcategory=' . $term->slug ) ) . '">' . esc_html( $term->name ) . '</a>';
			        }, $terms );

			        // Escape the final HTML output safely
			        echo wp_kses( implode( ', ', $term_links ), array(
			            'a' => array(
			                'href' => array(),
			            ),
			        ) );
			    } else {
			        esc_html_e( 'No Categories', 'super-testimonial' );
			    }
			    break;

	        default:
	            // No action for other columns.
	            break;
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
			'Testimonial Reviewer Information <a target="_blank" style="color:red;font-size:15px;font-weight:bold" href="https://themepoints.com/testimonials">Upgrade to Pro!</a>', // $title
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
		$email_address         = get_post_meta($post->ID, 'email_address', true);
		$company_input         = get_post_meta($post->ID, 'company', true);
		$company_website       = get_post_meta($post->ID, 'company_website', true);
		$company_rating_target = get_post_meta($post->ID, 'company_rating_target', true);
		$testimonial_text      = get_post_meta($post->ID, 'testimonial_text', true);

		// Add nonce field for security
		wp_nonce_field( 'tps_super_testimonials_meta_save', 'tps_super_testimonials_meta_nonce' );

		?>

		<!-- Name -->
		<p><label for="main_title"><strong><?php esc_html_e('Title:', 'super-testimonial'); ?></strong></label></p>
		
		<input type="text" name="main_title" id="main_title" class="regular-text code" value="<?php echo esc_attr( $main_title ); ?>" placeholder="Headline for your testimonial" />
		
		<hr class="horizontalRuler"/>
		
		<!-- Name -->
		<p><label for="title"><strong><?php esc_html_e('Full Name:', 'super-testimonial'); ?></strong></label></p>
		
		<input type="text" name="post_title" id="title" class="regular-text code" value="<?php echo esc_attr( $post_title ); ?>" placeholder="What is your full name?" />
		
		<hr class="horizontalRuler"/>

		<!-- Position -->
		<p><label for="position_input"><strong><?php esc_html_e('Position:', 'super-testimonial'); ?></strong></label></p>
		
		<input type="text" name="position_input" id="position_input" class="regular-text code" value="<?php echo esc_attr( $position_input ); ?>" placeholder="What is your designation?" />
		
		<hr class="horizontalRuler"/>

		<!-- E-Mail Address -->
		<p><label for="email_address"><strong><?php esc_html_e('Email Address:', 'super-testimonial'); ?></strong></label></p>
		
		<input type="email" name="email_address" id="email_address" class="regular-text code" value="<?php echo esc_attr( $email_address ); ?>" placeholder="What is your e-mail address?" />
		
		<hr class="horizontalRuler"/>
		
		<!-- Company Name -->
		<p><label for="company_input"><strong><?php esc_html_e('Company Name:', 'super-testimonial'); ?></strong></label></p>
		
		<input type="text" name="company_input" id="company_input" class="regular-text code" value="<?php echo esc_attr( $company_input ); ?>" placeholder="What is your company name?" />
		
		<hr class="horizontalRuler"/>
		
		<!-- Company Website -->
		<p><label for="company_website_input"><strong><?php esc_html_e('Company URL:', 'super-testimonial'); ?></strong></label></p>
		
		<input type="text" name="company_website_input" id="company_website_input" class="regular-text code" value="<?php echo esc_url( $company_website ); ?>" placeholder="What is your company URL?" />
		<p><span class="description"><?php esc_html_e('Example: (www.example.com)', 'super-testimonial'); ?></span></p>
		
		<hr class="horizontalRuler"/>
		
		<!-- Rating -->
		
		<p><label for="company_rating_target_list"><strong><?php esc_html_e('Rating:', 'super-testimonial'); ?></strong></label></p>

		<div class="tp-star-rating">
		    <?php for ($i = 5; $i >= 1; $i--): ?>
		        <input type="radio" id="rating-<?php echo esc_attr($i); ?>" name="company_rating_target_list" value="<?php echo esc_attr($i); ?>" 
		            <?php checked($company_rating_target, $i); ?>>
		        <label for="rating-<?php echo esc_attr($i); ?>" title="<?php echo esc_attr($i . ' Star'); ?>">
		            &#9733;
		        </label>
		    <?php endfor; ?>
		</div>
		
		<hr class="horizontalRuler"/>
		
		<!-- Testimonial Text -->
		<p><label for="testimonial_text_input"><strong><?php esc_html_e('Testimonial Text:', 'super-testimonial'); ?></strong></label></p>
		
		<textarea type="text" name="testimonial_text_input" id="testimonial_text_input" class="regular-text code" rows="5" cols="100" placeholder="What do you think about us?"><?php echo esc_textarea( $testimonial_text ); ?></textarea>

		<?php
	}
	
	/*===============================================
		Save testimonial Options Meta Box Function
	=================================================*/
	
	function tps_super_testimonials_save_meta_box($post_id){

		// Verify nonce
		if ( ! isset( $_POST['tps_super_testimonials_meta_nonce'] ) || 
		     ! wp_verify_nonce( $_POST['tps_super_testimonials_meta_nonce'], 'tps_super_testimonials_meta_save' ) ) {
			return;
		}

		// Doing autosave then return.
	    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
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
			Email Address
		----------------------------------------------------------------------*/
		if(isset($_POST['email_address'])) {
			update_post_meta($post_id, 'email_address', sanitize_text_field($_POST['email_address']));
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
			1 => __('Super Testimonial updated.', 'super-testimonial'),
			2 => $messages['post'][2], 
			3 => $messages['post'][3], 
			4 => __('Super Testimonial updated.', 'super-testimonial'), 
			5 => isset($_GET['revision']) ? sprintf( __('Testimonial restored to revision from %s', 'super-testimonial'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6 => __('Super Testimonial published.', 'super-testimonial'),
			7 => __('Super Testimonial saved.', 'super-testimonial'),
			8 => __('Super Testimonial submitted.', 'super-testimonial'),
			9 => sprintf( __('Super Testimonial scheduled for: <strong>%1$s</strong>.', 'super-testimonial'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) )),
			10 => __('Super Testimonial draft updated.', 'super-testimonial'),
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
				        printf(
				            esc_html__(
				                'Hey! You\'ve been using this plugin for more than 7 days. May we ask you to give it a %s on WordPress?', 
				                'super-testimonial'
				            ),
				            '<strong>' . esc_html__('5-star rating', 'super-testimonial') . '</strong>'
				        );
			        ?>
	                <a href="https://wordpress.org/support/plugin/super-testimonial/reviews/#new-post" target="_blank"><?php echo esc_html__('Click here to leave a review', 'super-testimonial'); ?></a>. <?php echo esc_html__('Thank you!', 'super-testimonial'); ?>
	            </p>
	            <p>
	                <button class="button-primary" id="tps-super-testimonials-ok-you-deserved-it"><?php echo esc_html__('Ok, you deserved it', 'super-testimonial'); ?></button>
	                <button class="button-secondary" id="tps-super-testimonials-remind-later"><?php echo esc_html__('Remind me later', 'super-testimonial'); ?></button>
	                <button class="button-secondary" id="tps-super-testimonials-dismiss-forever"><?php echo esc_html__('Dismiss forever', 'super-testimonial'); ?></button>
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