<?php

/* 
Plugin Name: WP Responsive Meet the Team
Plugin URI: https://wordpress.org/plugins/wp-responsive-meet-the-team/
Description: A responsive meet the team showcase plugin to display your team, staff members or management.
Version: 1.0
Author: Vobi
Author URI: https://profiles.wordpress.org/Vobi/
License: GPLv2 or later
*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
define( 'PLUGIN_PATH', plugin_dir_url( __FILE__ ) ); 

if(!class_exists('WP_team_management'))
{
    class WP_team_management
    {
        /**
         * Construct the plugin object
         */
        public function __construct()
        {
            // register actions

            require_once(sprintf("%s/settings.php", dirname(__FILE__)));
            $WP_team_management_Settings = new WP_team_management_Settings();
            
          	$plugin = plugin_basename(__FILE__);
            add_filter("plugin_action_links_$plugin", array( $this, 'wprm_settings_link' ));
			        } // END public function __construct
    
        /**
         * Activate the plugin
         */
        public static function activate()
        {
            // Do nothing

       
        } // END public static function activate
    
        /**
         * Deactivate the plugin
         */     
        public static function deactivate()
        {
            // Do nothing
        } // END public static function deactivate



        function wprm_settings_link($links)
		{
			$settings_link = '<a href="options-general.php?page=wp_team_management">Settings</a>';
			array_unshift($links, $settings_link);
			return $links;
		}
    
    

    } // END class WP_Plugin_Template
} // END if(!class_exists('WP_Plugin_Template'))

if(class_exists('WP_team_management'))
{
	// Installation and uninstallation hooks
	register_activation_hook(__FILE__, array('WP_team_management', 'activate'));
	register_deactivation_hook(__FILE__, array('WP_team_management', 'deactivate'));
	// instantiate the plugin class
	$wp_team_management = new WP_team_management();

    // Register custom post type
    require_once('post-type/post_type.php');
   
   // Creating page template 
    require_once('admin/template-class.php');

   // Creating page template 
    require_once('meta-field/init.php');
   
   // Creating layout shortcodes 
    require_once('admin/layouts.php');

	// adding cropping functions 
    require_once('admin/cropping-field.php');
  
  // CSS file Genration file  
    require_once('admin/Css-genration.php');

    function wprm_team_js_enqueue($hook) {
    
    wp_enqueue_style( 'team-admin-css',PLUGIN_PATH . '/assets/css/team-admin.css','',false );
    wp_enqueue_style( 'tabs-css', PLUGIN_PATH. '/assets/css/setting-tabs.css','',false );
    wp_enqueue_style( 'jquery-Jcrop',PLUGIN_PATH. '/assets/css/jquery.Jcrop.css','',false );
    wp_enqueue_script( 'jscolor',PLUGIN_PATH. '/assets/js/jscolor.js','',false );
    wp_enqueue_script( 'wprm_team-theme',PLUGIN_PATH. '/assets/js/team-theme.js','',false );
    wp_enqueue_script( 'jquery-Jcrop',PLUGIN_PATH. '/assets/js/jquery.Jcrop.js','',false );
    wp_localize_script( 'ajax-script', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'we_value' => 1234 ) );
    wp_enqueue_script('jquery-ui-slider');
    wp_enqueue_script('jquery-ui-accordion');
    wp_enqueue_style('jquery-style',PLUGIN_PATH.'/assets/css/jquery-ui.css');
    }

    add_action( 'admin_enqueue_scripts', 'wprm_team_js_enqueue' );

    function wprm_team_frontend_enqueue() {
        wp_enqueue_style('main-team-plugin-css', PLUGIN_PATH. '/assets/css/team-theme.css','',false );
        wp_enqueue_style('font-awesome-css',PLUGIN_PATH.'/assets/css/font-awesome.min.css','',false );
       }

    add_action( 'wp_enqueue_scripts', 'wprm_team_frontend_enqueue' );



add_filter( 'template_include', 'wprm_team_template_chooser');
	
function wprm_team_template_chooser( $template ) {
 
        // Post ID
        $post_id = get_the_ID();
     
        // For all other CPT
        if ( get_post_type( $post_id ) != 'team' ) {
            return $template;
        }
     
        // Else use custom template
        if ( is_single() ) {
            return wprm_team_get_template_hierarchy( 'single-team' );
        }
 
    }

function wprm_team_get_template_hierarchy( $template ) {
 
        // Get the template slug
        $template_slug = rtrim( $template, '.php' );
        $template = $template_slug . '.php';
     
        // Check if a custom template exists in the theme folder, if not, load the plugin template file
        if ( $theme_file = locate_template( array( 'team-manager/' . $template ) ) ) {
            $file = $theme_file;
        }
        else {

            $file = dirname( __FILE__ ) . '/templates/' . $template;
        }
     
        return apply_filters( 'rc_repl_template_' . $template, $file );
    }
 
    add_filter( 'template_include', 'wprm_team_template_chooser' );

add_filter( 'post_thumbnail_html', 'wprm_remove_width_attribute', 10 );
add_filter( 'image_send_to_editor', 'wprm_remove_width_attribute', 10 );

function wprm_remove_width_attribute( $html ) {
   $html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
   return $html;
}

function wprm_get_excerpt($count){
  $permalink = get_permalink($post->ID);
  $excerpt = get_the_content();
  $excerpt = strip_tags($excerpt);
  $excerpt = substr($excerpt, 0, $count);
  $excerpt = $excerpt;
  return $excerpt;
}

function wprm_get_the_pop_content($more_link_text = '(more...)', $stripteaser = 0, $more_file = '') {
  $content = get_the_content($more_link_text, $stripteaser, $more_file);
  $content = apply_filters('the_content', $content);
  $content = str_replace(']]>', ']]&gt;', $content);
  return $content;
}
add_filter('widget_text', 'do_shortcode');

}

