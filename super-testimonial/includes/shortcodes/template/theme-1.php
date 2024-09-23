<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( $tp_testimonial_theme_style == 2 || $tp_testimonial_theme_style == 3 ) { ?>

<?php }else { ?>
	
	<style type="text/css">
		.testimonial-<?php echo esc_attr( $postid ); ?> {
			text-align: center;
			<?php if ( $tp_show_item_bg_option == 1 ) { ?>
				background: <?php echo $tp_item_bg_color; ?>;
				padding: <?php echo $tp_item_padding; ?>px;
			<?php } ?>
		}
		.testimonial-<?php echo esc_attr( $postid ); ?> .testimonial-thumb-<?php echo esc_attr( $postid ); ?> {
			width: 85px;
			height: 85px;
			border-radius: <?php echo $tp_img_border_radius; ?>;
			margin: 0 auto 15px;
			border: <?php echo $tp_imgborder_width_option; ?>px solid <?php echo $tp_imgborder_color_option; ?>;
			overflow: hidden;
			display: inline-block;
		}
		.testimonial-<?php echo esc_attr( $postid ); ?> .testimonial-thumb-<?php echo esc_attr( $postid ); ?> img {
			border-radius: 0;
			box-shadow: none;
			height: 100%;
			width: 100%;
		}
		.testimonial-<?php echo esc_attr( $postid ); ?> .testimonial-desc-<?php echo esc_attr( $postid ); ?> {
			color:<?php echo $tp_content_color; ?>;
			font-size:<?php echo $tp_content_fontsize_option; ?>px;
			font-style: italic;
			margin-bottom: 15px;
		}
		.testimonial-<?php echo esc_attr( $postid ); ?> .testimonial-rating-<?php echo esc_attr( $postid ); ?>{
			display: block;
			overflow: hidden;
			padding:3px 0px;
		}
		.testimonial-<?php echo esc_attr( $postid ); ?> .testimonial-rating-<?php echo esc_attr( $postid ); ?> i.fa{
			padding:0px 3px;
		  	color:<?php echo $tp_rating_color; ?>;
		  	font-size: <?php echo $tp_rating_fontsize_option; ?>px;
		}
		.testimonial-<?php echo esc_attr( $postid ); ?> .testimonial-links-<?php echo esc_attr( $postid ); ?>,
		.testimonial-<?php echo esc_attr( $postid ); ?> .testimonial-links-<?php echo esc_attr( $postid ); ?> a {
			color: <?php echo $tp_company_url_color; ?>;
			display: block;
			font-size: 14px;
			outline: medium none;
			overflow: hidden;
			text-decoration: none;
		}
		.testimonial-<?php echo esc_attr( $postid ); ?> .testimonial-info-profile-<?php echo esc_attr( $postid ); ?> {
			margin:0;
			margin-top: 5px;
		}
		.testimonial-<?php echo esc_attr( $postid ); ?> .testimonial-info-profile-<?php echo esc_attr( $postid ); ?> ul{
			margin:0;
			padding:0;
			list-style:none;
		}
		.testimonial-<?php echo esc_attr( $postid ); ?> .testimonial-info-profile-<?php echo esc_attr( $postid ); ?> ul li{
			display: inline-block;
		}
		.testimonial-<?php echo esc_attr( $postid ); ?> .testimonial-info-profile-<?php echo esc_attr( $postid ); ?> ul li:before {
		    content: "|";
		    padding: 0 10px;
		    padding-left: 5px;
		}
		.testimonial-<?php echo esc_attr( $postid ); ?> .testimonial-info-profile-<?php echo esc_attr( $postid ); ?> ul li:first-child:before {
		    content: none;
		}
		.testimonial-<?php echo esc_attr( $postid ); ?> .testimonial-author-name-<?php echo esc_attr( $postid ); ?>{
			color:<?php echo $tp_name_color_option; ?>;
			font-size:<?php echo $tp_name_fontsize_option; ?>px;
			margin-right: 0px;
			text-transform: <?php echo $tp_name_font_case; ?>;
			font-style: <?php echo $tp_name_font_style; ?>;
		}
		.testimonial-<?php echo esc_attr( $postid ); ?> .testimonial-author-desig-<?php echo esc_attr( $postid ); ?> {
			display: inline-block;
			font-size:<?php echo $tp_desig_fontsize_option; ?>px;
			color: <?php echo $tp_designation_color_option; ?>;
			text-transform: <?php echo $tp_designation_case; ?>;
			font-style: <?php echo $tp_designation_font_style; ?>;
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
		jQuery( document ).ready( function( $ ) {
			$( "#testimonial-slider-<?php echo esc_attr( $postid ); ?>" ).owlCarousel( {
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
			} );
		} );
	</script>

	<div id="testimonial-slider-<?php echo esc_attr( $postid ); ?>" class="owl-carousel">
		<?php
		// Creating a new side loop
		while ( $query->have_posts() ) : $query->the_post();
			$client_name_value 			= get_post_meta( get_the_ID(), 'name', true );
			$link_value 				= get_post_meta( get_the_ID(), 'position', true );
			$company_value 				= get_post_meta( get_the_ID(), 'company', true );
			$company_url 				= get_post_meta( get_the_ID(), 'company_website', true );
			$company_url_target 		= get_post_meta( get_the_ID(), 'company_link_target', true );
			$testimonial_information 	= get_post_meta( get_the_ID(), 'testimonial_text', true );
			$company_ratings_target 	= get_post_meta( get_the_ID(), 'company_rating_target', true );
			$tp_image_sizes   			= get_post_meta( $postid, 'tp_image_sizes', true );
			?>
			<div class="testimonial-<?php echo esc_attr( $postid ); ?>">
					<?php if( has_post_thumbnail() ){ ?>
						<div class="testimonial-thumb-<?php echo esc_attr( $postid ); ?>">
							<?php the_post_thumbnail( $tp_image_sizes); ?>
						</div>
					<?php }else{ ?>
						<div class="testimonial-thumb-<?php echo esc_attr( $postid ); ?>">
							<img src="<?php echo esc_url( $imgurl = get_avatar_url( -1 ) ); ?>">
						</div>
					<?php } ?>
				<div class="testimonial-desc-<?php echo esc_attr( $postid ); ?>">
					<?php echo wp_kses_post( $testimonial_information ); ?>
				</div>
				<div class="testimonial-rating-<?php echo esc_attr( $postid ); ?>">
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
				<?php if ( !empty( $company_value ) || !empty( $company_url ) ) { ?>
					<div class="testimonial-links-<?php echo esc_attr( $postid ); ?>">
						<?php if( !empty( $company_url ) ){ ?>
							<a target="<?php echo esc_attr( $company_url_target ); ?>" href="<?php echo esc_url( $company_url ); ?>">
								<?php echo esc_html( $company_value ); ?>
							</a>
						<?php }else{ ?> 
							<?php echo esc_html( $company_value ); ?>
						<?php } ?>
					</div>
				<?php } ?>

				<div class="testimonial-info-profile-<?php echo esc_attr( $postid ); ?>">
					<ul>
						<li class="testimonial-author-name-<?php echo esc_attr( $postid ); ?>"><?php echo esc_html( $client_name_value ); ?></li>
						<?php if ( !empty( $link_value ) ) { ?>
							<li class="testimonial-author-desig-<?php echo esc_attr( $postid ); ?>"><?php echo esc_html( $link_value ); ?></li>
						<?php } ?>
					</ul>
				</div>
			</div>
		<?php endwhile; wp_reset_postdata(); ?>
	</div>
	<?php
}