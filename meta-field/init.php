<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
//include the main class file
require_once("meta-field/meta-field.php");
if (is_admin()){
  $setting_post_type =get_option('setting_post_type');
  if($setting_post_type):
  $setting_new_post_type =get_option('setting_new_post_type');
  if(strlen(trim($setting_new_post_type)) >=3):
  $override_post_type =$setting_new_post_type;
  endif;
  else:
  $override_post_type ='team';
  endif;
  /* 
   * prefix of meta keys, optional
   * use underscore (_) at the beginning to make keys hidden, for example $prefix = '_ba_';
   *  you also can make prefix empty to disable it
   * 
   */
  $prefix = 'team_';
  /* 
   * configure your meta box
   */
  $config = array(
    'id'             => 'demo_meta_box',          // meta box id, unique per meta box
    'title'          => 'Team Details',          // meta box title
    'pages'          => array($override_post_type),      // post types, accept custom post types as well, default is array('post'); optional
    'context'        => 'normal',            // where the meta box appear: normal (default), advanced, side; optional
    'priority'       => 'high',            // order of meta box: high (default), low; optional
    'fields'         => array(),            // list of meta fields (can be added by field arrays)
    'local_images'   => false,          // Use local or hosted images (meta box images for add/remove)
    'use_with_theme' => false          //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
  );
  
  
  /*
   * Initiate your meta box
   */
  $my_meta =  new wprm_Meta_Box($config);
  
  /*
   * Add fields to your meta box
   */
  
  //text field
  $my_meta->addText($prefix.'email',array('name'=> 'Email'));
  $my_meta->addText($prefix.'position',array('name'=> 'Position'));
  $my_meta->addText($prefix.'facebook',array('name'=> 'Facebook'));
  $my_meta->addText($prefix.'twitter',array('name'=> 'Twitter'));
  $my_meta->addText($prefix.'google',array('name'=> 'Google+'));
  $my_meta->addText($prefix.'link',array('name'=> 'Linkedin'));
  $my_meta->addText($prefix.'pin',array('name'=> 'Pinterest'));
  
  $layout = get_option('setting_layout');
  // if($layout=='Circle'):
  $my_meta->addimage($prefix.'circle',array('name'=> 'Cropped Image','desc' => '<h3>Crop your image to exact 210*210 dimension before upload!</h3>'));
   // endif;
   // if($layout=='Box-Hover'):
  // $my_meta->addimage($prefix.'hover-box-image',array('name'=> 'box Image','desc' => 'Crop your image to exact 210*210 dimension before upload!'));
  //  endif;
      
  /*
   * To Create a reapeater Block first create an array of fields
   * use the same functions as above but add true as a last param
   */
  
  $repeater_fields[] = $my_meta->addText($prefix.'site',array('name'=> 'Site '),true);
  $repeater_fields[] = $my_meta->addText($prefix.'url',array('name'=> 'URL '),true);
    /*
   * Then just add the fields to the repeater block
   */
  //repeater block
  $my_meta->addRepeaterBlock($prefix.'re_',array(
    'inline'   => true, 
    'name'     => 'Add More Social Links',
    'fields'   => $repeater_fields, 
    'sortable' => true
  ));
  

  $repeater_fields2[] = $my_meta->addText($prefix.'attr',array('name'=> 'Attribute '),true);
  $repeater_fields2[] = $my_meta->addText($prefix.'value',array('name'=> 'Value '),true);
    /*
   * Then just add the fields to the repeater block
   */
  //repeater block
  $my_meta->addRepeaterBlock($prefix.'re2_',array(
    'inline'   => true, 
    'name'     => 'Add Extra Attributes',
    'fields'   => $repeater_fields2, 
    'sortable' => true
  ));
  
  

  
  /*
   * Don't Forget to Close up the meta box Declaration 
   */
  //Finish Meta Box Declaration 
  $my_meta->Finish();
  
  
}
function sgr_display_image_size_names_muploader( $sizes ) {
  
  $new_sizes = array();
  
  $added_sizes = get_intermediate_image_sizes();
  
  // $added_sizes is an indexed array, therefore need to convert it
  // to associative array, using $value for $key and $value
  foreach( $added_sizes as $key => $value) {
    $new_sizes[$value] = $value;
  }
  
  // This preserves the labels in $sizes, and merges the two arrays
  $new_sizes = array_merge( $new_sizes, $sizes );
  
  return $new_sizes;
}
add_filter('image_size_names_choose', 'sgr_display_image_size_names_muploader', 11, 1);