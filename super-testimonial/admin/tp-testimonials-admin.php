<?php
	if ( ! defined( 'ABSPATH' ) ) {
	    exit;
	}// if direct access 	

	function tps_super_testimonials_init() {
		$labels = array(
			'name' 					=> _x('Testimonials', 'Post type general name', 'ktsttestimonial'),
			'singular_name' 		=> _x('Testimonials', 'Post type singular name', 'ktsttestimonial'),
			'add_new' 				=> _x('Add New', 'Testimonial Item', 'ktsttestimonial'),
			'add_new_item' 			=> __('Add New', 'ktsttestimonial'),
			'edit_item' 			=> __('Edit testimonial', 'ktsttestimonial'),
			'update_item'           => __( 'Update Testimonial', 'ktsttestimonialpro' ),
			'view_item'             => __( 'View Testimonial', 'ktsttestimonialpro' ),
			'new_item' 				=> __('Add New', 'ktsttestimonial'),
			'all_items' 			=> __('All Testimonials', 'ktsttestimonial'),
			'search_items' 			=> __('Search Testimonial', 'ktsttestimonial'),
			'not_found' 			=>  __('No Testimonials found.', 'ktsttestimonial'),
			'not_found_in_trash' 	=> __('No Testimonials found.', 'ktsttestimonial'), 
			'parent_item_colon' 	=> '',
			'menu_name' 			=> _x( 'Super Testimonial', 'admin menu', 'ktsttestimonial' ),
			'name_admin_bar'        => __( 'Super Testimonial', 'ktsttestimonialpro' ),
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
			"description" 		=> __('Testimonial Description', 'ktsttestimonial'),
			"clientratings" 	=> __('Rating', 'ktsttestimonialpro'),
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

		$post_title            = get_post_meta($post->ID, 'name', true);
		$position_input        = get_post_meta($post->ID, 'position', true);
		$company_input         = get_post_meta($post->ID, 'company', true);
		$company_website       = get_post_meta($post->ID, 'company_website', true);
		$company_rating_target = get_post_meta($post->ID, 'company_rating_target', true);
		$testimonial_text      = get_post_meta($post->ID, 'testimonial_text', true);

		?>
		
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


	function supertestimonail_review_notice_message() {
	    // Show only to Admins
	    if ( ! current_user_can( 'manage_options' ) ) {
	        return;
	    }

	    $installed = get_option( 'tps_super_testimonials_activation_time' );
	    if ( !$installed ) {
	        update_option( 'tps_super_testimonials_activation_time', time() );
	        $installed = time(); // Initialize $installed if not set
	    }

	    $dismiss_notice  = get_option( 'supertestimonial_review_notice_dismiss', 'no' );
	    $activation_time = get_option( 'tps_super_testimonials_activation_time' ); // Retrieving activation time
	    $days_installed = floor((time() - $activation_time) / (60 * 60 * 24)); // Calculating days since installation

	    $plugin_url      = 'https://wordpress.org/support/plugin/super-testimonial/reviews/#new-post';

	    // Nonce field
	    $nonce_field = wp_nonce_field( 'supertestimonial_dismiss_review_notice_nonce', '_nonce', true, false );

	    // check if it has already been dismissed
	    if ( 'yes' === $dismiss_notice ) {
	        return;
	    }

	    if ( time() - $activation_time < 604800 ) {
	        return;
	    }

	    ?>

	    <div id="supertestimonial-review-notice" class="supertestimonial-review-notice">
	        <div class="testimonial-review-text">
	            <h3><?php echo wp_kses_post( 'Enjoying Super Testimonial?', 'ktsttestimonial' ); ?></h3>
	            <p><?php echo wp_kses_post( 'Awesome, you\'ve been using <strong>Super Testimonial Plugin</strong> for more than 1 week. May we ask you to give it a <strong>5-star rating</strong> on Wordpress? </br>
	                    This will help to spread its popularity and to make this plugin a better one.
	                    <br><br>Your help is much appreciated. Thank you very much,<br> Themepoints', 'ktsttestimonial' ); ?></p>
	            <ul class="testimonial-review-ul">
	                <li><a href="<?php echo esc_url( $plugin_url ); ?>" target="_blank"><span class="dashicons dashicons-external"></span><?php esc_html_e( 'Sure! I\'d love to!', 'ktsttestimonial' ); ?></a></li>
	                <li><a href="#" class="notice-dismiss" data-nonce="<?php echo esc_attr(wp_create_nonce('supertestimonial_dismiss_review_notice_nonce')); ?>"><span class="dashicons dashicons-smiley"></span><?php esc_html_e( 'I\'ve already left a review', 'ktsttestimonial' ); ?></a></li>
	                <li><a href="#" class="notice-dismiss" data-nonce="<?php echo esc_attr(wp_create_nonce('supertestimonial_dismiss_review_notice_nonce')); ?>"><span class="dashicons dashicons-dismiss"></span><?php esc_html_e( 'Never show again', 'ktsttestimonial' ); ?></a></li>
	            </ul>
	        </div>
	    </div>

        <style type="text/css">
            #supertestimonial-review-notice .notice-dismiss{
                padding: 0 0 0 26px;
            }
            #supertestimonial-review-notice .notice-dismiss:before{
                display: none;
            }
            #supertestimonial-review-notice.supertestimonial-review-notice {
                padding: 15px;
                background-color: #fff;
                border-radius: 3px;
                margin: 30px 20px 0 0;
                border-left: 4px solid transparent;
            }
            #supertestimonial-review-notice .testimonial-review-text {
                overflow: hidden;
            }
            #supertestimonial-review-notice .testimonial-review-text h3 {
                font-size: 24px;
                margin: 0 0 5px;
                font-weight: 400;
                line-height: 1.3;
            }
            #supertestimonial-review-notice .testimonial-review-text p {
                font-size: 15px;
                margin: 0 0 10px;
            }
            #supertestimonial-review-notice .testimonial-review-ul {
                margin: 0;
                padding: 0;
            }
            #supertestimonial-review-notice .testimonial-review-ul li {
                display: inline-block;
                margin-right: 15px;
            }
            #supertestimonial-review-notice .testimonial-review-ul li a {
                display: inline-block;
                color: #2271b1;
                text-decoration: none;
                padding-left: 26px;
                position: relative;
            }
            #supertestimonial-review-notice .testimonial-review-ul li a span {
                position: absolute;
                left: 0;
                top: -2px;
            }
        </style>

	    <script>
	        jQuery(document).ready(function($) {
	            // Dismiss notice
	            $('.notice-dismiss').on('click', function(e) {
	                e.preventDefault();

	                var nonce = $(this).data('nonce');
	                var data = {
	                    action: 'supertestimonial_dismiss_review_notice',
	                    _nonce: nonce,
	                    dismissed: true // Indicate that the notice is being dismissed
	                };

	                $.post(ajaxurl, data, function(response) {
	                    $('#supertestimonial-review-notice').remove();
	                });
	            });
	        });
	    </script>
	    <?php
	}
	add_action( 'admin_notices', 'supertestimonail_review_notice_message' );

	function super_testimonial_dismiss_review_notice() {
	    check_ajax_referer( 'supertestimonial_dismiss_review_notice_nonce', '_nonce' ); // Verifying nonce

	    if ( ! current_user_can( 'manage_options' ) ) {
	        wp_send_json_error( __( 'Unauthorized operation', 'ktsttestimonial' ) );
	    }

	    if ( ! isset( $_POST['_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['_nonce'] ), 'supertestimonial_dismiss_review_notice_nonce' ) ) {
	        wp_send_json_error( __( 'Unauthorized operation', 'ktsttestimonial' ) );
	    }

	    if ( isset( $_POST['dismissed'] ) ) {
	        update_option( 'supertestimonial_review_notice_dismiss', 'yes' );
	        wp_send_json_success( __( 'Notice dismissed successfully', 'ktsttestimonial' ) );
	    } else {
	        wp_send_json_error( __( 'Dismissal data missing', 'ktsttestimonial' ) );
	    }
	}
	add_action( 'wp_ajax_supertestimonial_dismiss_review_notice', 'super_testimonial_dismiss_review_notice' );
