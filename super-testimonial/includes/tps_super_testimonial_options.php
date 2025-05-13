<?php 
	if ( ! defined( 'ABSPATH' ) ) {
	    exit;
	}
?>

<div class="wraper doc-suport">
    <div class="doc-support-header">
        <h1><?php echo esc_html__( 'Super Testimonial V-', 'ktsttestimonial' ) . TPS_TESTIMONIAL_VERSION; ?></h1>
        <p><?php esc_html_e( 'Do you have any questions or need assistance? We\'re here to help!', 'ktsttestimonial' ); ?> </p>
    </div>

    <div class="tps-tabs">
        <ul class="tps-tab-menu">
            <li class="tps-tab-item active" data-tab="whats-new"><?php esc_html_e('What\'s New', 'ktsttestimonial'); ?></li>
            <li class="tps-tab-item" data-tab="need-help"><?php esc_html_e('Need Help', 'ktsttestimonial'); ?></li>
        </ul>
    </div>

    <div class="tps-tab-content">
        <!-- What's New Section -->
        <div class="tps-tab-panel active" id="whats-new">
            <h2><?php esc_html_e('Latest Updates - 16 April 2025', 'ktsttestimonial'); ?></h2>
            <ul>
                <li># <?php esc_html_e('Performance Improvements.', 'ktsttestimonial'); ?></li>
                <li># <?php esc_html_e('Bug Fixes and UI Enhancements.', 'ktsttestimonial'); ?></li>
                <li># <?php esc_html_e('Fix Metabox value Warning Issue.', 'ktsttestimonial'); ?></li>
                <li># <?php esc_html_e('Fix CSS Issue.', 'ktsttestimonial'); ?></li>
            </ul>
            <h2><?php esc_html_e('Updates - 13 February 2025', 'ktsttestimonial'); ?></h2>
            <p><?php esc_html_e('Here are the latest features and improvements we have added.', 'ktsttestimonial'); ?></p>
            <h2><?php esc_html_e('Front-End Testimonial Submission Form :', 'ktsttestimonial'); ?></h2>
            <ul>
                <li># <?php esc_html_e('The Front-End Testimonial Submission Form allows users to submit their testimonials easily without accessing the WordPress backend. This feature is available in the free version of the plugin and provides a convenient way for your visitors to leave feedback.', 'ktsttestimonial'); ?>
                </li>
                <li><img src="<?php echo plugin_dir_url( __FILE__ ) . 'admin/img/front-end-submission-form.png'; ?>" alt="Front-End Testimonial Submission Form" /></li>
                <li># <?php esc_html_e('Added Testimonial Rating Style Option', 'ktsttestimonial'); ?></li>
                <li># <?php esc_html_e('Performance Improvements', 'ktsttestimonial'); ?></li>
                <li># <?php esc_html_e('Bug Fixes and UI Enhancements', 'ktsttestimonial'); ?></li>
                <li># <?php esc_html_e('Fix Stored Cross-Site Scripting Issue', 'ktsttestimonial'); ?></li>
                <li># <?php esc_html_e('Fix CSS Issue', 'ktsttestimonial'); ?></li>
                <li># <?php esc_html_e('Fix spelling mistakes.', 'ktsttestimonial'); ?></li>
            </ul>
        </div>

        <!-- Need Help Section -->
        <div class="tps-tab-panel" id="need-help">
            <h2><?php esc_html_e('Need Help?', 'ktsttestimonial'); ?></h2>
            <p><?php esc_html_e('Find answers to your questions or contact our support team.', 'ktsttestimonial'); ?></p>
            <div class="doc-support-content">
                <ul class="items-area">
                    <li class="list-item-help">
                        <h3><?php esc_html_e( 'Check Documentation', 'ktsttestimonial' ); ?></h3>
                        <p><?php esc_html_e( 'We developed plugins by maintaining WordPress standards. Our docs will help you to understand the basic & advanced usage.', 'ktsttestimonial' ); ?></p>
                        <div class="tps-btn">
                            <a target="_blank" href="<?php echo esc_url( 'https://themepoints.com/testimonials/docs/super-testimonial/overview/' ); ?>">
                                <?php esc_html_e( 'Documentation', 'ktsttestimonial' ); ?>
                            </a>
                        </div>
                    </li>
                    <li class="list-item-help">
                        <h3><?php esc_html_e( 'Get Customer Support', 'ktsttestimonial' ); ?></h3>
                        <p><?php esc_html_e( 'We\'re delighted to assist you with any questions or issues you may have regarding our plugin. We eagerly anticipate the opportunity to help you.', 'ktsttestimonial' ); ?></p>
                        <div class="tps-btn">
                            <a target="_blank" href="<?php echo esc_url( 'https://www.themepoints.com/questions-answer/' ); ?>">
                                <?php esc_html_e( 'Get Support', 'ktsttestimonial' ); ?>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="doc-support-content">
        <ul class="items-area">
            <li class="list-item">
                <h3><?php esc_html_e( 'Show Your Love', 'ktsttestimonial' ); ?></h3>
                <p><?php esc_html_e( 'We would greatly appreciate it if you could spare a moment to rate and review our plugin. Your feedback is invaluable to us as it helps us enhance and deliver the best possible experience for our customers.', 'ktsttestimonial' ); ?></p>
                <div class="tps-btn">
                    <a target="_blank" href="<?php echo esc_url( 'https://wordpress.org/support/plugin/super-testimonial/reviews/' ); ?>">
                        <?php esc_html_e( 'Rate Us Now', 'ktsttestimonial' ); ?>
                    </a>
                </div>
            </li>
            <li class="list-item">
                <h3><?php esc_html_e( 'Buy Us A Coffee', 'ktsttestimonial' ); ?></h3>
                <p><?php esc_html_e( 'We hope you\'re enjoying our plugin! We put a lot of effort into providing the best experience possible. If you\'re feeling generous and would like to show your appreciation, we\'d be thrilled if you could consider buying us a coffee as a way of saying thank you.', 'ktsttestimonial' ); ?></p>
                <div class="tps-btn">
                    <a target="_blank" href="<?php echo esc_url( 'https://themepoints.com/testimonials/' ); ?>">
                        <?php esc_html_e( 'Donate Now', 'ktsttestimonial' ); ?>
                    </a>
                </div>
            </li>
        </ul>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const tabs = document.querySelectorAll(".tps-tab-item");
            const panels = document.querySelectorAll(".tps-tab-panel");

            tabs.forEach(tab => {
                tab.addEventListener("click", function() {
                    // Remove active class from all tabs
                    tabs.forEach(t => t.classList.remove("active"));
                    // Hide all panels
                    panels.forEach(panel => panel.classList.remove("active"));

                    // Add active class to clicked tab
                    this.classList.add("active");
                    // Show the corresponding content panel
                    document.getElementById(this.dataset.tab).classList.add("active");
                });
            });
        });
    </script>
</div>

<style>
.wraper.doc-suport{margin:10px 20px 0 2px;background-color:#fff;padding:30px;border-radius:10px;box-shadow:0 2px 5px rgba(0,0,0,.1);max-width:1140px}.doc-support-header{background-image:linear-gradient(to right,#495aff 0,#0acffe 100%);padding:50px;margin-bottom:50px;border-radius:20px}.wraper.doc-suport h1{color:#fff;font-size:30px;font-weight:700;line-height:1.2;margin:0;padding:0}.doc-support-header p{color:#fff;font-size:18px;font-weight:500;text-transform:capitalize;margin-bottom:0}ul.items-area{display:flex;flex-wrap:wrap;justify-content:center;margin-left:-15px;margin-right:-15px}.doc-support-content{border-radius:10px;column-count:2;column-gap:20px}.doc-support-content .items-area{list-style-type:none;padding:0;margin:0}.doc-support-content .list-item{margin-bottom:20px;background:#fff;color:#fff;padding:30px;border-radius:10px;box-shadow:0 15px 40px 0 rgba(0,0,0,.08);min-height:175px;display:flex;flex-direction:column;justify-content:center}.doc-support-content .list-item h3{font-size:20px;color:#333;margin-top:0;margin-bottom:5px}.doc-support-content .list-item p{color:#333;font-size:15px}.tps-btn a{display:inline-flex;font-size:15px;font-weight:400;margin-top:0000;padding:7px 15px;box-shadow:none;background:#0acffe;color:#fff;text-decoration:none;outline:0;border-radius:7px}@media screen and (max-width:767px){.doc-support-header{padding:40px}.doc-support-content{column-count:1}.doc-support-content .list-item{width:100%}}.tps-tabs{margin-bottom:20px}.tps-tab-menu{display:flex;border-bottom:0;padding:0;list-style:none}.tps-tab-item{padding:10px 15px;cursor:pointer;font-weight:700;color:#555}.tps-tab-item.active{border-bottom:3px solid #485cff;color:#485cff}.tps-tab-panel{display:none;padding:20px;background:#fff;border:1px solid #485cff;margin-top:10px;margin-bottom:50px}.tps-tab-panel ul li{font-size:14px}.tps-tab-panel.active{display:block}
</style>