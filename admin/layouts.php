<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// cropping the images as per the layouts
add_image_size( 'circle-image',210,210, array('center','top') ); // Hard crop top center
add_image_size( 'boxed-image',175,180, array('center','top') ); // Hard crop top center
add_image_size( 'boxed',240,240, array('center','top') ); // Hard crop top center

// Add Shortcode
function wprm_team_shortcode( $atts ,$content = null) {

	$setting_post_type =get_option('setting_post_type');
	$setting_section_heading_title =get_option('setting_section_heading_title');
	if($setting_post_type):
	$setting_new_post_type =get_option('setting_new_post_type');
	if($setting_new_post_type):
	$override_post_type =$setting_new_post_type;
	endif;
	else:
	$override_post_type ='team';
	endif;
	
	$tax = ''; $html = ''; $layout_class ='';
	// Attributes
	extract( shortcode_atts(
		array(
			'layout' => 'Circle',
			'post_per_page' => '-1',
			'team_title' => '<h1 class="dp-team-title">meet <span>the team </span>- Style Default - Listing</h1>',
			'category' =>'',
			'columns' =>4,
		), $atts )
	);
if($category):
	$tax =array(
				array(
				'taxonomy'=>'team-category',
				'field'=>'slug',
				'terms'=>$category,
				),
			);
endif;
	$args =array(
			'post_type'=>$override_post_type,
			'posts_per_page'=>$post_per_page,
			'tax_query'=>$tax
		);	

	$teams = get_posts($args);


if($columns=='') $columns=4;
$grids =array(1=>12,2=>6,3=>4,4=>3,6=>2);

if($layout!='Boxed') $layout_class =' dp-columns';

if($content):
$html .='<div class="dp-team">'.$content;
elseif($setting_section_heading_title):
$html .='<div class="dp-team">'.$setting_section_heading_title;	
else:
$html .='<div class="dp-team">'.$team_title;	
endif;	
$html .='<div id="'. strtolower($layout) .'" class="dp-layout-'. strtolower($layout) .$layout_class.'">';

foreach($teams as $post): setup_postdata( $post );

$feat_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'boxed');
$social_html ='';
$team_facebook =get_post_meta( $post->ID,'team_facebook',true);
if($team_facebook) $social_html .='<a href="'.$team_facebook.'" target="blank"><i class="fa fa-facebook"></i></a>';

$team_twitter =get_post_meta( $post->ID,'team_twitter',true);
if($team_twitter) $social_html .='<a href="'.$team_twitter.'" target="blank"><i class="fa fa-twitter"></i></a>';

$team_google =get_post_meta( $post->ID,'team_google',true);
if($team_google) $social_html .='<a href="'.$team_google.'" target="blank"><i class="fa fa-google-plus"></i></a>';

$team_link =get_post_meta( $post->ID,'team_link',true);
if($team_link) $social_html .='<a href="'.$team_link.'" target="blank"><i class="fa fa-linkedin"></i></a>';

$team_pin =get_post_meta( $post->ID,'team_pin',true);
if($team_pin) $social_html .='<a href="'.$team_pin.'" target="blank"><i class="fa fa-pinterest"></i></a>';

$cropped_img =get_post_meta( $post->ID,'team_circle',true);


// check layout for the circle loop

if($layout=='Circle'):


$html .='<div id="post-'.$post->ID.'" class="dp-col-'.$grids[$columns].'">
	<div class="dp-item-circle">
	<div class="dp-tm-pic-circle"><a href="'. get_permalink($post->ID) .'"><img src="'. $cropped_img['url'] .'"></a>
	</div>
	<span class="dp-tm-name"> <a href="'. get_permalink($post->ID) .'"> '. $post->post_title .'</a> </span>
	<span class="dp-tm-position">'. get_post_meta( $post->ID,'team_position',true) .'</span> 
	</div></div>';

endif;

// check layout for the boxed-right loop
if($layout=='Boxed-Right-Content'):

$html .='<div id="post-'.$post->ID.'" class="dp-col-'.$grids[$columns].'">
		 <div class="dp-item-rectangle"><div class="dp-row"><div class="dp-col-5">
		 <div class="dp-tm-pic-rectangle"> <img src="'. $cropped_img['url'] .'"></div> </div>
		 <div class="dp-col-7">
		 <div class="dp-social-buttons align-right">
		 '.$social_html.'
		 </div>
		 <p>'. wprm_get_excerpt(124,$post) .'</p></div></div>
		<div class="dp-tm-caption-rectangle">
		<span class="dp-tm-name"></a><a href="'. get_permalink($post->ID) .'"> '. $post->post_title .'</a> </span><span>'. get_post_meta( $post->ID,'team_position',true)  .'</span> ';
$html .= '<a href="'. get_permalink($post->ID) .'" class="dp-rm-btn-rectangle right">Read More <i class="dp-dot"></i><i class="dp-dot"></i><i class="dp-dot"></i></a>
		  </div>';		
$html .= '</div></div>';
endif;

// check layout for the boxed loop
if($layout=='Boxed'):

$html .='<div id="post-'.$post->ID.'" class="dp-col-3">
		 <div class="dp-item-boxed"><div class="dp-tm-pic-boxed">
		 '. get_the_post_thumbnail( $post->ID,array(240,240)) .'
		 <div class="dp-tm-caption-boxed">
		<span class="dp-tm-name"><a href="'. get_permalink($post->ID) .'"> '. $post->post_title .'</a> </span><span>'. get_post_meta( $post->ID,'team_position',true)  .'</span> ';
$html .= 	'</div></div></div>';

$html .= 	'<div class="dp-overly" style="display: none;"></div>
			<div class="dp-light-box" style="display: none;">	
			<div class="dp-layout-boxed-single dp-columns">
			<div class="dp-col-12">
			<div class="dp-item-boxed">
			<div class="dp-row">
			<div class="dp-col-4">
			<div class="dp-tm-pic-boxed-single"> '. get_the_post_thumbnail( $post->ID,"full") .'</div> </div>
			<div class="dp-col-8">
			<div class="dp-row">
			<div class="dp-social-buttons">
			'.$social_html.'
			</div>
			<span class="dp-close">close</span>
			<span class="dp-tm-name"><a href="">  '. $post->post_title .' </a> </span>
    		<span class="dp-tm-position">'. get_post_meta( $post->ID,'team_position',true)  .'</span> 
			</div>'. wprm_get_the_pop_content($post->ID) .'</div>
			</div>
			<div class="dp-tm-caption-boxed">
			</div>
			</div>
			</div>
			</div></div>';
$html .='</div>';
endif;

// check layout for the box-hover loop
if($layout=='Box-Hover'):

$html .='<div id="post-'.$post->ID.'" class="dp-col-3">
		 <div class="dp-item-yrectangle"><div class="dp-tm-pic-yrectangle">
		 <img src="'. $cropped_img['url'] .'"></div>
		 <span class="dp-tm-name"></a><a href="'. get_permalink($post->ID) .'"> '. $post->post_title .'</a> </span><span>'. get_post_meta( $post->ID,'team_position',true)  .'</span> ';

$html .= '</div></div>';
endif;

// check layout for the hexagon loop
if($layout=='Hexagon'):

$html .='<div id="post-'.$post->ID.'" class="dp-item-hexagon">
		 <div class="dp-tm-pic-hexagon"><a href="'. get_permalink($post->ID) .'">
		 <div class="dp-hexagon" style="background-image: url('.$cropped_img['url'].');">
		 </div></a>';

$html .= '</div></div>';
endif;

unset($social_html);
endforeach ;

$html .='</div>';
$html .='</div>';

wp_enqueue_style( $layout, plugin_dir_url( __FILE__ ) . '../assets/layouts/'.$layout.'.css',false,false );
wp_enqueue_script('team-theme', plugin_dir_url( __FILE__ ) . '../assets/js/team-theme.js',false,false );


return $html;
}
add_shortcode( 'Team-manager', 'wprm_team_shortcode' );
