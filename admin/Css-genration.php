<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
function wprm_team_custom_css() {
$textare_custom_css =	get_option('setting_custom_css');
$setting_heading_font_color = get_option('setting_heading_font_color');
$setting_subheading_font_color = get_option('setting_subheading_font_color');
$setting_heading_font_size = get_option('setting_heading_font_size');
$setting_Subheading_font_size = get_option('setting_Subheading_font_size');
$setting_circle_hover = get_option('setting_circle_hover');
$setting_font_icon_color = get_option('setting_font_icon_color');
$setting_font_icon_bgcolor = get_option('setting_font_icon_bgcolor');
$setting_font_icon_hover_color = get_option('setting_font_icon_hover_color');
$setting_box_hover_color = get_option('setting_box_hover_color');
$css ='';

$css .='#circle a{color:'.$setting_heading_font_color.';font-size:'.$setting_heading_font_size.';}
		#circle .dp-tm-pic-circle:hover{box-shadow: 0 0 10px'.$setting_circle_hover. ' ;}'."\n";

$css .='#circle .dp-tm-position{font-size:'.$setting_Subheading_font_size.' }'."\n";


$css .=$textare_custom_css;

$file= fopen(plugin_dir_path (__FILE__).'../assets/layouts/custom_team_style.css',"w") or die("Unable to open file!");;
fwrite($file,$css);
fclose($file);
}
$is_theme_custom= get_option('setting_custom_team_css');

if($is_theme_custom=='Custom style'):
wprm_team_custom_css();
function wprm__team_custom_scripts() {

		wp_enqueue_style( 'custom_team_style',plugin_dir_url( __FILE__ ) . '../assets/layouts/custom_team_style.css',false,false);
	}

add_action( 'wp_enqueue_scripts', 'wprm__team_custom_scripts' );

endif;