<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_action( 'init', 'wprm_team_init' );
/**
 * Register a Team post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function wprm_team_init() {
	
	$setting_post_type =get_option('setting_post_type');
	if($setting_post_type):
	$setting_new_post_type =get_option('setting_new_post_type');
	
	if(strlen(trim($setting_new_post_type)) >=3):
	
	$override_post_type =$setting_new_post_type;
	endif;
	else:
	$override_post_type ='team';
	endif;

	$labels = array(
		'name'               => _x( ucfirst($override_post_type).'s', 'post type general name', 'wp_team_management' ),
		'singular_name'      => _x( ucfirst($override_post_type), 'post type singular name', 'wp_team_management' ),
		'menu_name'          => _x( ucfirst($override_post_type).'s', 'admin menu', 'wp_team_management' ),
		'name_admin_bar'     => _x(ucfirst($override_post_type), 'add new on admin bar', 'wp_team_management' ),
		'add_new'            => _x( 'Add New', ucfirst($override_post_type), 'wp_team_management' ),
		'add_new_item'       => __( 'Add New '.ucfirst($override_post_type), 'wp_team_management' ),
		'new_item'           => __( 'New '.ucfirst($override_post_type), 'wp_team_management' ),
		'edit_item'          => __( 'Edit '.ucfirst($override_post_type), 'wp_team_management' ),
		'view_item'          => __( 'View '.ucfirst($override_post_type), 'wp_team_management' ),
		'all_items'          => __( 'All '.ucfirst($override_post_type).'s', 'wp_team_management' ),
		'search_items'       => __( 'Search '.ucfirst($override_post_type).'s', 'wp_team_management' ),
		'parent_item_colon'  => __( 'Parent '.ucfirst($override_post_type).'s:', 'wp_team_management' ),
		'not_found'          => __( 'No '.ucfirst($override_post_type).'s'.' found.', 'wp_team_management' ),
		'not_found_in_trash' => __( 'No '.ucfirst($override_post_type).'s'.' found in Trash.', 'wp_team_management' )
	);



	$args = array(
		'labels'             => $labels,
        'description'        => __( 'Description.', 'wp_team_management' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => 'wp_team_management',
		'query_var'          => true,
		'rewrite'            => array( 'slug' => $override_post_type),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 100,
		'supports'           => array( 'title', 'editor','thumbnail')
	);

	register_post_type( $override_post_type, $args );
	   flush_rewrite_rules();
}


$setting_taxonomy = get_option('setting_taxonomy');
if($setting_taxonomy):
add_action( 'init', 'wprm_create_team_tax' );	
function wprm_create_team_tax() {

	$setting_post_type =get_option('setting_post_type');
	if($setting_post_type):
	$setting_new_post_type =get_option('setting_new_post_type');
	if(strlen(trim($setting_new_post_type)) >=3):
	$override_post_type =$setting_new_post_type;
	endif;
	else:
	$override_post_type ='team';
	endif;

	register_taxonomy(
		'team-category',
		$override_post_type,
		array(
			'label' => __( 'Team Category' ),
			'rewrite' => array( 'slug' => 'team_category' ),
			'hierarchical' => true,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var'             => true,
			'rewrite'               => array( 'slug' => 'team_category' ),

		)
	);
}
endif;