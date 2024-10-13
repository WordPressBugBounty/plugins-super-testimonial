<?php 

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}// if direct access

// Saving Selected fields data in option table
if ( isset( $_POST['save_btn'] ) ) {

    // Sanitize selected options
    $selected_options = isset( $_POST['options'] ) ? array_map( 'sanitize_text_field', $_POST['options'] ) : array();
    update_option( 'st_user_fields', $selected_options );
    // Sanitize and update other options
    update_option( 'st_user_title', sanitize_text_field( $_POST['st_user_title'] ) );
    update_option( 'st_user_name', sanitize_text_field( $_POST['st_user_name'] ) );
    update_option( 'st_user_designation', sanitize_text_field( $_POST['st_user_designation'] ) );
    update_option( 'st_user_company_name', sanitize_text_field( $_POST['st_user_company_name'] ) );
    update_option( 'st_user_company_url', sanitize_text_field( $_POST['st_user_company_url'] ) );
    update_option( 'st_user_rating', sanitize_text_field( $_POST['st_user_rating'] ) );
    update_option( 'st_user_testi_text', sanitize_text_field( $_POST['st_user_testi_text'] ) );
    update_option( 'st_user_categories', sanitize_text_field( $_POST['st_user_categories'] ) );
    update_option( 'st_user_logo_img', esc_url_raw( $_POST['st_user_logo_img'] ) );
    update_option( 'st_user_calculate', sanitize_text_field( $_POST['st_user_calculate'] ) );
    update_option( 'post_status', sanitize_text_field( $_POST['post_status'] ) );
    update_option( 'st_user_submit_btn_text', sanitize_text_field( $_POST['st_user_submit_btn_text'] ) );
    // Sanitize error and success messages
    update_option( 'save_success_text', sanitize_textarea_field( $_POST['save_success_text'] ) );
    update_option( 'save_error_text', sanitize_textarea_field( $_POST['save_error_text'] ) );
    update_option( 'file_mishmatch_text', sanitize_textarea_field( $_POST['file_mishmatch_text'] ) );
    update_option( 'calc_error_text', sanitize_textarea_field( $_POST['calc_error_text'] ) );
}

// Check whether a field is selected or not
function isOptionChecked( $value ) {
    $options = get_option( 'st_user_fields' );
    if ( isset( $options ) && ! empty( $options ) && is_array( $options ) && in_array( $value, $options ) ) {
        echo " checked ";
    }
}

// Retrieve custom fields name
function st_user_fields_name( $field, $default ) {
    $field_name = get_option( $field );
    if ( isset( $field_name ) && ! empty( $field_name ) ) {
        echo $field_name;
    } else {
        echo $default;
    }
}

// Retrieve custom success and error messages
function st_user_retrive_messages( $field, $default ) {
    $field_name = get_option( $field );
    if ( isset( $field_name ) && ! empty( $field_name ) ) {
        return $field_name;
    } else {
        return $default;
    }
}

// Add Submenu Page Front end form options
function register_testimonial_user_options() {
    add_submenu_page( 'edit.php?post_type=ktsprotype', __( 'User Form', 'ktsttestimonial' ), sprintf( '<span style="color:#ddd;">%s</span>', __( 'Frontend Submission', 'ktsttestimonial' ) ), 'manage_options', 'frontend-form-options', 'themepoints_testimonial_user_options_page_layouts' );
}
add_action( 'admin_menu', 'register_testimonial_user_options' );

// Callback function for admin_menu hook
function themepoints_testimonial_user_options_page_layouts() { 
    $post_status = get_option( 'post_status' );
    ?>

    <style>
    .wrap {
      width: 50%;
      background-color: #fff;
      padding: 20px;
      border: 1px solid #ddd;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    .wrap p {
        font-size: 16px;
        line-height: 1.6;
    }
    table.form-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
    }
    table.form-table td{
      padding:10px;
    }
    table.form-table th {
        background-color: #0073aa;
        color: #fff;
    }
    input[type="text"], select, textarea {
        width: 100%;
        padding: 8px;
        margin: 0; /* Remove the margin */
        display: inline-block;
        border: 1px solid #ddd; /* Keep the border */
        border-radius: 0px;
        box-sizing: border-box;
        font-size: 14px;
    }
    table.form-table input[type="checkbox"] {
        margin-right: 10px;
    }
    table.form-table textarea {
        resize: vertical;
    }

    @media only screen and (max-width: 767px){
      .wrap {
        width: auto;
      }
    }
    @media only screen and (max-width: 1024px){
      .wrap {
        width: auto;
      }
    }
    </style>

    <div class="wrap">
        <h1><?php _e('Testimonial Submission Form :', 'ktsttestimonial'); ?></h1>
        <p><?php _e('From the list below select and give the name of the field you want to show as input fields to the front end users to submit testimonials.', 'ktsttestimonial'); ?></p>
        <p><?php _e('To display a form with fields selected here, just copy and paste this ', 'ktsttestimonial'); ?></p>
        <input onClick="copyShortcode();" type="text" id="shortcodeInput" name="" readonly value="[frontend_form]">
        <div id="toastNotification" style="display:none; background-color: #4CAF50; color: #fff; padding: 10px; position: fixed; bottom: 20px; right: 20px; border-radius: 5px;"></div>
        <p><?php _e('shortcode in a page or post. User will then see a form in frontend to submit their testimonial in that page or post.', 'ktsttestimonial'); ?></p>

        <script>
            function copyShortcode() {
                var shortcodeInput = document.getElementById("shortcodeInput");
                shortcodeInput.select();
                shortcodeInput.setSelectionRange(0, 99999); /* For mobile devices */
                document.execCommand("copy");
                shortcodeInput.setSelectionRange(0, 0);

                var toastNotification = document.getElementById("toastNotification");
                toastNotification.innerHTML = "Shortcode copied: " + shortcodeInput.value;
                toastNotification.style.display = "block";

                setTimeout(function(){
                    toastNotification.style.display = "none";
                }, 3000); // Hide the notification after 3 seconds (adjust as needed)
            }
        </script>

        <h3><a style="color:red;" href="https://www.themepoints.com/shop/super-testimonial-pro/" target="_blank">Upgrade To Pro!</a></h3>
        <form method="post" action="">
            <table class="form-table">
                <tr>
                    <td>
                        <input type="checkbox" id="st_user_title" name="options[]" value="Title" <?php isOptionChecked( 'Title' ); ?>> 
                        <label for="st_user_title"><?php _e('Title', 'ktsttestimonial'); ?></label>
                    </td>
                    <td>
                        <input type="text" name="st_user_title" value="<?php st_user_fields_name( 'st_user_title', 'We love to hear from our customers' ); ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" id="st_user_name" name="options[]" value="Name" <?php isOptionChecked( 'Name' ); ?>> 
                        <label for="st_user_name"><?php _e('Name', 'ktsttestimonial'); ?></label>
                    </td>
                    <td>
                        <input type="text" name="st_user_name" value="<?php st_user_fields_name( 'st_user_name', 'Name' ); ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input id="st_user_designation" type="checkbox" name="options[]" value="Designation" <?php isOptionChecked( 'Designation' ); ?>>
                        <label for="st_user_designation"><?php _e('Designation', 'ktsttestimonial'); ?></label>
                    </td>
                    <td>
                        <input type="text" name="st_user_designation" value="<?php st_user_fields_name( 'st_user_designation', 'Designation' ); ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input id="st_user_company_name" type="checkbox" name="options[]" value="Company Name" <?php isOptionChecked( 'Company Name' ); ?>>
                        <label for="st_user_company_name"><?php _e('Company Name', 'ktsttestimonial'); ?></label>
                    </td>
                    <td>
                        <input type="text" name="st_user_company_name" value="<?php st_user_fields_name( 'st_user_company_name', 'Company Name' ); ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input id="st_user_company_url" type="checkbox" name="options[]" value="Company URL" <?php isOptionChecked( 'Company URL' ); ?>>
                        <label for="st_user_company_url"><?php _e('Company URL', 'ktsttestimonial'); ?></label>
                    </td>
                    <td>
                        <input type="text" name="st_user_company_url" value="<?php st_user_fields_name( 'st_user_company_url', 'Company URL' ); ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input id="st_user_rating" type="checkbox" name="options[]" value="Rating" <?php isOptionChecked( 'Rating' ); ?>>
                        <label for="st_user_rating"><?php _e('Rating', 'ktsttestimonial'); ?></label>
                    </td>
                    <td>
                        <input type="text" name="st_user_rating" value="<?php st_user_fields_name( 'st_user_rating', 'Rating' ); ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input id="st_user_testi_text" type="checkbox" name="options[]" value="Testimonial Message" <?php isOptionChecked( 'Testimonial Message' ); ?>>
                        <label for="st_user_testi_text"><?php _e('Testimonial Message', 'ktsttestimonial'); ?></label>
                    </td>
                    <td>
                        <input type="text" name="st_user_testi_text" value="<?php st_user_fields_name( 'st_user_testi_text', 'Testimonial Message' ); ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input id="st_user_categories" type="checkbox" name="options[]" value="Categories" <?php isOptionChecked( 'Categories' ); ?>>
                        <label for="st_user_categories"><?php _e('Categories', 'ktsttestimonial'); ?></label>
                    </td>
                    <td><input type="text" name="st_user_categories" value="<?php st_user_fields_name( 'st_user_categories', 'Categories' ); ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input id="st_user_logo_img" type="checkbox" name="options[]" value="User's Image/Logo" <?php isOptionChecked( "User's Image/Logo" ); ?>>
                        <label for="st_user_logo_img"><?php _e('User\'s Image/Logo', 'ktsttestimonial'); ?></label>
                    </td>
                    <td>
                        <input type="text" name="st_user_logo_img" value="<?php st_user_fields_name( 'st_user_logo_img', "User's Image/Logo" ); ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input id="st_user_calculate" type="checkbox" name="options[]" value="Calculate" <?php isOptionChecked( "Calculate" ); ?>>
                        <label for="st_user_calculate"><?php _e('User\'s Captcha', 'ktsttestimonial'); ?></label>
                    </td>
                    <td>
                        <input type="text" name="st_user_calculate" value="<?php st_user_fields_name( 'st_user_calculate', "Calculate" ); ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="post_status"><?php _e('Select post status', 'ktsttestimonial');?></label>
                    </td>
                    <td>
                        <select id="post_status" name="post_status">
                            <option value="draft" <?php if ( isset( $post_status ) && $post_status == 'draft' ) echo 'selected'; ?>><?php _e('Draft', 'ktsttestimonial'); ?></option>
                            <option value="pending" <?php if ( isset( $post_status ) && $post_status == 'pending' ) echo 'selected'; ?>><?php _e('Pending', 'ktsttestimonial'); ?></option>
                            <option value="publish" <?php if ( isset( $post_status ) && $post_status == 'publish' ) echo 'selected'; ?>><?php _e('Publish', 'ktsttestimonial'); ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="st_user_submit_btn_text"><?php _e('Submit button text', 'ktsttestimonial'); ?></label>
                    </td>
                    <td>
                        <input id="st_user_submit_btn_text" type="text" name="st_user_submit_btn_text" value="<?php st_user_fields_name( 'st_user_submit_btn_text', "Submit Testimonial" ); ?>">
                    </td>
                </tr>
            </table>
            <h3> <?php _e('Testimonial Error and success messages for frontend users', 'ktsttestimonial'); ?></h3>
            <table>
                <tr>
                    <td>
                        <label for="save_success_text"><?php _e('Data saved success message', 'ktsttestimonial'); ?></label>
                    </td>
                    <td>
                        <textarea id="save_success_text" rows="1" cols="50" name="save_success_text"><?php echo st_user_retrive_messages( 'save_success_text', 'Thank you for your valuable comments. Stay with us.' ); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="save_error_text"><?php _e('Data saved error message', 'ktsttestimonial'); ?></label>
                    </td>
                    <td>
                        <textarea id="save_error_text" rows="1" cols="50" name="save_error_text"><?php echo st_user_retrive_messages( 'save_error_text', 'Please fill-up all the info again.' ); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="file_mishmatch_text"><?php _e('File type mismatch message', 'ktsttestimonial'); ?></label>
                    </td>
                    <td>
                        <textarea id="file_mishmatch_text" rows="1" cols="50" name="file_mishmatch_text"><?php echo st_user_retrive_messages( 'file_mishmatch_text', 'Only jpg, png and jpeg is accepted. Please try again.' ); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="calc_error_text"><?php _e('Calculation error message', 'ktsttestimonial'); ?></label>
                    </td>
                    <td>
                        <textarea id="calc_error_text" rows="1" cols="50" name="calc_error_text"><?php echo st_user_retrive_messages( 'calc_error_text', 'Calculation is incorrect. Please try again.' ); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="submit" class="button button-primary" name="save_btn" value="Save Changes">
                    </td>
                </tr>
            </table>
        </form>
    </div>
<?php } ?>