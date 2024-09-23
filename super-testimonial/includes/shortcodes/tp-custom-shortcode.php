<?php

	if ( ! defined( 'ABSPATH' ) ) {
	    exit;
	}

	// Register Shortcode
	function tps_super_testimonials_shortcode_register($atts, $content=null) {
		extract(shortcode_atts( array(
			'category'       => '-1',
			'themes'         => 'theme1',
			'columns_number' => '2',
			'order_by'       => 'rand',
			'order'          => 'DESC',
			'number'         => '-1',
			'auto_play'      => 'true',
			'navigation'     => 'true',
			'stars_color'    => '#1a1a1a',
			'text_color'     => '#000000',
		), $atts));

		// 	query posts
		$args =	array ( 
			'post_type' => 'ktsprotype',
			'posts_per_page' => $number,
			'orderby' => $order_by,
			'order' => $order 
		);

		if($category > -1) {
			$args['tax_query'] = array(array('taxonomy' => 'ktspcategory','field' => 'id','terms' => $category ));
		}
		
		$output = '';
		
		$tstrndsk = rand(1,1000);

		$testimonials_query = new WP_Query( $args );

		if( esc_attr($themes) == "theme1" ){
			$output .= '<style type="text/css">
 			div#testimonial-slider-'.esc_attr( $themes ).' {
				display: block;
				overflow: hidden;
				padding-top: 10px;
			}
			.testimonial-'.esc_attr( $themes ).'{
				text-align: center;
			}
			.testimonial-'.esc_attr( $themes ).' .testimonial-thumb-'.esc_attr( $themes ).'{
				width: 85px;
				height: 85px;
				border-radius: 50%;
				margin: 0 auto 40px;
				border: 4px solid #eb7260;
				overflow: hidden;
			}
			.testimonial-'.esc_attr( $themes ).' .testimonial-thumb-'.esc_attr( $themes ).' img{
				width: 100%;
				height: 100%;
			    margin: 0;
			    padding: 0;
			}
			.testimonial-'.esc_attr( $themes ).' .testimonial-description-'.esc_attr( $themes ).'{
				color: '.esc_attr( $text_color).';
				font-size: 15px;
				font-style: italic;
				line-height: 24px;
				margin-bottom: 20px;
			}
			.testimonial-'.esc_attr( $themes ).' .testimonial-description-profiles-'.esc_attr( $themes ).'{
				margin:20px 0;
				text-align:center;
			}
			.testimonial-'.esc_attr( $themes ).' .testimonial-description-title-'.esc_attr( $themes ).'{
				font-size: 20px;
				color: #eb7260;
				margin-right: 20px;
				text-transform: capitalize;
			}
			.testimonial-'.esc_attr( $themes ).' .testimonial-description-title-'.esc_attr( $themes ).':after{
				content: "";
				margin-left: 30px;
				border-right: 1px solid #808080;
			}
			.testimonial-'.esc_attr( $themes ).' .testimonial-description-profiles-'.esc_attr( $themes ).' small{
				display: inline-block;
				color: #8a9aad;
				font-size: 17px;
				text-transform: capitalize;
			}
			.testimonial-'.esc_attr( $themes ).' .testimonial-description-profiles-'.esc_attr( $themes ).' small a, a:hover {
			  text-decoration: none;
			  box-shadow: none;
			}
			.testimonial-'.esc_attr( $themes ).' .super-testimonial-'.esc_attr( $themes ).' {
			  display: block;
			  overflow: hidden;
			  text-align: center;
			}
			.testimonial-'.esc_attr( $themes ).' .testimonial-rating-'.esc_attr( $themes ).' i.fa{
			  color: '.esc_attr( $stars_color ).';
			  font-size: 15px;
			  padding: 0px 3px;
			}
			.owl-theme .owl-controls .owl-buttons div{
				background: transparent;
				opacity: 1;
			}
			.owl-buttons{
				position: absolute;
				top: 8%;
				width: 100%;
			}
			.owl-prev{
				position: absolute;
				left:30%;
			}
			.owl-next{
				position: absolute;
				right:30%;
			}
			@media only screen and (max-width: 479px){
				.owl-prev{
					left: 10%;
				}
				.owl-next{
					right: 10%;
				}
			}
			</style>';

			$output .= '
			<script type="text/javascript">
				jQuery(document).ready(function($){
					$("#testimonial-slider-'.esc_attr( $themes ).'").owlCarousel({
						items:1,
						autoplaySpeed: 1000,
						loop: true,
						itemsDesktop:[1199,1],
						itemsDesktopSmall:[979,1],
						itemsTablet:[768,1],
						navigation:"'.esc_attr( $navigation ).'",
						navigationText:["<",">"],
						autoplay:"'.esc_attr( $auto_play ).'",
						smartSpeed: 450,
						clone:true,
					});				
				});
			</script>';

			$output .= '<div id="testimonial-slider-'.esc_attr( $themes ).'" class="owl-carousel">';

				// Creating a new side loop
				while ( $testimonials_query->have_posts() ) : $testimonials_query->the_post();
			 
					$client_name_value 			= get_post_meta(get_the_ID(), 'name', true);
					$link_value 				= get_post_meta(get_the_ID(), 'position', true);
					$company_value 				= get_post_meta(get_the_ID(), 'company', true);
					$company_url 				= get_post_meta(get_the_ID(), 'company_website', true);
					$company_url_target 		= get_post_meta(get_the_ID(), 'company_link_target', true);
					$testimonial_information 	= get_post_meta(get_the_ID(), 'testimonial_text', true);
					$company_ratings_target 	= get_post_meta(get_the_ID(), 'company_rating_target', true);
					$imgurl 					= wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
					if ( empty( $imgurl ) ) $imgurl = get_avatar_url( -1 );

					$output .= '<div class="testimonial-'.esc_attr( $themes ).'">';
						$output .= '<div class="testimonial-thumb-'.esc_attr( $themes ).'">';
						$output .= '<img src="'.esc_url($imgurl).'" alt="">';
						$output .= '</div>';
						if(!empty($testimonial_information)){
							$output .= '<p class="testimonial-description-'.esc_attr( $themes ).'"> '.wp_kses_post( $testimonial_information ).' </p>';
						}
						$output .= '<div class="testimonial-rating-'.esc_attr( $themes ).'">';
							for( $i=0; $i <=4 ; $i++ ) {
							    if ($i < $company_ratings_target) {
							        $full = 'fa fa-star';
							    } else {
							        $full = 'fa fa-star-o';
							    }
							    $output .= '<i class="'.$full.'"></i>';
							}
				   		$output .= '</div>';
						$output .= '<div class="testimonial-description-profiles-'.esc_attr( $themes ).'">';
							$output .= '<span class="testimonial-description-title-'.esc_attr( $themes ).'">  '.esc_attr( $client_name_value ).' </span>';
							$output .= '<small> <a target="'.esc_attr( $company_url_target ).'" href="'.esc_url($company_url).'">'.esc_html( $link_value ).'</a> </small>';
						$output .= '</div>';
					$output .= '</div>';
				endwhile;wp_reset_postdata();
			$output .= '</div>';			

		} elseif( esc_attr($themes) =="theme2" ){
			$output .= '
			<style type="text/css">
				#ktsttestimonial_list_style .client_content{
					color:'.esc_attr( $text_color ).';
				}
				#ktsttestimonial_list_style .testimonial-rating-'.esc_attr( $themes ).' i.fa{
				  color:'.esc_attr( $stars_color ).';
				  font-size: 18px;
				  padding: 0px 5px;
				}
			</style>';

			$output .= '<div class="testimonials_list_area">';
			// Creating a new side loop
			while ( $testimonials_query->have_posts() ) : $testimonials_query->the_post();
		 
				$client_name_value 			= get_post_meta(get_the_ID(), 'name', true);
				$link_value 				= get_post_meta(get_the_ID(), 'position', true);
				$company_value 				= get_post_meta(get_the_ID(), 'company', true);
				$company_url 				= get_post_meta(get_the_ID(), 'company_website', true);
				$company_url_target 		= get_post_meta(get_the_ID(), 'company_link_target', true);
				$testimonial_information 	= get_post_meta(get_the_ID(), 'testimonial_text', true);
				$company_ratings_target 	= get_post_meta(get_the_ID(), 'company_rating_target', true);
				$imgurl 					= wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
				if ( empty( $imgurl ) ) $imgurl = get_avatar_url( -1 );


				$output .= '<div id="ktsttestimonial_list_style">';
					$output .= '<div class="client_names"> '. esc_html( $client_name_value ) .' </div>';
					$output .= '<div class="client_names_photo">';
					$output .= '<img src="'.esc_url($imgurl).'" alt="">';
					$output .= '</div>';
					$output .= '<div class="client_content"><span class="laquo">&nbsp;</span> '.wp_kses_post( $testimonial_information ).' <span class="raquo">&nbsp;</span></div>';
					$output .= '<div class="client_content_info">';
						$output .= '<div class="testimonial-rating-'.esc_attr( $themes ).'">';
							for( $i=0; $i <=4 ; $i++ ) {
							    if ($i < $company_ratings_target) {
							        $full = 'fa fa-star';
							    } else {
							        $full = 'fa fa-star-o';
							    }
							    $output .= '<i class="'.$full.'"></i>';
							}
				   		$output .= '</div>';
						$output .= '<a target="'.esc_attr( $company_url_target ).'" href="'.esc_url($company_url).'">'.esc_html( $company_value ).'</a>';
						$output .= '<p>'.esc_html( $link_value ).'</p>';
					$output .= '</div>';
				$output .= '</div>';
				endwhile; wp_reset_postdata();
			$output .= '</div>';

		}elseif( esc_attr($themes) =="theme3" ){
			$output .= '
			<style type="text/css">
			div#testimonial-slider-'.esc_attr( $themes ).' {
				display: block;
				overflow: hidden;
				padding-top: 10px;
			}
			.testimonial-theme3-'.esc_attr( $themes ).'{
				margin: 0 15px;
			}
			.testimonial-theme3-'.esc_attr( $themes ).' .testimonial-theme3-description-'.esc_attr( $themes ).'{
				position: relative;
				font-size: 16px;
				line-height:26px;
				color: '.esc_attr( $text_color).';
				padding: 25px 20px;
				border:1px solid #d3d3d3;
			}
			.testimonial-theme3-'.esc_attr( $themes ).' .testimonial-theme3-description-'.esc_attr( $themes ).':after{
				content: "";
				width: 20px;
				height: 20px;
				background: #fff;
				border-style: none none solid solid;
				border-width: 0 0 1px 1px;
				border-color: #d3d3d3;
				position: absolute;
				bottom: -11px;
				left: 6%;
				transform: skewY(-45deg);
			}
			.testimonial-theme3-'.esc_attr( $themes ).' .testimonial-theme3-pic-'.esc_attr( $themes ).'{
				width: 80px;
				height: 80px;
				border-radius: 50%;
				overflow: hidden;
				margin:20px 30px;
				display: inline-block;
				float: left;
			}
			.testimonial-theme3-'.esc_attr( $themes ).' .testimonial-theme3-pic-'.esc_attr( $themes ).' img{
				width: 100%;
				height: 100%;
			    margin: 0;
			    padding: 0;
			}
			.testimonial-theme3-'.esc_attr( $themes ).' .testimonial-theme3-'.esc_attr( $themes ).'-title{
				display: inline-block;
				text-transform: capitalize;
				margin-top: 15px;
			}
			.testimonial-theme3-'.esc_attr( $themes ).' .testimonial-theme3-'.esc_attr( $themes ).'-title span{
				color: #3498db;
				display: block;
				font-size:17px;
				font-weight: bold;
				margin-bottom: 10px;
			}
			.testimonial-theme3-'.esc_attr( $themes ).' .testimonial-theme3-'.esc_attr( $themes ).'-title small{
				display: block;
				font-size:14px;
			}
			.owl-theme .owl-controls{
				position: absolute;
				bottom: 10%;
				right: 10px;
			}
			.owl-theme .owl-controls .owl-buttons div {
			  background: #000 none repeat scroll 0 0;
			  border-radius: 0;
			  color: #fff;
			  float: left;
			  margin-right: 5px;
			  padding: 0 10px;
			}
			@media only screen and (max-width: 767px){
				.testimonial-theme3-'.esc_attr( $themes ).' .testimonial-theme3-description-'.esc_attr( $themes ).'{
					font-size: 14px;
				}
				.testimonial-theme3-'.esc_attr( $themes ).' .testimonial-theme3-description-'.esc_attr( $themes ).':after{
						left: 14%;
				}
			}
			@media only screen and (max-width: 479px){
				.owl-theme .owl-controls{
					bottom: 0;
				}
				.testimonial-theme3-'.esc_attr( $themes ).' .testimonial-theme3-description-'.esc_attr( $themes ).':after{
					left: 18%;
				}
			}
			.testimonial-theme3-'.esc_attr( $themes ).' .testimonial-rating-'.esc_attr( $themes ).' i.fa{
			  color:'.esc_attr( $stars_color ).';
			  font-size: 15px;
			  padding: 0px 3px;
			}
			</style>';

			$output .= '
			<script type="text/javascript">
				jQuery(document).ready(function($){
					$("#testimonial-slider-'.esc_attr( $themes ).'").owlCarousel({
						items:1,
						autoplaySpeed: 1000,
						loop: true,
						itemsDesktop:[1199,1],
						itemsDesktopSmall:[979,1],
						itemsTablet:[768,1],
						navigation:"'.esc_attr( $navigation ).'",
						navigationText:["<",">"],
						autoplay:"'.esc_attr( $auto_play ).'",
						smartSpeed: 450,
						clone:true,
					});				
				});
			</script>';

			$output .= '<div id="testimonial-slider-'.esc_attr( $themes ).'" class="owl-carousel">';

			// Creating a new side loop
			while ( $testimonials_query->have_posts() ) : $testimonials_query->the_post();
		 
				$client_name_value 			= get_post_meta(get_the_ID(), 'name', true);
				$link_value 				= get_post_meta(get_the_ID(), 'position', true);
				$company_value 				= get_post_meta(get_the_ID(), 'company', true);
				$company_url 				= get_post_meta(get_the_ID(), 'company_website', true);
				$company_url_target 		= get_post_meta(get_the_ID(), 'company_link_target', true);
				$testimonial_information 	= get_post_meta(get_the_ID(), 'testimonial_text', true);
				$company_ratings_target 	= get_post_meta(get_the_ID(), 'company_rating_target', true);
				$imgurl 					= wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
				if ( empty( $imgurl ) ) $imgurl = get_avatar_url( -1 );

				
				$output .= '<div class="testimonial-theme3-'.esc_attr( $themes ).'">';
					if( !empty( $testimonial_information ) ){
						$output .= '<p class="testimonial-theme3-description-'.esc_attr( $themes ).'">'.wp_kses_post( $testimonial_information ).'</p>';
					}
					$output .= '<div class="testimonial-theme3-pic-'.esc_attr( $themes ).'">';
					$output .= '<img src="'.esc_url($imgurl).'" alt="">';
					$output .= '</div>';
					$output .= '<div class="testimonial-rating-'.esc_attr( $themes ).'">';
						for( $i=0; $i <=4 ; $i++ ) {
						    if ($i < $company_ratings_target) {
						        $full = 'fa fa-star';
						    } else {
						        $full = 'fa fa-star-o';
						    }
						    $output .= '<i class="'.$full.'"></i>';
						}
			   		$output .= '</div>';
					$output .= '<div class="testimonial-theme3-'.esc_attr( $themes ).'-title">';
					$output .= '<span>'.esc_html( $client_name_value ).'</span>';
					$output .= '<small>'.esc_html( $link_value ).'</small>';
					$output .= '</div>';
				$output .= '</div>';
				endwhile;wp_reset_postdata();
			$output .= '</div>';

		}elseif( esc_attr($themes) == "theme4" ){
			$output .= '
			<style type="text/css">
			.testimonial-theme4-'.esc_attr( $themes ).'{
				text-align: center;
				background: #fff;
			}
			.testimonial-theme4-'.esc_attr( $themes ).' .testimonial-theme4-pic-'.esc_attr( $themes ).'{
				width: 100px;
				height: 100px;
				border-radius: 50%;
				border: 5px solid rgba(255,255,255,0.3);
				display: inline-block;
				margin-top: 0px;
				overflow: hidden;
				box-shadow:0 2px 6px rgba(0, 0, 0, 0.15);
				margin: 0 auto;
				display:block;
			}
			.testimonial-theme4-'.esc_attr( $themes ).' .testimonial-theme4-pic-'.esc_attr( $themes ).' img{
				width: 100%;
				height: 100%;
			    margin: 0;
			    padding: 0;
			}
			.testimonial-theme4-'.esc_attr( $themes ).' .testimonial-theme4-description-'.esc_attr( $themes ).'{
				font-size: 16px;
				font-style: italic;
				color: '.esc_attr( $text_color ).';
				line-height: 30px;
				margin: 10px 0 20px;
			}
			.testimonial-theme4-'.esc_attr( $themes ).' .testimonial-theme4-title-'.esc_attr( $themes ).'{
				font-size: 14px;
				font-weight: bold;
				margin: 0;
				color: #333;
				text-transform: uppercase;
				text-align:center;
			}
			.testimonial-theme4-'.esc_attr( $themes ).' .testimonial-theme4-post-'.esc_attr( $themes ).'{
				display: block;
				font-size: 13px;
				color: #777;
				margin-bottom: 15px;
				text-transform: capitalize;
				text-align:center;
			}
			.testimonial-theme4-'.esc_attr( $themes ).' .testimonial-theme4-post-'.esc_attr( $themes ).':before{
				content: "";
				width: 30px;
				display: block;
				margin: 10px auto;
				border: 1px solid #d3d3d3;
			}
			.testimonial-theme4-'.esc_attr( $themes ).' .super-testimonial-'.esc_attr( $themes ).' {
			  display: block;
			  overflow: hidden;
			  text-align: center;
			}
			.testimonial-theme4-'.esc_attr( $themes ).' .testimonial-rating-'.esc_attr( $themes ).' i.fa{
			  color:'.esc_attr( $stars_color ).';
			  font-size: 15px;
			  padding: 0px 3px;
			}
			</style>';

			$output .= '
			<script type="text/javascript">
				jQuery(document).ready(function($){
					$("#testimonial-slider-'.esc_attr( $themes ).'").owlCarousel({
						items:1,
						autoplaySpeed: 1000,
						loop: true,
						itemsDesktop:[1199,1],
						itemsDesktopSmall:[979,1],
						itemsTablet:[768,1],
						navigation:"'.esc_attr( $navigation ).'",
						navigationText:["<",">"],
						autoplay:"'.esc_attr( $auto_play ).'",
						smartSpeed: 450,
						clone:true,
					});				
				});
			</script>';

			$output .= '<div id="testimonial-slider-'.esc_attr( $themes ).'" class="owl-carousel">';

			// Creating a new side loop
			while ( $testimonials_query->have_posts() ) : $testimonials_query->the_post();

				$client_name_value 			= get_post_meta(get_the_ID(), 'name', true);
				$link_value 				= get_post_meta(get_the_ID(), 'position', true);
				$company_value 				= get_post_meta(get_the_ID(), 'company', true);
				$company_url 				= get_post_meta(get_the_ID(), 'company_website', true);
				$company_url_target 		= get_post_meta(get_the_ID(), 'company_link_target', true);
				$testimonial_information 	= get_post_meta(get_the_ID(), 'testimonial_text', true);
				$company_ratings_target 	= get_post_meta(get_the_ID(), 'company_rating_target', true);
				$imgurl 					= wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
				if ( empty( $imgurl ) ) $imgurl = get_avatar_url( -1 );

				$output .= '<div class="testimonial-theme4-'.esc_attr( $themes ).'">';
				$output .= '<div class="testimonial-theme4-pic-'.esc_attr( $themes ).'">';
				$output .= '<img src="'.esc_url($imgurl).'" alt="">';
				$output .= '</div>';

				$output .= '<div class="testimonial-theme4-description-'.esc_attr( $themes ).'"> '.wp_kses_post( $testimonial_information ).' </div>';
				$output .= '<h3 class="testimonial-theme4-title-'.esc_attr( $themes ).'">'.esc_html( $client_name_value ).'</h3>';

				$output .= '<span class="testimonial-theme4-post-'.esc_attr( $themes ).'"> '.esc_html( $company_value ).' </span>';
				$output .= '<div class="testimonial-rating-'.esc_attr( $themes ).'">';
				for( $i=0; $i <=4 ; $i++ ) {
				    if ($i < $company_ratings_target) {
				        $full = 'fa fa-star';
				    } else {
				        $full = 'fa fa-star-o';
				    }
				    $output .= '<i class="'.$full.'"></i>';
				}
				$output .= '</div>';
				$output .= '</div>';
				endwhile; wp_reset_postdata();
				$output .= '</div> ';

		}
		// Return output
		return $output;
	}
	add_shortcode('tpsscode', 'tps_super_testimonials_shortcode_register');