<?php

if( !defined( 'ABSPATH' ) ){
    exit;
}

if ( $tp_testimonial_theme_style == 2 || $tp_testimonial_theme_style == 3 ) { ?>

<?php }else { ?>
	
	<style type="text/css">
		.testimonial-<?php echo esc_attr( $postid ); ?> {
			text-align: center;
			<?php if ( $tp_show_item_bg_option == 1 ) { ?>
                background: <?php echo esc_attr( $tp_item_bg_color ); ?>;
                padding: <?php echo intval( $tp_item_padding ); ?>px;
			<?php } ?>
		}
		.testimonial-<?php echo esc_attr( $postid ); ?> .testimonial-theme4-thumb {
			width: 100px;
			height: 100px;
			border-radius: <?php echo esc_attr( $tp_img_border_radius ); ?>;
			border: <?php echo intval( $tp_imgborder_width_option ); ?>px solid <?php echo esc_attr( $tp_imgborder_color_option ); ?>;
			display: inline-block;
			margin-top: 0px;
			overflow: hidden;
			box-shadow:0 2px 6px rgba(0, 0, 0, 0.15);
			margin: 0 auto;
		}
		.testimonial-<?php echo esc_attr( $postid ); ?> .testimonial-theme4-thumb img {
			width: 100%;
			height: 100%;
		}
		.testimonial-<?php echo esc_attr( $postid ); ?> .testimonial-title-<?php echo esc_attr( $postid ); ?> h3{
            color: <?php echo esc_attr( $tp_title_color_option ); ?>;
            font-size: <?php echo intval( $tp_title_fontsize_option ); ?>px;
			font-style: normal;
			margin: 10px 0px 10px;
		}
		.testimonial-<?php echo esc_attr( $postid ); ?> .testimonial-theme4-desc {
            color: <?php echo esc_attr( $tp_content_color ); ?>;
            font-size: <?php echo intval( $tp_content_fontsize_option ); ?>px;
			text-align: center;
			font-style: italic;
			margin: 15px 0 15px;
		}
		.testimonial-<?php echo esc_attr( $postid ); ?> .testimonial-author-name {
            color: <?php echo esc_attr( $tp_name_color_option ); ?>;
            font-size: <?php echo intval( $tp_name_fontsize_option ); ?>px;
            text-transform: <?php echo esc_attr( $tp_name_font_case ); ?>;
            font-style: <?php echo esc_attr( $tp_name_font_style ); ?>;
			margin-bottom: 5px;
			line-height: 1;
		}
		.testimonial-<?php echo esc_attr( $postid ); ?> .testimonial-author-name:after {
		    content: "";
		    width: 30px;
		    display: block;
		    margin: 10px auto;
		    border: 1px solid <?php echo esc_attr( $tp_rating_color ); ?>;
		    margin-top: 15px;
		}
		.testimonial-<?php echo esc_attr( $postid ); ?> .testimonial-author-desig a,
		.testimonial-<?php echo esc_attr( $postid ); ?> .testimonial-author-desig {
            font-size: <?php echo intval( $tp_desig_fontsize_option ); ?>px;
            color: <?php echo esc_attr( $tp_designation_color_option ); ?>;
            text-transform: <?php echo esc_attr( $tp_designation_case ); ?>;
            font-style: <?php echo esc_attr( $tp_designation_font_style ); ?>;
		}
		.testimonial-<?php echo esc_attr( $postid ); ?> .testimonial-rating i.fa {
			padding:0px 3px;
            color: <?php echo esc_attr( $tp_rating_color ); ?>;
            font-size: <?php echo intval( $tp_rating_fontsize_option ); ?>px;
		}

		<?php if ( $navigation_align == 'left' || $navigation_align == 'right' ) { ?>
			#testimonial-slider-<?php echo esc_attr( $postid ); ?> {
				padding-top: 50px;
			}
		<?php } ?>
		#testimonial-slider-<?php echo esc_attr( $postid ); ?> .owl-nav {}
		#testimonial-slider-<?php echo esc_attr( $postid ); ?> .owl-nav .owl-next,
		#testimonial-slider-<?php echo esc_attr( $postid ); ?> .owl-nav .owl-prev {
			position: absolute;
			<?php if ( $navigation_align == 'right' ) { ?>
				top: 0px;
				right: 0;
				left: auto;
			<?php } elseif ( $navigation_align == 'left' ) { ?>
				top: 0px;
				right: auto;
				left: 0;
			<?php } ?>
			color: <?php echo esc_attr( $nav_text_color ); ?>;
			text-align:center;
			font-size: 15px;
			margin: 2px;
			padding: 0;
			width: 30px;
			height: 30px;
			line-height: 26px;
			background: <?php echo esc_attr( $nav_bg_color ); ?>;
			display: inline-block;
			cursor: pointer;
			border-radius: 0;
			border: 1px solid <?php echo esc_attr( $nav_bg_color ); ?>;
		}
		<?php if ( $navigation_align == 'right' ) { ?>
			#testimonial-slider-<?php echo esc_attr( $postid ); ?> .owl-nav .owl-prev {
				right: 35px;
		}
		<?php } elseif ( $navigation_align == 'left' ) { ?>
			#testimonial-slider-<?php echo esc_attr( $postid ); ?> .owl-nav .owl-next {
				left: 35px;
			}
		<?php } ?>
		<?php if ( $navigation_align == 'center' ) { ?>
			#testimonial-slider-<?php echo esc_attr( $postid ); ?> .owl-nav .owl-prev{
			    top: 50%;
			    transform: translateY(-50%);
			    left:0;
			}
			#testimonial-slider-<?php echo esc_attr( $postid ); ?> .owl-nav .owl-next{
			    top: 50%;
			    transform: translateY(-50%);
			    right: 0;
			}
		<?php } ?>
		#testimonial-slider-<?php echo esc_attr( $postid ); ?> .owl-nav .owl-prev{}
		#testimonial-slider-<?php echo esc_attr( $postid ); ?> .owl-nav .owl-next:hover,
		#testimonial-slider-<?php echo esc_attr( $postid ); ?> .owl-nav .owl-prev:hover {
			color: <?php echo esc_attr( $nav_text_color_hover ); ?>;
			background: <?php echo esc_attr( $nav_bg_color_hover ); ?>;
			border: 1px solid <?php echo esc_attr( $nav_bg_color_hover ); ?>;
		}
		#testimonial-slider-<?php echo esc_attr( $postid ); ?> .owl-dots {
		    display: block;
		  	text-align: center;
		    width: 100%;
		    overflow: hidden;
		    margin: 0;
		    margin-top: 10px;
		    padding: 0;
		}
		#testimonial-slider-<?php echo esc_attr( $postid ); ?> .owl-dots .owl-dot {
			width: 12px;
			height: 12px;
			display: inline-block;
			position: relative;
			background: <?php echo esc_attr( $pagination_bg_color ); ?>;
			margin: 0px 4px;
			border-radius: 0;
		}
		#testimonial-slider-<?php echo esc_attr( $postid ); ?> .owl-dots .owl-dot.active {
			background: <?php echo esc_attr( $pagination_bg_color_active ); ?>;
		}
	</style>

	<div id="testimonial-slider-<?php echo esc_attr( $postid ); ?>" class="owl-carousel testimonial-slider" data-postid="<?php echo esc_attr( $postid ); ?>" data-items="<?php echo intval( $item_no ); ?>" data-loop="<?php echo esc_attr( $loop ); ?>" data-margin="<?php echo intval( $margin ); ?>" data-autoplay="<?php echo esc_attr( $autoplay ); ?>" data-autoplay-speed="<?php echo intval( $autoplay_speed ); ?>" data-autoplay-timeout="<?php echo intval( $autoplaytimeout ); ?>" data-stop-hover="<?php echo esc_attr( $stop_hover ); ?>" data-itemsmobile="<?php echo intval( $itemsmobile ); ?>" data-itemsdesktopsmall="<?php echo intval( $itemsdesktopsmall ); ?>" data-itemsdesktop="<?php echo intval( $itemsdesktop ); ?>">
	<?php 
	// Creating a new side loop
	while ( $query->have_posts() ) : $query->the_post();
		$client_main_title       = get_post_meta( get_the_ID(), 'main_title', true );
		$client_name_value       = get_post_meta( get_the_ID(), 'name', true );
		$link_value              = get_post_meta( get_the_ID(), 'position', true );
		$company_value           = get_post_meta( get_the_ID(), 'company', true );
		// $company_url             = get_post_meta( get_the_ID(), 'company_website', true );
		$company_url             = esc_url( get_post_meta( get_the_ID(), 'company_website', true ) );
		$company_url_target      = get_post_meta( get_the_ID(), 'company_link_target', true );
		$testimonial_information = get_post_meta( get_the_ID(), 'testimonial_text', true );
		$company_ratings_target  = get_post_meta( get_the_ID(), 'company_rating_target', true );
		// $tp_image_sizes          = get_post_meta( $postid, 'tp_image_sizes', true );
		$tp_image_sizes          = esc_attr( get_post_meta( $postid, 'tp_image_sizes', true ) );

		?>
			<div class="testimonial-<?php echo esc_attr( $postid ); ?>">
				<?php if( has_post_thumbnail() ){ ?>
					<div class="testimonial-theme4-thumb">
						<?php the_post_thumbnail( $tp_image_sizes); ?>
					</div>
				<?php }else{ ?>
					<div class="testimonial-theme4-thumb">
						<img src="<?php echo esc_url( get_avatar_url( -1 ) ); ?>">
					</div>
				<?php } ?>
				<?php if( !empty( $client_main_title ) ){ ?>
					<div class="testimonial-title-<?php echo esc_attr( $postid ); ?>">
						<h3><?php echo esc_html( $client_main_title ); ?></h3>
					</div>
				<?php } ?>
				<div class="testimonial-theme4-desc"><?php echo wp_kses_post( $testimonial_information ); ?></div>
				<h4 class="testimonial-author-name"><?php echo esc_html( $client_name_value ); ?></h4>
				<?php if ( !empty( $company_url ) || !empty( $link_value ) ) { ?>
					<div class="testimonial-author-desig">
						<?php if( !empty( $company_url ) ){ ?>
							<a target="<?php echo esc_attr( $company_url_target ); ?>" href="<?php echo esc_url( $company_url ); ?>">
								<?php echo esc_html( $link_value ); ?>
							</a>
						<?php }else{ ?>
							<?php echo esc_html( $link_value ); ?>
						<?php } ?>
					</div>
				<?php } ?>
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
			</div>
			<?php endwhile; ?>
		</div>
	<?php wp_reset_postdata();
}