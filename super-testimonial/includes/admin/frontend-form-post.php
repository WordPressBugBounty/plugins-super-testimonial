<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Function to register the custom post type 'tp_testimonial_form'
function tps_super_testimonials_form_generator_type() {
    // Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'Testimonials', 'Post Type General Name', 'ktsttestimonial' ),
        'singular_name'       => _x( 'Testimonial', 'Post Type Singular Name', 'ktsttestimonial' ),
        'menu_name'           => __( 'Testimonials', 'ktsttestimonial' ),
        'parent_item_colon'   => __( 'Parent Form', 'ktsttestimonial' ),
        'all_items'           => __( 'Testimonial Form', 'ktsttestimonial' ),
        'view_item'           => __( 'View Form', 'ktsttestimonial' ),
        'edit_item'           => __( 'Edit Form', 'ktsttestimonial' ),
        'update_item'         => __( 'Update Form', 'ktsttestimonial' ),
        'search_items'        => __( 'Search Form', 'ktsttestimonial' ),
        'not_found'           => __( 'Form Not Found', 'ktsttestimonial' ),
        'not_found_in_trash'  => __( 'Form Not Found in Trash', 'ktsttestimonial' ),
    );

    // Check if a form already exists
    $existing_forms = get_posts(array(
        'post_type'      => 'tp_testimonial_form',
        'post_status'    => 'publish',
        'numberposts'    => 1,
    ));

    // Hide "Add New" if a form exists
    if (empty($existing_forms)) {
        $labels['add_new_item'] = __( 'Testimonial Form', 'ktsttestimonial' );
        $labels['add_new'] = __( 'Add New', 'ktsttestimonial' );
    }

    $args = array(
        'label'               => __( 'Testimonial Form', 'ktsttestimonial' ),
        'description'         => __( 'Form news and reviews', 'ktsttestimonial' ),
        'labels'              => $labels,
        'supports'            => array( 'title' ), // Only title is needed
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => 'edit.php?post_type=ktsprotype',
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => false,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    );

    register_post_type( 'tp_testimonial_form', $args );
}
add_action( 'init', 'tps_super_testimonials_form_generator_type' );

// Function to remove "Add New" button if a form already exists
function tps_super_testimonials_remove_add_new() {
    $existing_forms = get_posts(array(
        'post_type'      => 'tp_testimonial_form',
        'post_status'    => 'publish',
        'numberposts'    => 1,
    ));

    if (!empty($existing_forms)) {
        // Remove "Add New" from admin menu
        add_filter('admin_head', function() {
            echo '<style>
                .post-type-tp_testimonial_form .page-title-action { display: none !important; }
                .post-type-tp_testimonial_form #submenu-posts-tp_testimonial_form a[href*="post-new.php"] { display: none !important; }
            </style>';
        });

        // Remove "Add New" from row actions
        add_filter('post_row_actions', function($actions, $post) {
            if ($post->post_type === 'tp_testimonial_form') {
                unset($actions['inline hide-if-no-js']);
                //unset($actions['edit']);
            }
            return $actions;
        }, 10, 2);
    }
}
add_action( 'admin_menu', 'tps_super_testimonials_remove_add_new', 999 );

// Function to redirect users if they try to manually access "Add New" page
function tps_super_testimonials_redirect_add_new() {
    global $pagenow, $typenow;

    if ($pagenow === 'post-new.php' && $typenow === 'tp_testimonial_form') {
        $existing_forms = get_posts(array(
            'post_type'      => 'tp_testimonial_form',
            'post_status'    => 'publish',
            'numberposts'    => 1,
        ));

        if (!empty($existing_forms)) {
            wp_redirect(admin_url('edit.php?post_type=tp_testimonial_form'));
            exit;
        }
    }
}
add_action( 'admin_init', 'tps_super_testimonials_redirect_add_new' );

// Customize columns for tp_testimonial_form
function tps_super_testimonials_shortcode_form( $columns ) {
    return array(
        'cb'            => '<input type="checkbox" />',
        'title'         => __( 'Form Title', 'ktsttestimonial' ),
        'formshortcode' => __( 'Shortcode', 'ktsttestimonial' ),
        'date'          => __( 'Date', 'ktsttestimonial' ),
    );
}
add_filter( 'manage_tp_testimonial_form_posts_columns', 'tps_super_testimonials_shortcode_form' );

// Display content for the custom columns in the post list
function tps_super_testimonials_shortcode_form_display( $tpcp_column, $post_id ) {
	if ( $tpcp_column == 'formshortcode' ) { ?>
		<input style="background:#ddd" type="text" onClick="this.select();" value="[frontend_form <?php echo 'id=&quot;'.$post_id.'&quot;';?>]" />
	 <?php
	}
}	
add_action( 'manage_tp_testimonial_form_posts_custom_column' , 'tps_super_testimonials_shortcode_form_display', 10, 2 );

// frontend_form all codes
function tps_register_testimonial_form_metabox() {
    add_meta_box(
        'tps_testimonial_form_settings',
        __('Testimonial Form Settings', 'ktsttestimonial'),
        'tps_render_testimonial_form_metabox',
        'tp_testimonial_form',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'tps_register_testimonial_form_metabox');

// Define configurable fields for the form
function tp_testimonial_form_settings() {
    return array(
        'main_title' => array(
            'type' => 'text',
            'label' => 'Testimonial Title',
            'required' => false,
            'enabled' => true,
            'placeholder' => 'Headline for your testimonial',
        ),
        'post_title' => array(
            'type' => 'text',
            'label' => 'Full Name',
            'required' => true,
            'enabled' => true,
            'placeholder' => 'What is your full name?',
        ),
        'position_input' => array(
            'type' => 'text',
            'label' => 'Designation',
            'required' => false,
            'enabled' => true,
            'placeholder' => 'What is your designation?',
        ),
        'email_address' => array(
            'type' => 'email',
            'label' => 'E-mail Address',
            'required' => true,
            'enabled' => true,
            'placeholder' => 'What is your e-mail address?',
        ),
        'company_input' => array(
            'type' => 'text',
            'label' => 'Company Name',
            'required' => false,
            'enabled' => true,
            'placeholder' => 'What is your company name?',
        ),
        'company_website_input' => array(
            'type' => 'text',
            'label' => 'Company URL',
            'required' => false,
            'enabled' => true,
            'placeholder' => 'What is your company URL?',
        ),
        'testimonial_text_input' => array(
            'type' => 'textarea',
            'label' => 'Testimonial Content',
            'required' => true,
            'enabled' => true,
            'placeholder' => 'What do you think about us?',
            'maxlength' => 500,
        ),
        'photo' => array(
            'type' => 'file',
            'label' => 'Photo',
            'required' => false,
            'enabled' => true,
            'accept' => 'image/jpeg,image/png,image/jpg',
        ),
        'company_rating_target_list' => array(
            'type' => 'rating',
            'label' => 'Rating',
            'required' => true,
            'enabled' => true,
        ),
        // CAPTCHA field
        'recaptcha' => array(
            'type' => 'recaptcha',
            'label' => 'Verify you are human',
            'required' => false,
            'enabled' => false,
        ),
    );
}

function tps_render_testimonial_form_metabox($post) {
	// Get saved settings
	$tp_form_submitbtn          = get_post_meta($post->ID, 'tp_form_submitbtn', true );
	$tp_form_width              = get_post_meta($post->ID, 'tp_form_width', true ) ?: '650';
	$tp_form_bgcolor            = get_post_meta($post->ID, 'tp_form_bgcolor', true) ?: '#ffffff';
	$tp_required_show_hide      = get_post_meta($post->ID, 'tp_required_show_hide', true );
	$tp_required_notice_text    = get_post_meta($post->ID, 'tp_required_notice_text', true );
	$tp_success_message         = get_post_meta($post->ID, 'tp_success_message', true );
	$tp_error_message           = get_post_meta($post->ID, 'tp_error_message', true );
	$tp_border_width            = get_post_meta($post->ID, 'tp_border_width', true);
	$tp_border_style            = get_post_meta($post->ID, 'tp_border_style', true) ?: 'solid';
	$tp_border_color            = get_post_meta($post->ID, 'tp_border_color', true) ?: '#111111';
	$tp_border_radius           = get_post_meta($post->ID, 'tp_border_radius', true);
	$tp_form_label_color        = get_post_meta($post->ID, 'tp_form_label_color', true) ?: '#111111';
	$tp_form_placeholder_color  = get_post_meta($post->ID, 'tp_form_placeholder_color', true) ?: '#999';
	$tp_label_width             = get_post_meta($post->ID, 'tp_label_width', true) ?: '1';
	$tp_label_style             = get_post_meta($post->ID, 'tp_label_style', true) ?: 'solid';
	$tp_lable_border_color      = get_post_meta($post->ID, 'tp_lable_border_color', true) ?: '#111111';
	$tp_lable_bg_color          = get_post_meta($post->ID, 'tp_lable_bg_color', true) ?: '#ffffff';
	$tp_label_border_radius     = get_post_meta($post->ID, 'tp_label_border_radius', true);
	$tp_form_rating_color       = get_post_meta($post->ID, 'tp_form_rating_color', true) ?: '#cccccc';
    $tp_form_rating_hover_color = get_post_meta($post->ID, 'tp_form_rating_hover_color', true) ?: '#f5c518';
    $tp_rating_style            = get_post_meta($post->ID, 'tp_rating_style', true);
    if (!$tp_rating_style) {
        $tp_rating_style = 'star'; // Default style
    }
	$tp_form_btn_color          = get_post_meta($post->ID, 'tp_form_btn_color', true) ?: '#ffffff';
	$tp_form_btn_hover_color    = get_post_meta($post->ID, 'tp_form_btn_hover_color', true) ?: '#ffffff';
	$tp_form_btn_bg_color       = get_post_meta($post->ID, 'tp_form_btn_bg_color', true) ?: '#0073aa';
	$tp_form_btn_bg_hover_color = get_post_meta($post->ID, 'tp_form_btn_bg_hover_color', true) ?: '#005a87';
	$tp_form_asterisk_color 	= get_post_meta($post->ID, 'tp_form_asterisk_color', true) ?: '#dd3333';
	$tp_form_success_color 		= get_post_meta($post->ID, 'tp_form_success_color', true) ?: '#28a745';
	$tp_form_error_color 		= get_post_meta($post->ID, 'tp_form_error_color', true) ?: '#dd3333';
	$tp_fptop_width             = get_post_meta($post->ID, 'tp_fptop_width', true ) ?: '30';
	$tp_fpright_width           = get_post_meta($post->ID, 'tp_fpright_width', true ) ?: '30';
	$tp_fpbottom_width          = get_post_meta($post->ID, 'tp_fpbottom_width', true ) ?: '30';
	$tp_fpleft_width            = get_post_meta($post->ID, 'tp_fpleft_width', true ) ?: '30';
	$enable_recaptcha           = get_post_meta($post->ID, 'enable_recaptcha', true);
	
	// Get saved meta values
	$post_status                = get_post_meta($post->ID, 'custom_post_status', true) ?: 'pending';
	$recaptcha_type             = get_post_meta($post->ID, 'custom_recaptcha_type', true) ?: 'none';
	$recaptcha_version          = get_post_meta($post->ID, 'custom_recaptcha_version', true) ?: 'v2';
	$site_key                   = get_post_meta($post->ID, 'custom_recaptcha_site_key', true) ?: '';
	$secret_key                 = get_post_meta($post->ID, 'custom_recaptcha_secret_key', true) ?: '';
	$nav_value                  = get_post_meta($post->ID, 'nav_value', true );

    $fields = tp_testimonial_form_settings();
    $settings = get_post_meta($post->ID, 'tp_testimonial_form_settings', true);

    $notification_enabled = get_post_meta($post->ID, '_notification_enabled', true);

    // Retrieve the existing value of notification_to
    $notification_to = get_post_meta($post->ID, 'notification_to', true);

    // Get the site author's email (fallback to admin email)
    $site_admin_email = get_option('admin_email');

    // Default to the site author's email if the metabox field is empty
    if (empty($notification_to)) {
        $notification_to = $site_admin_email;
    }


    $notification_from = get_post_meta($post->ID, 'notification_from', true);
    // Default subject if not set
    if (empty($notification_from)) {
        // Use placeholders with dynamic admin email
        $notification_from = '{site_title} ' . $site_admin_email;
    }


    $notification_subject = get_post_meta($post->ID, 'notification_subject', true);
    // Default subject if not set
    if (empty($notification_subject)) {
        $notification_subject = 'A New Testimonial is Pending for {site_title}!';
    }

    $notification_body = get_post_meta($post->ID, 'notification_body', true);

    // Generate the admin dashboard link
    $admin_dashboard_link = admin_url('edit.php?post_type=ktsprotype&page=post.php&post=' . $post->ID . '&action=edit');

    if (empty($notification_body)) {
        // Default notification body text with a link
        $notification_body = "New Testimonial!\n\nHi There,\n\nA new testimonial has been submitted to your website. Following is the reviewer's information:\n\nName: {name}\nEmail: {email}\nTestimonial Content: {testimonial_text}\nRating: {rating}\n\nPlease go to the Admin dashboard to review it and publish It:\n\nThank you!";
    }

    ?>

	<div class="tupsetings post-grid-metabox">
		<!-- <div class="wrap"> -->
		<ul class="tab-nav">
			<li nav="1" class="nav1 <?php if ( $nav_value == 1 ) { echo "active"; } ?>"><?php esc_html_e( 'FORM EDITOR','ktsttestimonial' ); ?></li>
			<li nav="2" class="nav2 <?php if ( $nav_value == 2 ) { echo "active"; } ?>"><?php esc_html_e( 'FORM STYLE','ktsttestimonial' ); ?></li>
			<li nav="3" class="nav3 <?php if ( $nav_value == 3 ) { echo "active"; } ?>"><?php esc_html_e( 'FORM SETTINGS','ktsttestimonial' ); ?></li>
			<li nav="4" class="nav4 <?php if ( $nav_value == 4 ) { echo "active"; } ?>"><?php esc_html_e( 'LABELS & MESSAGES','ktsttestimonial' ); ?></li>
			<li nav="5" class="nav5 <?php if ( $nav_value == 5 ) { echo "active"; } ?>"><?php esc_html_e( 'NOTIFICATIONS','ktsttestimonial' ); ?></li>
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
					<p class="option-title"><?php esc_html_e( 'Form Editor','ktsttestimonial' ); ?><a href="https://themepoints.com/testimonials" target="_blank"> - <?php _e( 'Unlock all upgrades with Pro!', 'ktsttestimonial' ); ?></a></p>
 
					<ul id="testimonial-form-fields">
		                <?php
						    foreach ($fields as $key => $field) {
						        $label = isset($settings[$key]['label']) ? $settings[$key]['label'] : (isset($field['label']) ? $field['label'] : '');
						        $placeholder = isset($settings[$key]['placeholder']) ? $settings[$key]['placeholder'] : (isset($field['placeholder']) ? $field['placeholder'] : '');
						        $required = isset($settings[$key]['required']) ? $settings[$key]['required'] : (isset($field['required']) ? $field['required'] : false);
						        $enabled = isset($settings[$key]['enabled']) ? $settings[$key]['enabled'] : (isset($field['enabled']) ? $field['enabled'] : false);
						        $type = isset($field['type']) ? $field['type'] : ''; // Get field type
						        ?>
						        <li class="testimonial-field">
						            <div class="field-header"><span class="dashicons dashicons-fullscreen-alt"></span><?php echo esc_html($label); ?></div>
					            	<div class="field-lables">
					                	<?php esc_html_e('Label', 'ktsttestimonial'); ?>: <input type="text" name="tp_testimonial_settings[<?php echo esc_attr($key); ?>][label]" value="<?php echo esc_attr($label); ?>">
					            	</div>

							        <?php
							        // Show placeholder input only if the field type is NOT file, rating, or recaptcha
							        if (!in_array($type, ['file', 'rating', 'recaptcha'])) {
							        ?>
							            <div class="field-header-fields">
							                <?php esc_html_e('Placeholder', 'ktsttestimonial'); ?>: <input type="text" name="tp_testimonial_settings[<?php echo esc_attr($key); ?>][placeholder]" value="<?php echo esc_attr($placeholder); ?>">
							            </div>
							        <?php } ?>

						            <div class="field-header-required">
						            	<input type="checkbox" name="tp_testimonial_settings[<?php echo esc_attr($key); ?>][required]" value="1" <?php checked($required, true); ?>> <?php esc_html_e('Required', 'ktsttestimonial'); ?>
						            </div>

						            <div class="field-header-enable">
						            	<input type="checkbox" name="tp_testimonial_settings[<?php echo esc_attr($key); ?>][enabled]" value="1" <?php checked($enabled, true); ?>> <?php esc_html_e('Enable', 'ktsttestimonial'); ?>
						            </div>

						        </li>
						        <?php
						    }
						?>
				    </ul>
				    <table class="form-table">
						<tr valign="top">
							<th scope="row">
								<label for="tp_form_submitbtn"><?php esc_html_e( 'Submit Testimonial', 'ktsttestimonial' ); ?></label>
								<span class="tpstestimonial_manager_hint toss"><?php esc_html_e('Set Testimonial Button Text.', 'ktsttestimonial'); ?></span>
							</th>
							<td style="vertical-align: middle;">
								<input type="text" name="tp_form_submitbtn" id="tp_form_submitbtn" value="<?php echo esc_attr(!empty($tp_form_submitbtn) ? $tp_form_submitbtn : 'Submit Testimonial'); ?>">
							</td>
						</tr><!-- End tp_form_submitbtn -->
					</table>
				</div>
			</li>

			<!-- Tab 2 -->
			<li style="<?php if($nav_value == 2){echo "display: block;";} else{ echo "display: none;"; }?>" class="box2 tab-box <?php if($nav_value == 2){echo "active";}?>">
				<div class="wrap">
					<div class="option-box">
						<p class="option-title"><?php esc_html_e( 'Form Style','ktsttestimonial' ); ?> <a href="https://themepoints.com/testimonials" target="_blank"> - <?php _e( 'Unlock all upgrades with Pro!', 'ktsttestimonial' ); ?></a></p>
						<table class="form-table">

							<tr valign="top">
								<th scope="row">
									<label for="tp_form_width"><?php esc_html_e( 'Form Width', 'ktsttestimonial' ); ?></label>
									<span class="tpstestimonial_manager_hint toss"><?php esc_html_e('Set a custom width for the testimonial form.', 'ktsttestimonial'); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="number" name="tp_form_width" id="tp_form_width" class="timezone_string" required value="<?php  if($tp_form_width !=''){echo $tp_form_width; }else{ echo '650';} ?>"><?php esc_html_e( 'Px', 'ktsttestimonial' ); ?><br />
								</td>
							</tr><!-- End tp_form_width -->

							<tr valign="top">
								<th scope="row">
									<label for="tp_fptop_width"><?php esc_html_e( 'Form Padding', 'ktsttestimonial' ); ?></label>
									<span class="tpstestimonial_manager_hint toss"><?php esc_html_e( 'Set padding for the testimonial form.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
								    <div style="display: flex; gap: 20px; align-items: center;">
								        <div style="display: grid;">
								            <label for="tp_fptop_width"><?php esc_html_e('Top (px)', 'ktsttestimonial'); ?></label>
								            <input type="number" id="tp_fptop_width" name="tp_fptop_width" value="<?php echo esc_attr($tp_fptop_width); ?>" style="width: 60px;">
								        </div>
								        <div style="display: grid;">
								            <label for="tp_fpright_width"><?php esc_html_e('Right (px)', 'ktsttestimonial'); ?></label>
								            <input type="number" id="tp_fpright_width" name="tp_fpright_width" value="<?php echo esc_attr($tp_fpright_width); ?>" style="width: 60px;">
								        </div>
								        <div style="display: grid;">
								            <label for="tp_fpbottom_width"><?php esc_html_e('Bottom (px)', 'ktsttestimonial'); ?></label>
								            <input type="number" id="tp_fpbottom_width" name="tp_fpbottom_width" value="<?php echo esc_attr($tp_fpbottom_width); ?>" style="width: 60px;">
								        </div>
								        <div style="display: grid;">
								            <label for="tp_fpleft_width"><?php esc_html_e('Left (px)', 'ktsttestimonial'); ?></label>
								            <input type="number" id="tp_fpleft_width" name="tp_fpleft_width" value="<?php echo esc_attr($tp_fpleft_width); ?>" style="width: 60px;">
								        </div>
								    </div>
								</td>
							</tr>
							<!-- End Form Border -->

							<tr valign="top">
								<th scope="row">
									<label for="tp_form_bgcolor"><?php esc_html_e( 'Form Background', 'ktsttestimonial' ); ?></label>
									<span class="tpstestimonial_manager_hint toss"><?php esc_html_e( 'Pick a color for the testimonial form.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="text" id="tp_form_bgcolor" name="tp_form_bgcolor" value="<?php echo esc_attr($tp_form_bgcolor); ?>">
								</td>
							</tr>
							<!-- End Form Background Color -->

							<tr valign="top">
								<th scope="row">
									<label for="tp_border_width"><?php esc_html_e( 'Form Border', 'ktsttestimonial' ); ?></label>
									<span class="tpstestimonial_manager_hint toss"><?php esc_html_e( 'Set border for the testimonial form.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
								    <div style="display: flex; gap: 20px; align-items: center;">
								        <div style="display: grid;">
								            <label for="tp_border_width"><?php esc_html_e('Width (px)', 'ktsttestimonial'); ?></label>
								            <input type="number" name="tp_border_width" id="tp_border_width" style="width: 60px;" value="<?php  if ( $tp_border_width !='' ) { echo $tp_border_width; } else { echo '1'; } ?>">
								        </div>
								        <div style="display: grid;">
								            <label for="tp_border_style"><?php esc_html_e('Style', 'ktsttestimonial'); ?></label>
								            <select id="tp_border_style" name="tp_border_style">
								                <option value="solid" <?php selected($tp_border_style, 'solid'); ?>><?php esc_html_e( 'Solid', 'ktsttestimonial' ); ?></option>
								                <option value="dashed" <?php selected($tp_border_style, 'dashed'); ?>><?php esc_html_e( 'Dashed', 'ktsttestimonial' ); ?></option>
								                <option value="dotted" <?php selected($tp_border_style, 'dotted'); ?>><?php esc_html_e( 'Dotted', 'ktsttestimonial' ); ?></option>
								            </select>
								        </div>
								        <div style="display: grid;">
								            <label for="tp_border_color"><?php esc_html_e('Color', 'ktsttestimonial'); ?></label>
								            <input type="color" id="tp_border_color" name="tp_border_color" value="<?php echo esc_attr($tp_border_color); ?>">
								        </div>
								        <div style="display: grid;">
								            <label for="tp_border_radius"><?php esc_html_e('Radius (px)', 'ktsttestimonial'); ?></label>
								            <input type="number" name="tp_border_radius" id="tp_border_radius" style="width: 60px;" value="<?php  if ( $tp_border_radius !='' ) { echo $tp_border_radius; } else { echo '6'; } ?>">
								        </div>
								    </div>
								</td>
							</tr>
							<!-- End Form Border -->

							<tr valign="top">
								<th scope="row">
									<label for="tp_form_label_color"><?php esc_html_e( 'Input Label Color', 'ktsttestimonial' ); ?></label>
									<span class="tpstestimonial_manager_hint toss"><?php esc_html_e( 'Pick a color for the testimonial form label.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="text" id="tp_form_label_color" name="tp_form_label_color" value="<?php echo esc_attr($tp_form_label_color); ?>">
								</td>
							</tr>
							<!-- End Form Label Color -->

							<tr valign="top">
								<th scope="row">
									<label for="tp_label_width"><?php esc_html_e( 'Input Field ', 'ktsttestimonial' ); ?></label>
									<span class="tpstestimonial_manager_hint toss"><?php esc_html_e( 'Set input field style for the testimonial form.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
								    <div style="display: flex; gap: 20px; align-items: center;">
								        <div style="display: grid;">
								            <label for="tp_label_width"><?php esc_html_e('Width (px)', 'ktsttestimonial'); ?></label>
								            <input type="number" id="tp_label_width" name="tp_label_width" value="<?php echo esc_attr($tp_label_width); ?>" style="width: 60px;"> 
								        </div>
								        <div style="display: grid;">
								            <label for="tp_label_style"><?php esc_html_e('Style', 'ktsttestimonial'); ?></label>
								            <select id="tp_label_style" name="tp_label_style">
								                <option value="solid" <?php selected($tp_label_style, 'solid'); ?>><?php esc_html_e( 'Solid', 'ktsttestimonial' ); ?></option>
								                <option value="dashed" <?php selected($tp_label_style, 'dashed'); ?>><?php esc_html_e( 'Dashed', 'ktsttestimonial' ); ?></option>
								                <option value="dotted" <?php selected($tp_label_style, 'dotted'); ?>><?php esc_html_e( 'Dotted', 'ktsttestimonial' ); ?></option>
								            </select>
								        </div>
								        <div style="display: grid;">
								            <label for="tp_lable_border_color"><?php esc_html_e('Color', 'ktsttestimonial'); ?></label>
								            <input type="color" id="tp_lable_border_color" name="tp_lable_border_color" value="<?php echo esc_attr($tp_lable_border_color); ?>">
								        </div>
								        <div style="display: grid;">
								            <label for="tp_lable_bg_color"><?php esc_html_e('BG Color', 'ktsttestimonial'); ?></label>
								            <input type="color" id="tp_lable_bg_color" name="tp_lable_bg_color" value="<?php echo esc_attr($tp_lable_bg_color); ?>">
								        </div>
								        <div style="display: grid;">
								            <label for="tp_label_border_radius"><?php esc_html_e('Radius (px)', 'ktsttestimonial'); ?></label>
								            <input type="number" name="tp_label_border_radius" id="tp_label_border_radius" style="width: 60px;" value="<?php  if ( $tp_label_border_radius !='' ) { echo $tp_label_border_radius; } else { echo '6'; } ?>">
								        </div>
								    </div>
								</td>
							</tr>
							<!-- End Form Input Field -->

							<tr valign="top">
								<th scope="row">
									<label for="tp_form_placeholder_color"><?php esc_html_e( 'Input Placeholder Color', 'ktsttestimonial' ); ?></label>
									<span class="tpstestimonial_manager_hint toss"><?php esc_html_e( 'Set color for the testimonial Input Placeholder.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="text" id="tp_form_placeholder_color" name="tp_form_placeholder_color" value="<?php echo esc_attr($tp_form_placeholder_color); ?>">
								</td>
							</tr>
							<!-- End Form Placeholder Color -->

							<tr valign="top">
								<th scope="row">
									<label for="tp_form_rating_color"><?php esc_html_e( 'Rating Color', 'ktsttestimonial' ); ?></label>
									<span class="tpstestimonial_manager_hint toss"><?php esc_html_e( 'Pick a color for the testimonial form rating.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="text" id="tp_form_rating_color" name="tp_form_rating_color" value="<?php echo esc_attr($tp_form_rating_color); ?>">
								</td>
							</tr>
							<!-- End Form Rating Color -->

                            <tr valign="top">
                                <th scope="row">
                                    <label for="tp_form_rating_hover_color"><?php _e( 'Rating Hover Color', 'ktsttestimonial' ); ?></label>
                                    <span class="tpstestimonial_manager_hint toss"><?php esc_html_e( 'Set color for the testimonial form rating hover.', 'ktsttestimonial' ); ?></span>
                                </th>
                                <td style="vertical-align: middle;">
                                    <input type="text" id="tp_form_rating_hover_color" name="tp_form_rating_hover_color" value="<?php echo esc_attr($tp_form_rating_hover_color); ?>">
                                </td>
                            </tr>
                            <!-- End Form Rating Hover Color -->

                            <tr valign="top">
                                <th scope="row">
                                    <label for="tp_rating_style"><?php _e( 'Rating Style', 'ktsttestimonial' ); ?></label>
                                    <span class="tpstestimonial_manager_hint toss"><?php esc_html_e( 'Set testimonial form rating style.', 'ktsttestimonial' ); ?></span>
                                </th>
                                <td style="vertical-align: middle;">
                                    <div class="tp-rating-options">
                                        <label class="tp-rating-option">
                                            <input type="radio" name="tp_rating_style" value="star" <?php checked($tp_rating_style, 'star'); ?>>
                                            <i class="fa fa-star"></i>
                                        </label>
                                        <label class="tp-rating-option">
                                            <input type="radio" name="tp_rating_style" value="star-o" <?php checked($tp_rating_style, 'star-o'); ?>>
                                            <i class="fa fa-star-o"></i>
                                        </label>
                                        <label class="tp-rating-option">
                                            <input type="radio" name="tp_rating_style" value="heart" <?php checked($tp_rating_style, 'heart'); ?>>
                                            <i class="fa fa-heart"></i>
                                        </label>
                                        <label class="tp-rating-option">
                                            <input type="radio" name="tp_rating_style" value="heart-o" <?php checked($tp_rating_style, 'heart-o'); ?>>
                                            <i class="fa fa-heart-o"></i>
                                        </label>
                                        <label class="tp-rating-option">
                                            <input type="radio" name="tp_rating_style" value="thumbs-up" <?php checked($tp_rating_style, 'thumbs-up'); ?>>
                                            <i class="fa fa-thumbs-up"></i>
                                        </label>
                                        <label class="tp-rating-option">
                                            <input type="radio" name="tp_rating_style" value="thumbs-o-up" <?php checked($tp_rating_style, 'thumbs-o-up'); ?>>
                                            <i class="fa fa-thumbs-o-up"></i>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <!-- End Form Rating Hover Color -->

							<tr valign="top">
								<th scope="row">
									<label for="tp_form_btn_color"><?php esc_html_e( 'Submit Button Color', 'ktsttestimonial' ); ?></label>
									<span class="tpstestimonial_manager_hint toss"><?php esc_html_e( 'Set color for the testimonial submit button.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="text" id="tp_form_btn_color" name="tp_form_btn_color" value="<?php echo esc_attr($tp_form_btn_color); ?>">
								</td>
							</tr>
							<!-- End Form Submit Button Text Color -->

							<tr valign="top">
								<th scope="row">
									<label for="tp_form_btn_hover_color"><?php esc_html_e( 'Submit Button Hover Color', 'ktsttestimonial' ); ?></label>
									<span class="tpstestimonial_manager_hint toss"><?php esc_html_e( 'Set color for the testimonial submit button hover color.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="text" id="tp_form_btn_hover_color" name="tp_form_btn_hover_color" value="<?php echo esc_attr($tp_form_btn_hover_color); ?>">
								</td>
							</tr>
							<!-- End Form Submit Button Hover Text Color -->

							<tr valign="top">
								<th scope="row">
									<label for="tp_form_btn_bg_color"><?php esc_html_e( 'Submit Button BG Color', 'ktsttestimonial' ); ?></label>
									<span class="tpstestimonial_manager_hint toss"><?php esc_html_e( 'Set color for the testimonial submit button background color.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="text" id="tp_form_btn_bg_color" name="tp_form_btn_bg_color" value="<?php echo esc_attr($tp_form_btn_bg_color); ?>">
								</td>
							</tr>
							<!-- End Form Submit Button Bg Color -->

							<tr valign="top">
								<th scope="row">
									<label for="tp_form_btn_bg_hover_color"><?php esc_html_e( 'Submit Button Hover Bg Color', 'ktsttestimonial' ); ?></label>
									<span class="tpstestimonial_manager_hint toss"><?php esc_html_e( 'Set color for the testimonial submit button hover bg color.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="text" id="tp_form_btn_bg_hover_color" name="tp_form_btn_bg_hover_color" value="<?php echo esc_attr($tp_form_btn_bg_hover_color); ?>">
								</td>
							</tr>
							<!-- End Form Submit Button Hover Bg Color -->

						</table>
					</div>
				</div>
			</li>

			<!-- Tab 3 -->
			<li style="<?php if($nav_value == 3){echo "display: block;";} else{ echo "display: none;"; }?>" class="box3 tab-box <?php if($nav_value == 3){echo "active";}?>">
				<div class="wrap">
					<div class="option-box">
						<p class="option-title"><?php esc_html_e( 'General Settings','ktsttestimonial' ); ?> <a href="https://themepoints.com/testimonials" target="_blank"> - <?php _e( 'Unlock all upgrades with Pro!', 'ktsttestimonial' ); ?></a></p>
						<table class="form-table">

					        <tr>
					            <th>
					                <label for="custom_post_status"><?php esc_html_e('Post Status', 'ktsttestimonial'); ?></label>
					            </th>
					            <td>
					                <select name="custom_post_status" id="custom_post_status">
					                    <option value="pending" <?php selected($post_status, 'pending'); ?>><?php esc_html_e('Pending', 'ktsttestimonial'); ?></option>
					                    <option value="publish" <?php selected($post_status, 'publish'); ?>><?php esc_html_e('Publish', 'ktsttestimonial'); ?></option>
					                    <option value="draft" <?php selected($post_status, 'draft'); ?>><?php esc_html_e('Draft', 'ktsttestimonial'); ?></option>
					                </select>
					            </td>
					        </tr>

					        <tr>
					            <th>
					                <label for="custom_header_status"><?php esc_html_e('reCAPTCHA', 'ktsttestimonial'); ?></label>
					            </th>
					            <td>
					               <p><?php esc_html_e('reCAPTCHA is a free aniti-spam service provided by Google designed to protect websites from spam and abuse.', 'ktsttestimonial'); ?></p>
					            </td>
					        </tr>

					        <tr>
					            <th>
					                <label for="enable_recaptcha"><?php esc_html_e('Enable reCAPTCHA', 'ktsttestimonial'); ?></label>
					            </th>
					            <td>
							        <label for="enable_recaptcha">
							            <input type="checkbox" name="enable_recaptcha" id="enable_recaptcha" value="1" <?php checked($enable_recaptcha, '1'); ?>>
							            <?php esc_html_e('Enable reCAPTCHA', 'ktsttestimonial'); ?>
							        </label>
					            </td>
					        </tr>

					        <tr>
					            <th>
					                <label for="custom_recaptcha_type"><?php esc_html_e('reCAPTCHA Type', 'ktsttestimonial'); ?></label>
					            </th>
					            <td>
					                <select name="custom_recaptcha_type" id="custom_recaptcha_type">
					                    <option value="none" <?php selected($recaptcha_type, 'none'); ?>><?php esc_html_e('None', 'ktsttestimonial'); ?></option>
					                    <option value="google" <?php selected($recaptcha_type, 'google'); ?>><?php esc_html_e('Google reCAPTCHA', 'ktsttestimonial'); ?></option>
					                </select>
					            </td>
					        </tr>

					        <tr class="recaptcha-settings" style="display: <?php echo ($recaptcha_type === 'google') ? 'table-row' : 'none'; ?>;">
					            <th>
					                <label><?php esc_html_e('reCAPTCHA Version', 'ktsttestimonial'); ?></label>
					            </th>
					            <td>
					                <label>
					                    <input type="radio" name="custom_recaptcha_version" value="v2" <?php checked($recaptcha_version, 'v2'); ?>>
					                    <?php esc_html_e('v2', 'ktsttestimonial'); ?>
					                </label>
					                <label>
					                    <input type="radio" name="custom_recaptcha_version" value="v3" <?php checked($recaptcha_version, 'v3'); ?>>
					                    <?php esc_html_e('v3', 'ktsttestimonial'); ?>
					                </label>
					            </td>
					        </tr>

					        <tr class="recaptcha-settings" style="display: <?php echo ($recaptcha_type === 'google') ? 'table-row' : 'none'; ?>;">
					            <th>
					                <label for="custom_recaptcha_site_key"><?php esc_html_e('Site Key', 'ktsttestimonial'); ?></label>
					            </th>
					            <td>
					                <input type="text" name="custom_recaptcha_site_key" id="custom_recaptcha_site_key" value="<?php echo esc_attr($site_key); ?>" class="regular-text">
					            </td>
					        </tr>

					        <tr class="recaptcha-settings" style="display: <?php echo ($recaptcha_type === 'google') ? 'table-row' : 'none'; ?>;">
					            <th>
					                <label for="custom_recaptcha_secret_key"><?php esc_html_e('Secret Key', 'ktsttestimonial'); ?></label>
					            </th>
					            <td>
					                <input type="text" name="custom_recaptcha_secret_key" id="custom_recaptcha_secret_key" value="<?php echo esc_attr($secret_key); ?>" class="regular-text">
					            </td>
					        </tr>

						    <script>
						        (function($) {
						            $('#custom_recaptcha_type').on('change', function() {
						                if ($(this).val() === 'google') {
						                    $('.recaptcha-settings').show();
						                } else {
						                    $('.recaptcha-settings').hide();
						                }
						            });
						        })(jQuery);
						    </script>
						</table>
					</div>
				</div>
			</li>

			<!-- Tab 4 -->
			<li style="<?php if($nav_value == 4){echo "display: block;";} else{ echo "display: none;"; }?>" class="box4 tab-box <?php if($nav_value == 4){echo "active";}?>">
				<div class="wrap">
					<div class="option-box">
						<p class="option-title"><?php esc_html_e( 'Labels & Messages','ktsttestimonial' ); ?> <a href="https://themepoints.com/testimonials" target="_blank"> - <?php _e( 'Unlock all upgrades with Pro!', 'ktsttestimonial' ); ?></a></p>
						<table class="form-table">

							<tr valign="top">
								<th scope="row">
									<label for="tp_required_show_hide"><?php esc_html_e( 'Required Notice', 'ktsttestimonial' ); ?></label>
									<span class="tpstestimonial_manager_hint toss">
										<?php esc_html_e( 'Display required notice at top of the form.', 'ktsttestimonial' ); ?>
									</span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="tp_required_show" name="tp_required_show_hide" value="1" <?php if ( $tp_required_show_hide == 1 || $tp_required_show_hide == '' ) echo 'checked'; ?>/>
										<label for="tp_required_show"><?php esc_html_e( 'Show', 'ktsttestimonial' ); ?></label>
										<input type="radio" id="tp_required_hide" name="tp_required_show_hide" value="2" <?php if ( $tp_required_show_hide == 2 ) echo 'checked'; ?>/>
										<label for="tp_required_hide"><?php esc_html_e( 'Hide', 'ktsttestimonial' ); ?></label>
									</div>
								</td>
							</tr><!-- End Required Notice Show/Hide -->

							<tr valign="top">
							    <th scope="row">
							        <label for="tp_required_notice_text"><?php esc_html_e('Notice Label', 'ktsttestimonial'); ?></label>
							        <span class="tpstestimonial_manager_hint toss">
							            <?php esc_html_e('Set a label for the required notice.', 'ktsttestimonial'); ?>
							        </span>
							    </th>
							    <td style="vertical-align: middle;">
							        <input type="text" name="tp_required_notice_text" id="tp_required_notice_text" value="<?php echo esc_attr(!empty($tp_required_notice_text) ? $tp_required_notice_text : 'Red asterisk fields are required.'); ?>">
							    </td>
							</tr><!-- End Required Notice Show/Hide -->

							<tr valign="top">
								<th scope="row">
									<label for="tp_form_asterisk_color"><?php esc_html_e( 'Asterisk Color', 'ktsttestimonial' ); ?></label>
									<span class="tpstestimonial_manager_hint toss"><?php esc_html_e( 'Set color for the testimonial form asterisk.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="text" id="tp_form_asterisk_color" name="tp_form_asterisk_color" value="<?php echo esc_attr($tp_form_asterisk_color); ?>">
								</td>
							</tr>
							<!-- End Form asterisk Color -->

							<tr valign="top">
							    <th scope="row">
							        <label for="tp_success_message"><?php esc_html_e('Successful Message', 'ktsttestimonial'); ?></label>
							        <span class="tpstestimonial_manager_hint toss">
							            <?php esc_html_e('Set a submission success message.', 'ktsttestimonial'); ?>
							        </span>
							    </th>
							    <td style="vertical-align: middle;">
							        <input type="text" name="tp_success_message" id="tp_success_message" value="<?php echo esc_attr(!empty($tp_success_message) ? $tp_success_message : 'Thank you! Your testimonial is currently waiting to be approved.'); ?>">
							    </td>
							</tr><!-- End Required Notice Show/Hide -->

							<tr valign="top">
								<th scope="row">
									<label for="tp_form_success_color"><?php esc_html_e( 'Successful Text Color', 'ktsttestimonial' ); ?></label>
									<span class="tpstestimonial_manager_hint toss"><?php esc_html_e( 'Set color for the testimonial form successful message.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="text" id="tp_form_success_color" name="tp_form_success_color" value="<?php echo esc_attr($tp_form_success_color); ?>">
								</td>
							</tr>
							<!-- End Form asterisk Color -->

							<tr valign="top">
							    <th scope="row">
							        <label for="tp_error_message"><?php esc_html_e('Error Message', 'ktsttestimonial'); ?></label>
							        <span class="tpstestimonial_manager_hint toss">
							            <?php esc_html_e('Set a submission error message.', 'ktsttestimonial'); ?>
							        </span>
							    </th>
							    <td style="vertical-align: middle;">
							        <input type="text" name="tp_error_message" id="tp_error_message" value="<?php echo esc_attr(!empty($tp_error_message) ? $tp_error_message : 'There was an error while processing your testimonial. Please try again.'); ?>">
							    </td>
							</tr><!-- End Required Notice Show/Hide -->

							<tr valign="top">
								<th scope="row">
									<label for="tp_form_error_color"><?php esc_html_e( 'Error Text Color', 'ktsttestimonial' ); ?></label>
									<span class="tpstestimonial_manager_hint toss"><?php esc_html_e( 'Set color for the testimonial form error message.', 'ktsttestimonial' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="text" id="tp_form_error_color" name="tp_form_error_color" value="<?php echo esc_attr($tp_form_error_color); ?>">
								</td>
							</tr>
							<!-- End Form asterisk Color -->

						</table>
					</div>
				</div>
			</li>

            <!-- Tab 5 -->
            <li style="<?php if($nav_value == 5){echo "display: block;";} else{ echo "display: none;"; }?>" class="box5 tab-box <?php if($nav_value == 5){echo "active";}?>">
                <div class="wrap">
                    <div class="option-box">
                        <p class="option-title"><?php esc_html_e( 'Notifications','ktsttestimonial' ); ?> <a href="https://themepoints.com/testimonials" target="_blank"> - <?php _e( 'Unlock all upgrades with Pro!', 'ktsttestimonial' ); ?></a></p>
                        <table class="form-table">

                            <tr valign="top">
                                <th scope="row">
                                    <label for="notification_enabled"><?php esc_html_e( 'Admin Notification', 'ktsttestimonial' ); ?></label>
                                    <span class="tpstestimonial_manager_hint toss"><?php esc_html_e( 'Enable/Dsiable testimonial admin notice.', 'ktsttestimonial' ); ?></span>
                                </th>
                                <td style="vertical-align: middle;">
                                    <input type="checkbox" name="notification_enabled" value="1" <?php checked($notification_enabled, '1'); ?>>Enable Notification
                                </td>
                            </tr>
                            <!-- End Form Admin Notification -->

                            <tr valign="top">
                                <th scope="row">
                                    <label for="notification_to"><?php esc_html_e( 'To', 'ktsttestimonial' ); ?></label>
                                </th>
                                <td style="vertical-align: middle;">
                                    <input type="email" id="notification_to" disabled name="notification_to" value="<?php echo esc_attr($notification_to); ?>" class="regular-text">
                                </td>
                            </tr>
                            <!-- End Form To -->

                            <tr valign="top">
                                <th scope="row">
                                    <label for="notification_from"><?php esc_html_e( 'From', 'ktsttestimonial' ); ?></label>
                                </th>
                                <td style="vertical-align: middle;">
                                    <input type="text" id="notification_from" disabled name="notification_from" value="<?php echo esc_attr($notification_from); ?>" class="regular-text">
                                </td>
                            </tr>
                            <!-- End Form From -->

                            <tr valign="top">
                                <th scope="row">
                                    <label for="notification_subject"><?php esc_html_e( 'Subject', 'ktsttestimonial' ); ?></label>
                                </th>
                                <td style="vertical-align: middle;">
                                    <input type="text" id="notification_subject" disabled name="notification_subject" value="<?php echo esc_attr($notification_subject); ?>" placeholder="Enter subject line" class="regular-text">
                                    <p class="description">
                                        You can use placeholders like <code>{site_title}</code>, <code>{author_name}</code>, etc., which will be replaced dynamically.
                                    </p>
                                </td>
                            </tr>
                            <!-- End Form Subject -->

                            <tr valign="top">
                                <th scope="row">
                                    <label for="notification_body"><?php esc_html_e( 'Message Body', 'ktsttestimonial' ); ?></label>
                                </th>
                                <td style="vertical-align: middle;">
                                    <?php
                                    // TinyMCE Editor for Notification Body
                                    wp_editor(
                                        $notification_body, // Default content
                                        'notification_body', // Editor ID
                                        array(
                                            'textarea_name' => 'notification_body',
                                            'textarea_rows' => 18,
                                            'media_buttons' => false,
                                            'teeny' => true,
                                            'quicktags' => true,
                                        )
                                    );
                                    ?>
                                    <p class="description">
                                        Use placeholders like <code>{name}</code>, <code>{email}</code>, <code>{testimonial_text}</code>, and <code>{rating}</code> to include dynamic content in the email.
                                    </p>
                                </td>
                            </tr>
                            <!-- End Form Message Body -->
                        </table>
                    </div>
                </div>
            </li>
		</ul>
	</div>

	<script type="text/javascript">
		jQuery( document ).ready( function( jQuery ) {
			jQuery( '#tp_form_label_color, #tp_form_placeholder_color, #tp_form_bgcolor, #tp_form_rating_color, #tp_form_rating_hover_color, #tp_form_btn_color, #tp_form_btn_hover_color, #tp_form_btn_bg_color, #tp_form_btn_bg_hover_color, #tp_form_asterisk_color, #tp_form_success_color, #tp_form_error_color' ).wpColorPicker();
		} );
	</script>

    <?php
    wp_nonce_field('tps_testimonial_form_save', 'tps_testimonial_form_nonce');
}

function tps_save_testimonial_form_metabox($post_id) {
    if (!isset($_POST['tps_testimonial_form_nonce']) || !wp_verify_nonce($_POST['tps_testimonial_form_nonce'], 'tps_testimonial_form_save')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Get the existing settings
    $settings = get_post_meta($post_id, 'tp_testimonial_form_settings', true);
    if (!is_array($settings)) {
        $settings = array();
    }

    // Loop through defined fields and save settings
    $fields = tp_testimonial_form_settings();

    foreach ($fields as $key => $field) {
        // Preserve previous values if they exist
        $settings[$key] = isset($settings[$key]) ? $settings[$key] : [];

        // Handle checkboxes: If not set in $_POST, it means unchecked (set to 0)
        $settings[$key]['enabled'] = isset($_POST['tp_testimonial_settings'][$key]['enabled']) ? 1 : 0;
        if (isset($field['required'])) {
            $settings[$key]['required'] = isset($_POST['tp_testimonial_settings'][$key]['required']) ? 1 : 0;
        }

        // Save text fields (label & placeholder)
        if (isset($field['label'])) {
            $settings[$key]['label'] = sanitize_text_field($_POST['tp_testimonial_settings'][$key]['label'] ?? $field['label']);
        }
        if (isset($field['placeholder'])) {
            $settings[$key]['placeholder'] = sanitize_text_field($_POST['tp_testimonial_settings'][$key]['placeholder'] ?? $field['placeholder']);
        }
    }
    update_post_meta($post_id, 'tp_testimonial_form_settings', $settings);

	#Checks for input and sanitizes/saves if needed
	if ( isset( $_POST[ 'tp_form_submitbtn' ] ) ) {
		$tp_form_submitbtn = sanitize_text_field( $_POST['tp_form_submitbtn'] );
		update_post_meta( $post_id, 'tp_form_submitbtn', $tp_form_submitbtn );
	}

	#Checks for input and sanitizes/saves if needed
	if ( isset( $_POST[ 'tp_form_width' ] ) ) {
		$tp_form_width = sanitize_text_field( $_POST['tp_form_width'] );
		update_post_meta( $post_id, 'tp_form_width', $tp_form_width );
	}

	#Checks for input and sanitizes/saves if needed
	if ( isset( $_POST[ 'tp_form_bgcolor' ] ) ) {
		$tp_form_bgcolor = sanitize_hex_color( $_POST['tp_form_bgcolor'] );
		update_post_meta( $post_id, 'tp_form_bgcolor', $tp_form_bgcolor );
	}

	#Checks for input and sanitizes/saves if needed
	if ( isset( $_POST[ 'tp_required_show_hide' ] ) ) {
		$tp_required_show_hide = sanitize_text_field( $_POST['tp_required_show_hide'] );
		update_post_meta( $post_id, 'tp_required_show_hide', $tp_required_show_hide );
	}

	#Checks for input and sanitizes/saves if needed
	if ( isset( $_POST[ 'tp_required_notice_text' ] ) ) {
		$tp_required_notice_text = sanitize_text_field( $_POST['tp_required_notice_text'] );
		update_post_meta( $post_id, 'tp_required_notice_text', $tp_required_notice_text );
	}

	#Checks for input and sanitizes/saves if needed
	if ( isset( $_POST[ 'tp_success_message' ] ) ) {
		$tp_success_message = sanitize_text_field( $_POST['tp_success_message'] );
		update_post_meta( $post_id, 'tp_success_message', $tp_success_message );
	}

	#Checks for input and sanitizes/saves if needed
	if ( isset( $_POST[ 'tp_error_message' ] ) ) {
		$tp_error_message = sanitize_text_field( $_POST['tp_error_message'] );
		update_post_meta( $post_id, 'tp_error_message', $tp_error_message );
	}

	#Checks for input and sanitizes/saves if needed
	if ( isset( $_POST[ 'tp_border_width' ] ) ) {
		$tp_border_width = sanitize_text_field( $_POST['tp_border_width'] );
		update_post_meta( $post_id, 'tp_border_width', $tp_border_width );
	}

	#Checks for input and sanitizes/saves if needed
	if ( isset( $_POST[ 'tp_border_style' ] ) ) {
		$tp_border_style = sanitize_text_field( $_POST['tp_border_style'] );
		update_post_meta( $post_id, 'tp_border_style', $tp_border_style );
	}

	#Checks for input and sanitizes/saves if needed
	if ( isset( $_POST[ 'tp_border_color' ] ) ) {
		$tp_border_color = sanitize_text_field( $_POST['tp_border_color'] );
		update_post_meta( $post_id, 'tp_border_color', $tp_border_color );
	}

	#Checks for input and sanitizes/saves if needed
	if ( isset( $_POST[ 'tp_border_radius' ] ) ) {
		$tp_border_radius = sanitize_text_field( $_POST['tp_border_radius'] );
		update_post_meta( $post_id, 'tp_border_radius', $tp_border_radius );
	}

	// Sanitize and save 'tp_form_placeholder_color' field
	if ( isset( $_POST[ 'tp_form_placeholder_color' ] ) ) {
		$tp_form_placeholder_color = sanitize_hex_color( $_POST['tp_form_placeholder_color'] );
		update_post_meta( $post_id, 'tp_form_placeholder_color', $tp_form_placeholder_color );
	}

	#Checks for input and sanitizes/saves if needed
	if ( isset( $_POST[ 'tp_form_label_color' ] ) ) {
		$tp_form_label_color = sanitize_hex_color( $_POST['tp_form_label_color'] );
		update_post_meta( $post_id, 'tp_form_label_color', $tp_form_label_color );
	}

	#Checks for input and sanitizes/saves if needed
	if ( isset( $_POST[ 'tp_label_width' ] ) ) {
		$tp_label_width = sanitize_text_field( $_POST['tp_label_width'] );
		update_post_meta( $post_id, 'tp_label_width', $tp_label_width );
	}

	#Checks for input and sanitizes/saves if needed
	if ( isset( $_POST[ 'tp_label_style' ] ) ) {
		$tp_label_style = sanitize_text_field( $_POST['tp_label_style'] );
		update_post_meta( $post_id, 'tp_label_style', $tp_label_style );
	}

	#Checks for input and sanitizes/saves if needed
	if ( isset( $_POST[ 'tp_lable_border_color' ] ) ) {
		$tp_lable_border_color = sanitize_text_field( $_POST['tp_lable_border_color'] );
		update_post_meta( $post_id, 'tp_lable_border_color', $tp_lable_border_color );
	}

	#Checks for input and sanitizes/saves if needed
	if ( isset( $_POST[ 'tp_lable_bg_color' ] ) ) {
		$tp_lable_bg_color = sanitize_text_field( $_POST['tp_lable_bg_color'] );
		update_post_meta( $post_id, 'tp_lable_bg_color', $tp_lable_bg_color );
	}

	#Checks for input and sanitizes/saves if needed
	if ( isset( $_POST[ 'tp_label_border_radius' ] ) ) {
		$tp_label_border_radius = sanitize_text_field( $_POST['tp_label_border_radius'] );
		update_post_meta( $post_id, 'tp_label_border_radius', $tp_label_border_radius );
	}

	#Checks for input and sanitizes/saves if needed
	if ( isset( $_POST[ 'tp_form_rating_color' ] ) ) {
		$tp_form_rating_color = sanitize_hex_color( $_POST['tp_form_rating_color'] );
		update_post_meta( $post_id, 'tp_form_rating_color', $tp_form_rating_color );
	}

    #Checks for input and sanitizes/saves if needed
    if ( isset( $_POST[ 'tp_form_rating_hover_color' ] ) ) {
        $tp_form_rating_hover_color = sanitize_hex_color( $_POST['tp_form_rating_hover_color'] );
        update_post_meta( $post_id, 'tp_form_rating_hover_color', $tp_form_rating_hover_color );
    }

    #Checks for input and sanitizes/saves if needed
    if (isset($_POST['tp_rating_style'])) {
        update_post_meta($post_id, 'tp_rating_style', sanitize_text_field($_POST['tp_rating_style']));
    }

	#Checks for input and sanitizes/saves if needed
	if ( isset( $_POST[ 'tp_form_btn_color' ] ) ) {
		$tp_form_btn_color = sanitize_hex_color( $_POST['tp_form_btn_color'] );
		update_post_meta( $post_id, 'tp_form_btn_color', $tp_form_btn_color );
	}

	#Checks for input and sanitizes/saves if needed
	if ( isset( $_POST[ 'tp_form_btn_hover_color' ] ) ) {
		$tp_form_btn_hover_color = sanitize_hex_color( $_POST['tp_form_btn_hover_color'] );
		update_post_meta( $post_id, 'tp_form_btn_hover_color', $tp_form_btn_hover_color );
	}

	#Checks for input and sanitizes/saves if needed
	if ( isset( $_POST[ 'tp_form_btn_bg_color' ] ) ) {
		$tp_form_btn_bg_color = sanitize_hex_color( $_POST['tp_form_btn_bg_color'] );
		update_post_meta( $post_id, 'tp_form_btn_bg_color', $tp_form_btn_bg_color );
	}

	#Checks for input and sanitizes/saves if needed
	if ( isset( $_POST[ 'tp_form_btn_bg_hover_color' ] ) ) {
		$tp_form_btn_bg_hover_color = sanitize_hex_color( $_POST['tp_form_btn_bg_hover_color'] );
		update_post_meta( $post_id, 'tp_form_btn_bg_hover_color', $tp_form_btn_bg_hover_color );
	}

	#Checks for input and sanitizes/saves if needed
	if ( isset( $_POST[ 'tp_form_asterisk_color' ] ) ) {
		$tp_form_asterisk_color = sanitize_hex_color( $_POST['tp_form_asterisk_color'] );
		update_post_meta( $post_id, 'tp_form_asterisk_color', $tp_form_asterisk_color );
	}

	#Checks for input and sanitizes/saves if needed
	if ( isset( $_POST[ 'tp_form_success_color' ] ) ) {
		$tp_form_success_color = sanitize_hex_color( $_POST['tp_form_success_color'] );
		update_post_meta( $post_id, 'tp_form_success_color', $tp_form_success_color );
	}

	#Checks for input and sanitizes/saves if needed
	if ( isset( $_POST[ 'tp_form_error_color' ] ) ) {
		$tp_form_error_color = sanitize_hex_color( $_POST['tp_form_error_color'] );
		update_post_meta( $post_id, 'tp_form_error_color', $tp_form_error_color );
	}

	#Checks for input and sanitizes/saves if needed
	if ( isset( $_POST[ 'tp_fptop_width' ] ) ) {
		$tp_fptop_width = sanitize_text_field( $_POST['tp_fptop_width'] );
		update_post_meta( $post_id, 'tp_fptop_width', $tp_fptop_width );
	}

	#Checks for input and sanitizes/saves if needed
	if ( isset( $_POST[ 'tp_fpright_width' ] ) ) {
		$tp_fpright_width = sanitize_text_field( $_POST['tp_fpright_width'] );
		update_post_meta( $post_id, 'tp_fpright_width', $tp_fpright_width );
	}

	#Checks for input and sanitizes/saves if needed
	if ( isset( $_POST[ 'tp_fpbottom_width' ] ) ) {
		$tp_fpbottom_width = sanitize_text_field( $_POST['tp_fpbottom_width'] );
		update_post_meta( $post_id, 'tp_fpbottom_width', $tp_fpbottom_width );
	}

	#Checks for input and sanitizes/saves if needed
	if ( isset( $_POST[ 'tp_fpleft_width' ] ) ) {
		$tp_fpleft_width = sanitize_text_field( $_POST['tp_fpleft_width'] );
		update_post_meta( $post_id, 'tp_fpleft_width', $tp_fpleft_width );
	}

	#Checks for input and sanitizes/saves if needed
	if ( isset( $_POST[ 'custom_post_status' ] ) ) {
		$custom_post_status = sanitize_text_field( $_POST['custom_post_status'] );
		update_post_meta( $post_id, 'custom_post_status', $custom_post_status );
	}

	#Checks for input and sanitizes/saves if needed
	if ( isset( $_POST[ 'custom_recaptcha_type' ] ) ) {
		$custom_recaptcha_type = sanitize_text_field( $_POST['custom_recaptcha_type'] );
		update_post_meta( $post_id, 'custom_recaptcha_type', $custom_recaptcha_type );
	}

	#Checks for input and sanitizes/saves if needed
	if ( isset( $_POST[ 'custom_recaptcha_version' ] ) ) {
		$custom_recaptcha_version = sanitize_text_field( $_POST['custom_recaptcha_version'] );
		update_post_meta( $post_id, 'custom_recaptcha_version', $custom_recaptcha_version );
	}

	#Checks for input and sanitizes/saves if needed
	if ( isset( $_POST[ 'custom_recaptcha_site_key' ] ) ) {
		$custom_recaptcha_site_key = sanitize_text_field( $_POST['custom_recaptcha_site_key'] );
		update_post_meta( $post_id, 'custom_recaptcha_site_key', $custom_recaptcha_site_key );
	}

	#Checks for input and sanitizes/saves if needed
	if ( isset( $_POST[ 'custom_recaptcha_secret_key' ] ) ) {
		$custom_recaptcha_secret_key = sanitize_text_field( $_POST['custom_recaptcha_secret_key'] );
		update_post_meta( $post_id, 'custom_recaptcha_secret_key', $custom_recaptcha_secret_key );
	}

    #Checks for input and sanitizes/saves if needed
	update_post_meta($post_id, 'enable_recaptcha', isset($_POST['enable_recaptcha']) ? '1' : '0');

    #Checks for input and sanitizes/saves if needed
    if (isset($_POST['notification_enabled'])) {
        update_post_meta($post_id, '_notification_enabled', '1');
    } else {
        delete_post_meta($post_id, '_notification_enabled');
    }

    #Checks for input and sanitizes/saves if needed
    if (isset($_POST['notification_to'])) {
        update_post_meta($post_id, 'notification_to', sanitize_email($_POST['notification_to']));
    }

    #Checks for input and sanitizes/saves if needed
    if (isset($_POST['notification_from'])) {
        update_post_meta($post_id, 'notification_from', sanitize_text_field($_POST['notification_from']));
    }

    #Checks for input and sanitizes/saves if needed
    if (isset($_POST['notification_subject'])) {
        update_post_meta($post_id, 'notification_subject', sanitize_text_field($_POST['notification_subject']));
    }

    #Checks for input and sanitizes/saves if needed
    if (isset($_POST['notification_body'])) {
        update_post_meta($post_id, 'notification_body', wp_kses_post($_POST['notification_body']));
    }

	#Checks for input and sanitizes/saves if needed
	if ( isset( $_POST[ 'nav_value' ] ) ) {
	    $nav_value = sanitize_text_field( $_POST['nav_value'] ); // Sanitize nav_value input
	    update_post_meta( $post_id, 'nav_value', $nav_value );
	} else {
	    update_post_meta( $post_id, 'nav_value', 1 ); // Default value
	}
}
add_action('save_post', 'tps_save_testimonial_form_metabox');


function tps_sidebar_add_shortcode_metabox() {
    add_meta_box(
        'tps_sidebar_testimonial_shortcode',
        'Copy Form Shortcode',
        'tps_sidebar_render_shortcode_metabox',
        'tp_testimonial_form',
        'side',
        'low'
    );
}
add_action('add_meta_boxes', 'tps_sidebar_add_shortcode_metabox');

function tps_sidebar_render_shortcode_metabox($post) {
    ?>
    <p><?php esc_html_e('To display the Testimonial Form, copy and paste this shortcode into your post, page, custom post, block editor, or page builder.', 'ktsttestimonial'); ?></p>
    <input type="text" id="shortcode_<?php echo esc_attr($post->ID); ?>" 
           onclick="copyShortcode('<?php echo esc_attr($post->ID); ?>')" 
           readonly 
           value='[frontend_form id="<?php echo esc_attr($post->ID); ?>"]' 
           style="cursor:pointer; background:#f3f3f3; border:1px solid #ddd;" />

    <p id="copy-message-<?php echo esc_attr($post->ID); ?>" 
       style="color: green; font-size: 14px; display: none; margin-top: 5px;margin-bottom: 0px">
       <?php esc_html_e('Shortcode copied!', 'ktsttestimonial'); ?>
    </p>

    <script>
        function copyShortcode(postId) {
            var shortcodeField = document.getElementById("shortcode_" + postId);
            var copyMessage = document.getElementById("copy-message-" + postId);
            
            shortcodeField.select();
            navigator.clipboard.writeText(shortcodeField.value).then(function() {
                copyMessage.style.display = "block"; // Show message
                setTimeout(function() {
                    copyMessage.style.display = "none"; // Hide after 2 seconds
                }, 2000);
            }).catch(function(err) {
                console.error("Could not copy text: ", err);
            });
        }
    </script>
    <?php
}

// Retrieve and Apply Settings in Frontend Form
function tp_testimonial_get_frontend_form_settings() {
    $default_settings = tp_testimonial_form_settings();
    $saved_settings = get_post_meta(get_the_ID(), 'tp_testimonial_form_settings', true);
    
    if (!empty($saved_settings)) {
        foreach ($saved_settings as $key => $field) {
            if (isset($default_settings[$key])) {
                $default_settings[$key] = array_merge($default_settings[$key], $field);
            }
        }
    }
    return $default_settings;
}