<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


function tps_testimonial_form_shortcode($atts) {

    $atts = shortcode_atts(
        array('id' => 0), 
        $atts, 'frontend_form'
    );

    $post_id = intval($atts['id']);

    // Generate a unique ID for the form
    $form_id = uniqid('testimonial_form_');

    // Get saved settings from the metabox
    $saved_settings = get_post_meta($post_id, 'tp_testimonial_form_settings', true);
    if (!is_array($saved_settings)) {
        $saved_settings = array();
    }

    // Default fields structure (Ensure it matches the metabox settings)
    $default_fields             = tp_testimonial_form_settings();
    
    $tp_form_submitbtn          = get_post_meta($post_id, 'tp_form_submitbtn', true );
    $tp_form_width              = get_post_meta($post_id, 'tp_form_width', true ) ?: '650';
    $tp_form_bgcolor            = get_post_meta($post_id, 'tp_form_bgcolor', true) ?: '#ffffff';
    $tp_required_show_hide      = get_post_meta($post_id, 'tp_required_show_hide', true );
    $tp_required_notice_text    = get_post_meta($post_id, 'tp_required_notice_text', true );
    $tp_success_message         = get_post_meta($post_id, 'tp_success_message', true );
    $tp_error_message           = get_post_meta($post_id, 'tp_error_message', true );
    $tp_border_width            = get_post_meta($post_id, 'tp_border_width', true);
    $tp_border_style            = get_post_meta($post_id, 'tp_border_style', true) ?: 'solid';
    $tp_border_color            = get_post_meta($post_id, 'tp_border_color', true) ?: '#111111';
    $tp_border_radius           = get_post_meta($post_id, 'tp_border_radius', true);
    $tp_form_placeholder_color  = get_post_meta($post_id, 'tp_form_placeholder_color', true) ?: '#999';
    $tp_form_label_color        = get_post_meta($post_id, 'tp_form_label_color', true) ?: '#111111';
    $tp_label_width             = get_post_meta($post_id, 'tp_label_width', true) ?: '1';
    $tp_label_style             = get_post_meta($post_id, 'tp_label_style', true) ?: 'solid';
    $tp_lable_border_color      = get_post_meta($post_id, 'tp_lable_border_color', true) ?: '#111111';
    $tp_lable_bg_color          = get_post_meta($post_id, 'tp_lable_bg_color', true) ?: '#ffffff';
    $tp_label_border_radius     = get_post_meta($post_id, 'tp_label_border_radius', true);
    $tp_form_rating_color       = get_post_meta($post_id, 'tp_form_rating_color', true) ?: '#cccccc';
    $tp_form_btn_color          = get_post_meta($post_id, 'tp_form_btn_color', true) ?: '#ffffff';
    $tp_form_btn_hover_color    = get_post_meta($post_id, 'tp_form_btn_hover_color', true) ?: '#ffffff';
    $tp_form_btn_bg_color       = get_post_meta($post_id, 'tp_form_btn_bg_color', true) ?: '#0073aa';
    $tp_form_btn_bg_hover_color = get_post_meta($post_id, 'tp_form_btn_bg_hover_color', true) ?: '#005a87';
    $tp_fptop_width             = get_post_meta($post_id, 'tp_fptop_width', true ) ?: '30';
    $tp_fpright_width           = get_post_meta($post_id, 'tp_fpright_width', true ) ?: '30';
    $tp_fpbottom_width          = get_post_meta($post_id, 'tp_fpbottom_width', true ) ?: '30';
    $tp_fpleft_width            = get_post_meta($post_id, 'tp_fpleft_width', true ) ?: '30';
    $enable_recaptcha           = get_post_meta($post_id, 'enable_recaptcha', true);
    
    // Get saved meta values
    $post_status                = get_post_meta($post_id, 'custom_post_status', true) ?: 'pending';
    $recaptcha_type             = get_post_meta($post_id, 'custom_recaptcha_type', true) ?: 'none';
    $recaptcha_version          = get_post_meta($post_id, 'custom_recaptcha_version', true) ?: 'v2';
    $site_key                   = get_post_meta($post_id, 'custom_recaptcha_site_key', true) ?: '';
    $secret_key                 = get_post_meta($post_id, 'custom_recaptcha_secret_key', true) ?: '';


    // Check if the post exists and is published
    if (!$post_id || get_post_status($post_id) !== 'publish') {
        return '<p class="error-message">No testimonial form is available. Please create and publish a Testimonial Form first.</p>';
    }

    if ($post_id <= 0) {
        return '<p>Error: Invalid form ID.</p>';
    }

    $success_message = '';
    $error_message = '';
    $submitted_data = $_POST; // Store form data


    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_testimonial'])) {
        
        // Verify nonce before processing
        if (!isset($_POST['testimonial_form_nonce']) || !wp_verify_nonce($_POST['testimonial_form_nonce'], 'submit_testimonial_form')) {
            die('Security check failed.');
        }

        // Sanitize inputs
        $fields = array(
            'main_title'              => isset($_POST['main_title']) ? sanitize_text_field($_POST['main_title']) : '',
            'name'                    => isset($_POST['post_title']) ? sanitize_text_field($_POST['post_title']) : '',
            'position'                => isset($_POST['position_input']) ? sanitize_text_field($_POST['position_input']) : '',
            'email_address'           => isset($_POST['email_address']) ? sanitize_email($_POST['email_address']) : '',
            'company'                 => isset($_POST['company_input']) ? sanitize_text_field($_POST['company_input']) : '',
            'company_website'         => isset($_POST['company_website_input']) ? sanitize_text_field($_POST['company_website_input']) : '',
            'testimonial_text'        => isset($_POST['testimonial_text_input']) ? wp_kses_post($_POST['testimonial_text_input']) : '',
            'company_rating_target'   => isset($_POST['company_rating_target_list']) ? sanitize_text_field($_POST['company_rating_target_list']) : '',
        );

        $error_message = '';

        // Validate the image upload
        if (!empty($_FILES['photo']['name'])) {
            $file = $_FILES['photo'];
            $file_type = wp_check_filetype($file['name']);
            if (!in_array($file_type['ext'], array('jpg', 'jpeg', 'png'))) {
                $error_message = 'Only JPG, JPEG, and PNG files are allowed.';
            } elseif ($file['size'] > 5 * 1024 * 1024) {
                $error_message = 'Image size must be under 5MB.';
            }
        }


        // Check if all fields are empty
        if (empty($submitted_data['testimonial_text_input'])) {
            $error_message = "Please fill out content field before submitting.";
        } else {

            if (empty($error_message)) {
                $post_id = wp_insert_post(array(
                    'post_type' => 'ktsprotype',
                    'post_status' => 'pending',
                    'post_title' => $fields['main_title'],
                    'testimonial_text' => $fields['testimonial_text'],
                ));

                if ($post_id) {
                    foreach ($fields as $key => $value) {
                        update_post_meta($post_id, $key, $value);
                    }

                    if (!empty($_FILES['photo']['name'])) {
                        require_once(ABSPATH . 'wp-admin/includes/file.php');
                        $upload = wp_handle_upload($file, array('test_form' => false));
                        if (!isset($upload['error'])) {
                            $attachment_id = wp_insert_attachment(array(
                                'guid' => $upload['url'],
                                'post_mime_type' => $upload['type'],
                                'post_title' => sanitize_file_name($upload['file']),
                            ), $upload['file'], $post_id);

                            require_once(ABSPATH . 'wp-admin/includes/image.php');
                            wp_update_attachment_metadata($attachment_id, wp_generate_attachment_metadata($attachment_id, $upload['file']));
                            set_post_thumbnail($post_id, $attachment_id);
                        }
                    }

                    // Success: Redirect to prevent form resubmission
                    $redirect_url = add_query_arg('success', 'true', $_SERVER['REQUEST_URI']);
    
                    if (!headers_sent()) {
                        wp_safe_redirect($redirect_url);
                        exit;
                    } else {
                        echo '<script>window.location.href="' . esc_url($redirect_url) . '";</script>';
                        exit;
                    }
                } else {
                    $error_message = 'There was an error while processing your testimonial. Please try again.';
                }
            }
        }
    }

    ob_start();

    // Keep submitted data only if there's an error
    $submitted_data = isset($error_message) ? $submitted_data : array();

    ?>

    <div class="tps-testimonial-form-wrapper">

        <?php if (!empty($tp_required_notice_text) && $tp_required_show_hide !== '2') : ?>
            <div class="tps-testimonial-required-info"><?php echo esc_html($tp_required_notice_text); ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" class="tps-testimonial-form" id="tps-testimonial-form">

            <?php wp_nonce_field('submit_testimonial_form', 'testimonial_form_nonce'); ?>

            <?php
                // Loop through the fields and display them based on the saved settings
                foreach ($default_fields as $key => $field) {
                    // Get the saved settings for this field
                    $field_settings = isset($saved_settings[$key]) ? $saved_settings[$key] : $field;

                    // Skip this field if it is disabled
                    if (isset($field_settings['enabled']) && !$field_settings['enabled']) {
                        continue;
                    }

                    // Add field HTML based on its type
                    $required_attr = !empty($field_settings['required']) ? 'required' : '';
                    $placeholder_attr = isset($field_settings['placeholder']) ? 'placeholder="' . esc_attr($field_settings['placeholder']) . '"' : '';

                    // Check if the field is required
                    $is_required = !empty($field_settings['required']);

                    // Create unique IDs by appending $form_id to the field ID
                    $unique_field_id = $form_id . '_' . $key;

                    ?>
                    <div class="form-field">
                        <label for="<?php echo esc_attr($unique_field_id); ?>">
                            <?php echo esc_html($field_settings['label']); ?>
                            <?php if ($is_required) : ?>
                                <span class="required-field-icon" style="color: red;">*</span>
                            <?php endif; ?>
                        </label>
                        <?php
                        if ($field['type'] === 'text' || $field['type'] === 'email') {
                            echo '<input type="' . esc_attr($field['type']) . '" id="' . esc_attr($unique_field_id) . '" name="' . esc_attr($key) . '" value="' . esc_attr($submitted_data[$key] ?? '') . '" ' . $placeholder_attr . ' ' . $required_attr . '>';
                        } elseif ($field['type'] === 'textarea') {
                            echo '<textarea id="' . esc_attr($unique_field_id) . '" name="' . esc_attr($key) . '" ' . $placeholder_attr . ' ' . $required_attr . '>' . esc_textarea($submitted_data[$key] ?? '') . '</textarea>';
                        } elseif ($field['type'] === 'file') {
                            echo '<input type="file" id="' . esc_attr($unique_field_id) . '" name="' . esc_attr($key) . '" accept="image/*">';
                        } elseif ($field['type'] === 'rating') { ?>
                            <div class="tp-star-rating">
                                <?php for ($i = 5; $i >= 1; $i--) : ?>
                                    <input type="radio" id="rating-<?php echo esc_attr($unique_field_id . '_' . $i); ?>" 
                                           name="company_rating_target_list" 
                                           value="<?php echo esc_attr($i); ?>">  
                                    <label for="rating-<?php echo esc_attr($unique_field_id . '_' . $i); ?>" title="<?php echo esc_attr($i . ' Star'); ?>"><i class="fa fa-star"></i></label>
                                <?php endfor; ?>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <?php
                }
            ?>

            <button type="submit" name="submit_testimonial" class="submit-button"><?php echo esc_html($tp_form_submitbtn); ?></button>

            <?php if (isset($_GET['success']) && $_GET['success'] === 'true') : ?>
                <?php if (!empty($tp_success_message)) : ?>
                    <p id="success-message" class="success-message"><?php echo esc_html($tp_success_message); ?></p>
                <?php endif; ?>
            <?php endif; ?>

            <script>
            document.addEventListener("DOMContentLoaded", function () {
                const form = document.getElementById("tps-testimonial-form");
                const successMessage = document.getElementById("success-message");

                if (form) {
                    form.addEventListener("submit", function (e) {
                        let testimonialText = document.getElementById("testimonial_text_input").value.trim();

                        // Validate testimonial text field
                        if (testimonialText === "") {
                            alert("Please fill out the content field before submitting.");
                            e.preventDefault();
                            return; // Stop form submission
                        }
                    });
                }

                // Hide success message after 10 seconds
                if (successMessage) {
                    setTimeout(() => {
                        successMessage.style.transition = "opacity 0.5s ease-out";
                        successMessage.style.opacity = "0";

                        setTimeout(() => {
                            successMessage.remove();
                        }, 500); // Remove after fade-out
                    }, 10000); // 10 seconds delay

                    // Remove 'success=true' from URL without reloading
                    if (window.location.search.includes("success=true")) {
                        const newUrl = window.location.origin + window.location.pathname;
                        window.history.replaceState({}, document.title, newUrl);
                    }
                }
            });
            </script>

            <!-- Success or Error Messages -->
            <?php if (!empty($success_message)) : ?>
                <p class="success-message"><?php echo esc_html($success_message); ?></p>
            <?php endif; ?>
            <?php if (!empty($error_message)) : ?>
                <p class="error-message"><?php echo esc_html($error_message); ?></p>
            <?php endif; ?>
        </form>

    </div>

    <style>
        .tps-testimonial-form-wrapper {
            max-width: <?php echo esc_attr( $tp_form_width ); ?>px;
            padding: <?php echo esc_attr( $tp_fptop_width ); ?>px <?php echo esc_attr( $tp_fpright_width ); ?>px <?php echo esc_attr( $tp_fpbottom_width ); ?>px <?php echo esc_attr( $tp_fpleft_width ); ?>px;
            border: <?php echo esc_attr( $tp_border_width ); ?>px <?php echo esc_attr( $tp_border_style ); ?> <?php echo esc_attr( $tp_border_color ); ?>;
            border-radius: <?php echo esc_attr( $tp_border_radius ); ?>px;
            background: <?php echo esc_attr( $tp_form_bgcolor ); ?>;
        }
        .tps-testimonial-form-wrapper .tps-testimonial-form .form-field {
            margin-bottom: 15px;
        }
        .tps-testimonial-form-wrapper .tps-testimonial-form label {
            display: block;
            overflow: hidden;
            font-weight: 600;
            font-size: 18px;
            color: <?php echo esc_attr( $tp_form_label_color ); ?>;
            margin-bottom: 5px;
        }
        .tps-testimonial-form-wrapper .tps-testimonial-form input[type=text],
        .tps-testimonial-form-wrapper .tps-testimonial-form input[type=email],
        .tps-testimonial-form textarea {
            width: 100%;
            padding: 10px;
            border: <?php echo esc_attr( $tp_label_width ); ?>px <?php echo esc_attr( $tp_label_style ); ?> <?php echo esc_attr( $tp_lable_border_color ); ?>;
            background: <?php echo esc_attr( $tp_lable_bg_color ); ?>;
            border-radius: <?php echo esc_attr( $tp_label_border_radius ); ?>px;
            font-size: 14px;
            box-sizing: border-box;
            text-decoration: none;
            outline: none;
            box-shadow: none;
            margin-bottom: 0;
        }
        .tps-testimonial-form-wrapper .tps-testimonial-form input[type=file] {
            font-size: 14px;
            box-sizing: border-box;
            text-decoration: none;
            outline: none;
            box-shadow: none;
            margin-bottom: 0;
        }

        .tps-testimonial-form-wrapper .tps-testimonial-form input::placeholder, 
        .tps-testimonial-form-wrapper .tps-testimonial-form textarea::placeholder {
            color: <?php echo esc_attr( $tp_form_placeholder_color ); ?>;
        }
        .tps-testimonial-form-wrapper .tps-testimonial-form .form-field .tp-star-rating label {
            font-size: 25px;
            line-height: 1;
            margin: 0;
        }
        .tps-testimonial-form-wrapper .tps-testimonial-form textarea {
            height: 100px;
            resize: none;
        }
        .tps-testimonial-form-wrapper .tps-testimonial-form .submit-button {
            display: block;
            max-width: 100%;
            padding: 15px 20px;
            background: <?php echo esc_attr( $tp_form_btn_bg_color ); ?>;
            color: <?php echo esc_attr( $tp_form_btn_color ); ?>;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
            box-shadow: none;
            outline: none;
        }
        .tps-testimonial-form-wrapper .tps-testimonial-form .submit-button:hover {
            background: <?php echo esc_attr( $tp_form_btn_bg_hover_color ); ?>;
            color: <?php echo esc_attr( $tp_form_btn_hover_color ); ?>;
        }
        .tps-testimonial-form-wrapper .success-message {
            margin: 10px 0px 0px;
            padding:0;
            font-size: 18px;
            color: #28a745;
            font-weight: 600;
        }
        .tps-testimonial-form-wrapper .error-message {
            margin: 10px 0px 0px;
            padding:0;
            font-size: 18px;
            color: #dc3545;
            font-weight: 600;
        }
        .tps-testimonial-form-wrapper .tp-star-rating {
            display: flex;
            justify-content: end;
            direction: rtl; /* Align stars from right-to-left */
            gap: 5px;
        }
        .tps-testimonial-form-wrapper .tp-star-rating input {
            display: none; /* Hide the radio buttons */
        }
        .tps-testimonial-form-wrapper .tp-star-rating label {
            font-size: 30px; /* Size of the stars */
            color: #ccc; /* Default color for stars */
            cursor: pointer; /* Pointer cursor for clickable stars */
            transition: color 0.3s ease; /* Smooth transition for color */
        }
        .tps-testimonial-form-wrapper .tp-star-rating label:hover,
        .tps-testimonial-form-wrapper .tp-star-rating label:hover ~ label {
            color: #f5c518; /* Gold color on hover */
        }
        .tps-testimonial-form-wrapper .tp-star-rating input:checked + label,
        .tps-testimonial-form-wrapper .tp-star-rating input:checked + label ~ label {
            color: #f5c518; /* Gold color when selected */
        }
        .tps-testimonial-form-wrapper .tps-testimonial-required-info {
            font-size: 14px;
            padding-bottom: 10px;
        }
    </style>
    <?php
    return ob_get_clean();

}

add_shortcode('frontend_form', 'tps_testimonial_form_shortcode');