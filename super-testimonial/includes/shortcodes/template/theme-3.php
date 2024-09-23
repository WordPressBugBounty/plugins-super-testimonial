<?php

if( !defined( 'ABSPATH' ) ){
    exit;
}

if ( $tp_testimonial_theme_style == 2 || $tp_testimonial_theme_style == 3 ) { ?>

<?php }else { ?>
	
	<style type="text/css">
		.testimonial-<?php echo esc_attr( $postid ); ?>{
			padding:0px 3px;
		}
		.testimonial-<?php echo esc_attr( $postid ); ?>{
			<?php if ( $tp_show_item_bg_option == 1 ) { ?>
				background: <?php echo $tp_item_bg_color; ?>;
				padding: <?php echo $tp_item_padding; ?>px;
			<?php } ?>
		}
		.testimonial-<?php echo esc_attr( $postid ); ?> .testimonial-theme3-desc {
		    padding: 20px;
		    background: <?php echo $tp_content_bg_color; ?>;
		    border: 1px solid #d3d3d3;
		    border-radius: 5px;
		    margin-bottom: 25px;
		    position: relative;
		}
		.testimonial-<?php echo esc_attr( $postid ); ?> .testimonial-theme3-desc p{
		    padding: 0px;
		    margin: 0px;
			color:<?php echo $tp_content_color ?>;
			font-size:<?php echo $tp_content_fontsize_option ?>px;
			text-align: center;
		}
		.testimonial-<?php echo esc_attr( $postid ); ?> .testimonial-theme3-desc:before {
		    content: '';
		    border: 12px solid transparent;
		    position: absolute;
		    border-top-color: #d3d3d3;
		    height: 20px;
		    bottom: -24px;
		    left:30px;
		}
		.testimonial-<?php echo esc_attr( $postid ); ?> .testimonial-theme3-desc:after {
			content: '';
		    border: 12px solid transparent;
		    position: absolute;
		    border-top-color: <?php echo $tp_content_bg_color; ?>;
		    height: 20px;
		    bottom: -23px;
		    left:30px;
		}
		.testimonial-<?php echo esc_attr( $postid ); ?> .testimonial-theme3-content {
			display: flex;
		    align-self: flex-start;
		}
		.testimonial-<?php echo esc_attr( $postid ); ?> .testimonial-theme3-thumb {
		    display: inline-block;
		    width: 100px;
		    height: 100px;
		    border-radius: 50px;
		    margin-right: 20px;
		}
		.testimonial-<?php echo esc_attr( $postid ); ?> .testimonial-theme3-thumb img{
			border-radius: <?php echo $tp_img_border_radius ?>;
			border: <?php echo $tp_imgborder_width_option ?>px solid <?php echo $tp_imgborder_color_option ?>;
			width: 100%;
			height: 100%;
		}
		.testimonial-<?php echo esc_attr( $postid ); ?> .testimonial-theme3-info-profile {
		    margin-top: 15px;
		}
		.testimonial-<?php echo esc_attr( $postid ); ?> .testimonial-author-name {
			color:<?php echo $tp_name_color_option; ?>;
			font-size:<?php echo $tp_name_fontsize_option; ?>px;
			text-transform: <?php echo $tp_name_font_case; ?>;
			font-style: <?php echo $tp_name_font_style; ?>;
			margin-bottom: 5px;
			line-height: 1;
		}
		.testimonial-<?php echo esc_attr( $postid ); ?> .testimonial-author-desig a,
		.testimonial-<?php echo esc_attr( $postid ); ?> .testimonial-author-desig {
			font-size:<?php echo $tp_desig_fontsize_option; ?>px;
			color: <?php echo $tp_designation_color_option; ?>;
			text-transform: <?php echo $tp_designation_case; ?>;
			font-style: <?php echo $tp_designation_font_style; ?>;
		}
		.testimonial-<?php echo esc_attr( $postid ); ?> .testimonial-rating i.fa {
			padding:0px 3px;
		  	color:<?php echo $tp_rating_color; ?>;
		  	font-size: <?php echo $tp_rating_fontsize_option; ?>px;
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
			color: <?php echo $nav_text_color; ?>;
			text-align:center;
			font-size: 15px;
			margin: 2px;
			padding: 0;
			width: 30px;
			height: 30px;
			line-height: 26px;
			background: <?php echo $nav_bg_color; ?> none repeat scroll 0 0;
			display: inline-block;
			cursor: pointer;
			border-radius: 0;
			border: 1px solid <?php echo $nav_bg_color; ?>;
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
			color: <?php echo $nav_text_color_hover; ?>;
			background: <?php echo $nav_bg_color_hover; ?> none repeat scroll 0 0;
			border: 1px solid <?php echo $nav_bg_color_hover; ?>;
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
			background: <?php echo $pagination_bg_color; ?>;
			margin: 0px 4px;
			border-radius: 0;
		}
		#testimonial-slider-<?php echo esc_attr( $postid ); ?> .owl-dots .owl-dot.active {
			background: <?php echo $pagination_bg_color_active; ?>;
		}
	</style>

	<script type="text/javascript">
		jQuery(document).ready(function($){
			$("#testimonial-slider-<?php echo esc_attr( $postid ); ?>").owlCarousel({
				lazyLoad: true,
				items:<?php echo $item_no ?>,
				loop: <?php echo $loop ?>,
				margin: <?php echo $margin ?>,
				autoplay: <?php echo $autoplay ?>,
				autoplaySpeed: <?php echo $autoplay_speed ?>,
				autoplayTimeout: <?php echo $autoplaytimeout ?>,
				autoplayHoverPause: <?php echo $stop_hover ?>,
				nav : true,
				dots: true,
				navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
				smartSpeed: 450,
				clone:true,
				responsive:{
					0:{
					  items:<?php echo $itemsmobile ?>,
					},
					678:{
					  items:<?php echo $itemsdesktopsmall ?>,
					},
					980:{
					  items:<?php echo $itemsdesktop ?>,
					},
					1199:{
					  items:<?php echo $item_no ?>,
					}
				}
			});
		});
	</script>

	<div id="testimonial-slider-<?php echo esc_attr( $postid ); ?>" class="owl-carousel">
		<?php
		// Creating a new side loop
		while ( $query->have_posts() ) : $query->the_post();
			$client_name_value       = get_post_meta(get_the_ID(), 'name', true);
			$link_value              = get_post_meta(get_the_ID(), 'position', true);
			$company_value           = get_post_meta(get_the_ID(), 'company', true);
			$company_url             = get_post_meta(get_the_ID(), 'company_website', true);
			$company_url_target      = get_post_meta(get_the_ID(), 'company_link_target', true);
			$testimonial_information = get_post_meta(get_the_ID(), 'testimonial_text', true);
			$company_ratings_target  = get_post_meta(get_the_ID(), 'company_rating_target', true);
			$tp_image_sizes          = get_post_meta( $postid, 'tp_image_sizes', true );
			?>
			<div class="testimonial-<?php echo esc_attr( $postid ); ?>">
				<div class="testimonial-theme3-desc">
					<p><?php echo wp_kses_post( $testimonial_information ); ?></p>
				</div>
				<div class="testimonial-theme3-content">
					<?php if( has_post_thumbnail() ){ ?>
						<div class="testimonial-theme3-thumb">
							<?php the_post_thumbnail( $tp_image_sizes); ?>
						</div>
					<?php }else{ ?>
						<div class="testimonial-theme3-thumb">
							<img src="<?php echo esc_url( $imgurl = get_avatar_url( -1 ) ); ?>">
						</div>
					<?php } ?>
					<div class="testimonial-theme3-info-profile">
						<h4 class="testimonial-author-name"><?php echo esc_attr( $client_name_value ); ?></h4>
						<?php if ( !empty( $link_value ) || !empty( $company_url ) ) { ?>
							<div class="testimonial-author-desig">
								<?php if( !empty( $company_url ) ){ ?>
									<a target="<?php echo $company_url_target; ?>" href="<?php echo esc_url( $company_url ); ?>">
										<?php echo esc_html( $link_value ); ?>
									</a>
								<?php }else{ ?>
									<?php echo esc_html( $link_value ); ?>
								<?php } ?>
							</div>
						<?php } ?>
						<div class="testimonial-rating">
			                <?php for( $i=0; $i <=4 ; $i++ ) {
					   			   	if ($i < $company_ratings_target) {
					   			      	$full = 'fa fa-star';
					   			    } else {
					   			      	$full = 'fa fa-star-o';
					   			    }
					   			   	echo "<i class=\"$full\"></i>";
					   			}
					   		?>
				   		</div>
					</div>
				</div>
			</div>			
		<?php endwhile; wp_reset_postdata(); ?>
	</div>
	<?php
}