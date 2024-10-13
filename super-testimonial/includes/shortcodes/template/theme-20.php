<?php

    if( !defined( 'ABSPATH' ) ){
        exit;
    }

	?>

	<style type="text/css">
		.testimonial-list-area-<?php echo esc_attr( $postid ); ?>{
			display: block;
			overflow: hidden;
		}
		.testimonial-list-<?php echo esc_attr( $postid ); ?>{
			padding:5px;
			margin-bottom:15px;
		}
		.testimonial-list-<?php echo esc_attr( $postid ); ?>:last-child{
			margin-bottom:0px;
		}
		.testimonial-list-<?php echo esc_attr( $postid ); ?> .testimonial-author-name {
			background: url(<?php echo plugins_url('h3.png', __FILE__); ?>) no-repeat center;
			text-align:center;
            color: <?php echo esc_attr( $tp_name_color_option ); ?>;
            font-size: <?php echo intval( $tp_name_fontsize_option ); ?>px;
            text-transform: <?php echo esc_attr( $tp_name_font_case ); ?>;
            font-style: <?php echo esc_attr( $tp_name_font_style ); ?>;
			margin-bottom:15px;
		}
		.testimonial-list-<?php echo esc_attr( $postid ); ?> .testimonial-thumb {
			width: 100px;
			height: 100px;
			border-radius: <?php echo esc_attr( $tp_img_border_radius ); ?>;
			border: <?php echo intval( $tp_imgborder_width_option ); ?>px solid <?php echo esc_attr( $tp_imgborder_color_option ); ?>;
			overflow: hidden;
			float: left;
			margin-right:30px;
		}
		.testimonial-list-<?php echo esc_attr( $postid ); ?> .testimonial-thumb img {
			border-radius: <?php echo esc_attr( $tp_img_border_radius ); ?>;
			box-shadow: none;
			height: 100%;
			width: 100%;
		}
		.testimonial-list-<?php echo esc_attr( $postid ); ?> .testimonial-desc {
            color: <?php echo esc_attr( $tp_content_color ); ?>;
            font-size: <?php echo intval( $tp_content_fontsize_option ); ?>px;
			margin-bottom:15px;
			display: block;
			overflow: hidden;
		}
		.testimonial-list-<?php echo esc_attr( $postid ); ?> .testimonial-title-<?php echo esc_attr( $postid ); ?> h3{
            color: <?php echo esc_attr( $tp_title_color_option ); ?>;
            font-size: <?php echo intval( $tp_title_fontsize_option ); ?>px;
			font-style: normal;
			margin: 10px 0px 10px;
		}
		.testimonial-list-<?php echo esc_attr( $postid ); ?> .testimonial-desc:after {
		    content: "\f10e";
		    font-family: 'FontAwesome';
		    margin-left: 10px;
		}
		.testimonial-list-<?php echo esc_attr( $postid ); ?> .testimonial-desc:before {
			content: "\f10d";
			font-family: fontawesome;
			margin-right: 10px;
		}
		.testimonial-list-<?php echo esc_attr( $postid ); ?> .testimonial-theme20-info-profile{
			text-align:right;
			position: relative;
		}
		.testimonial-list-<?php echo esc_attr( $postid ); ?> .testimonial-author-desig a,
		.testimonial-list-<?php echo esc_attr( $postid ); ?> .testimonial-author-desig {
			display: block;
			overflow: hidden;
            font-size: <?php echo intval( $tp_desig_fontsize_option ); ?>px;
            color: <?php echo esc_attr( $tp_designation_color_option ); ?>;
            text-transform: <?php echo esc_attr( $tp_designation_case ); ?>;
            font-style: <?php echo esc_attr( $tp_designation_font_style ); ?>;
		}
		.testimonial-list-<?php echo esc_attr( $postid ); ?> .testimonial-links,
		.testimonial-list-<?php echo esc_attr( $postid ); ?> .testimonial-links a {
			color: <?php echo esc_attr( $tp_company_url_color ); ?>;
			display: block;
			font-size: 14px;
			outline: medium none;
			overflow: hidden;
			text-decoration: none;
		}
		.testimonial-list-<?php echo esc_attr( $postid ); ?> .testimonial-rating {
			display: block;
			overflow: hidden;
			padding:4px 0px;
		}
		.testimonial-list-<?php echo esc_attr( $postid ); ?> .testimonial-rating i.fa{
			padding:0px 3px;
            color: <?php echo esc_attr( $tp_rating_color ); ?>;
            font-size: <?php echo intval( $tp_rating_fontsize_option ); ?>px;
		}
	</style>

	<div class="testimonial-list-area-<?php echo esc_attr( $postid ); ?>">
		<?php	
		// Creating a new side loop
		while ( $query->have_posts() ) : $query->the_post();
		$client_main_title       = get_post_meta( get_the_ID(), 'main_title', true );
		$client_name_value       = get_post_meta(get_the_ID(), 'name', true);
		$link_value              = get_post_meta(get_the_ID(), 'position', true);
		$company_value           = get_post_meta(get_the_ID(), 'company', true);
		// $company_url             = get_post_meta(get_the_ID(), 'company_website', true);
		$company_url             = esc_url( get_post_meta( get_the_ID(), 'company_website', true ) );
		$company_url_target      = get_post_meta(get_the_ID(), 'company_link_target', true);
		$testimonial_information = get_post_meta(get_the_ID(), 'testimonial_text', true);
		$company_ratings_target  = get_post_meta(get_the_ID(), 'company_rating_target', true);
		// $tp_image_sizes          = get_post_meta( $postid, 'tp_image_sizes', true );
		$tp_image_sizes          = esc_attr( get_post_meta( $postid, 'tp_image_sizes', true ) );
		?>
		<div class="testimonial-list-<?php echo esc_attr( $postid ); ?>">
			<div class="testimonial-author-name"><?php echo esc_html( $client_name_value ); ?></div>
			<div class="testimonial-theme20-content">
				<?php if( has_post_thumbnail() ){ ?>
					<div class="testimonial-thumb">
						<?php the_post_thumbnail( $tp_image_sizes); ?>
					</div>
				<?php }else{ ?>
					<div class="testimonial-thumb">
						<img src="<?php echo esc_url( get_avatar_url( -1 ) ); ?>">
					</div>
				<?php } ?>
				<div class="testimonial-theme20-info-profile">
					<?php if( !empty( $client_main_title ) ){ ?>
						<div class="testimonial-title-<?php echo esc_attr( $postid ); ?>">
							<h3><?php echo esc_html( $client_main_title ); ?></h3>
						</div>
					<?php } ?>
					<div class="testimonial-desc"><?php echo wp_kses_post( $testimonial_information ); ?></div>

					<div class="testimonial-rating">
		                <?php for ( $i = 0; $i <= 4; $i++ ) {
		                    if ( $i < $company_ratings_target ) {
		                        $full = 'fa fa-star';
		                    } else {
		                        $full = 'fa fa-star-o';
		                    }
		                    echo '<i class="' . esc_attr( $full ) . '"></i>';
		                } ?>
			   		</div>
					<?php if ( !empty( $company_value ) || !empty( $company_url ) ) { ?>
						<div class="testimonial-links">
							<?php if( !empty( $company_url ) ){ ?>
								<a target="<?php echo esc_attr( $company_url_target ); ?>" href="<?php echo esc_url( $company_url ); ?>">
									<?php echo esc_html( $company_value ); ?>
								</a>
							<?php }else{ ?>
								<?php echo esc_html( $company_value ); ?>
							<?php } ?>
						</div>
					<?php } ?>
					<div class="testimonial-author-desig"><?php echo esc_html( $link_value ); ?></div>
				</div>
			</div>
		</div>
		<?php endwhile; wp_reset_postdata(); ?>
	</div>