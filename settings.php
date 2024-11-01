<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if(!class_exists('WP_team_management_Settings'))
{
    class WP_team_management_Settings
    {
        /**
         * Construct the plugin object
         */
        public function __construct()
        {
            // register actions
            add_action('admin_init', array(&$this, 'wprm_admin_init_post'));
            add_action('admin_init', array(&$this, 'wprm_admin_init_layout'));
            add_action('admin_init', array(&$this, 'wprm_admin_init_theme'));
            add_action('admin_menu', array(&$this, 'wprm_add_menu'),9);
                                   
        } // END public function __construct
        
         /**
         * hook into WP's admin_init action hook for post tab
         */

        public function wprm_admin_init_post()
        {
            // register plugin's settings for post tab
            register_setting('WP_team_management-group', 'setting_taxonomy');
            register_setting('WP_team_management-group', 'setting_post_type');
            register_setting('WP_team_management-group', 'setting_new_post_type');
            register_setting('WP_team_management-group', 'setting_section_heading_title');
            
            
            // add your settings section for post tab
            add_settings_section(
                'WP_team_management-section', 
                '', 
                array(&$this, 'wprm_settings_section_wp_team_management'), 
                'wp_team_management'
            );
            
                       
            add_settings_field(
                'wp_team_management-setting_a', 
                'Show Category in Post type', 
                array(&$this, 'wprm_settings_field_input_checkbox'), 
                'wp_team_management', 
                'WP_team_management-section',
                array(
                    'field' => 'setting_taxonomy'
                )
            );
            
            add_settings_field(
                'wp_team_management-setting_b', 
                'Change Post Type', 
                array(&$this, 'wprm_settings_field_input_checkbox'), 
                'wp_team_management', 
                'WP_team_management-section',
                array(
                    'field' => 'setting_post_type'
                )
            );

            add_settings_field(
                'wp_team_management-setting_c', 
                'New Post Type', 
                array(&$this, 'wprm_settings_field_input_text'), 
                'wp_team_management', 
                'WP_team_management-section',
                array(
                    'field' => 'setting_new_post_type'
                )
            );
             // add your setting's fields for post tab
            add_settings_field(
                'wp_team_management-setting_d', 
                'Section Title', 
                array(&$this, 'wprm_settings_field_input_text'), 
                'wp_team_management', 
                'WP_team_management-section',
                array(
                    'field' => 'setting_section_heading_title'
                )
            );
            // End of post tab

            
           
        }
        
        /**
         * hook into WP's admin_init action hook for layout tab
         */

        public function wprm_admin_init_layout()
        {
            
            // register plugin's settings for layout tab
            register_setting('WP_team_management_layout-group', 'setting_columns');
            register_setting('WP_team_management_layout-group', 'setting_layout');
            
            
            // add your settings section for layout tab
            add_settings_section(
                'WP_team_management_layout-section', 
                '', 
                array(&$this, 'wprm_settings_section_wp_team_management'), 
                'wp_team_management_layout'
            );
        
          	// add your setting's fields for layout tab
            add_settings_field(
                'wp_team_management-setting_layout', 
                'Select Layout', 
                array(&$this, 'wprm_settings_field_input_select'), 
                'wp_team_management_layout', 
                'WP_team_management_layout-section',
                array(
                    'field' => 'setting_layout',
                    'options'=>array('Circle'),
                    'below_text'=>'<p class="wprm_note">Please note the circle layout is the only layout availble in the free version.</p>
								  <p>To have access to all 5 layout please upgarade to the <a href="#">Premium version here.</a></p>'
                )
            );

            // add your setting's fields for layout tab
            add_settings_field(
                'wp_team_management-setting_column', 
                'Select No Of Columns', 
                array(&$this, 'wprm_settings_field_input_select'), 
                'wp_team_management_layout', 
                'WP_team_management_layout-section',
                array(
                    'field' => 'setting_columns',
                    'options'=>array(1,2,3,4,6)
                )
            );
            

            // Possibly do additional admin_init tasks
        } 
        // END of layout tab
        
         /**
         * hook into WP's admin_init action hook for theme tab
         */

        public function wprm_admin_init_theme()
        {
            
            // register plugin's settings for theme tab
            register_setting('WP_team_management_theme-group', 'setting_custom_team_css');
            register_setting('WP_team_management_theme-group', 'setting_heading_font_color');
            register_setting('WP_team_management_theme-group', 'setting_subheading_font_color');
            register_setting('WP_team_management_theme-group', 'setting_circle_hover');
            register_setting('WP_team_management_theme-group', 'setting_font_icon_color');
            register_setting('WP_team_management_theme-group', 'setting_font_icon_bgcolor');
            register_setting('WP_team_management_theme-group', 'setting_font_icon_hover_color');
            register_setting('WP_team_management_theme-group', 'setting_heading_font_size');
            register_setting('WP_team_management_theme-group', 'setting_Subheading_font_size');
            register_setting('WP_team_management_theme-group', 'setting_font_hover');
            register_setting('WP_team_management_theme-group', 'setting_paragraph_font_size');
            register_setting('WP_team_management_theme-group', 'setting_custom_css');
            
            

            // add your settings section for theme tab
            add_settings_section(
                'WP_team_management_theme-section', 
                'Style Setting', 
                array(&$this, 'wprm_settings_section_wp_team_management'), 
                'wp_team_management_theme'
            );
            
            add_settings_section(
                'WP_team_management_theme-Fontsection', 
                'Font Style Setting', 
                array(&$this, 'wprm_font_settings_section_wp_team_management'), 
                'wp_team_management_theme'
            );

            add_settings_section(
                'WP_team_management_theme-Iconsection', 
                'Font Icon Style', 
                array(&$this, 'wprm_icon_settings_section_wp_team_management'), 
                'wp_team_management_theme'
            );

            add_settings_section(
                'WP_team_management_theme-csssection', 
                'Custom Style', 
                array(&$this, 'wprm_icon_settings_section_wp_team_management'), 
                'wp_team_management_theme'
            );

            // add your setting's fields for theme tab
            add_settings_field(
                'wp_team_management-setting_custom_team_css', 
                'Theme Style', 
                array(&$this, 'wprm_settings_field_input_select'), 
                'wp_team_management_theme', 
                'WP_team_management_theme-section',
                array(
                    'field' => 'setting_custom_team_css',
                     'options'=>array('Theme Default','Custom style')
                )
            );

            // add your setting's fields for theme tab
            add_settings_field(
                'wp_team_management-setting_heading_font_color', 
                'Heading Font Color', 
                array(&$this, 'wprm_settings_field_input_colorpiker'), 
                'wp_team_management_theme', 
                'WP_team_management_theme-Fontsection',
                array(
                    'field' => 'setting_heading_font_color'
                )
            );
            
            // add your setting's fields for theme tab
            add_settings_field(
                'wp_team_management-setting_subheading_font_color', 
                'Sub Heading Font Color', 
                array(&$this, 'wprm_settings_field_input_colorpiker'), 
                'wp_team_management_theme', 
                'WP_team_management_theme-Fontsection',
                array(
                    'field' => 'setting_subheading_font_color'
                )
            );
             // add your setting's fields for theme tab
            add_settings_field(
                'wp_team_management-setting_font_hover', 
                'Font Hover', 
                array(&$this, 'wprm_settings_field_input_colorpiker'), 
                'wp_team_management_theme', 
                'WP_team_management_theme-Fontsection',
                array(
                    'field' => 'setting_font_hover',
                     )
            );
           
            // add your setting's fields for theme tab
            add_settings_field(
                'wp_team_management-setting_heading_font_size', 
                'Heading Font Size', 
                array(&$this, 'wprm_settings_field_input_text'), 
                'wp_team_management_theme', 
                'WP_team_management_theme-Fontsection',
                array(
                    'field' => 'setting_heading_font_size',
                    'class' => 'range'
                )
            );

            // add your setting's fields for theme tab
            add_settings_field(
                'wp_team_management-setting_subheading_font_size', 
                'Sub Heading Font Size', 
                array(&$this, 'wprm_settings_field_input_text'), 
                'wp_team_management_theme', 
                'WP_team_management_theme-Fontsection',
                array(
                    'field' => 'setting_Subheading_font_size',
                    'class' => 'range'
                )
            );
            // add your setting's fields for theme tab
            add_settings_field(
                'wp_team_management-setting_paragraph_font_size', 
                'Paragraph Font Size', 
                array(&$this, 'wprm_settings_field_input_text'), 
                'wp_team_management_theme', 
                'WP_team_management_theme-Fontsection',
                array(
                    'field' => 'setting_paragraph_font_size',
                    'class'=>'range'
                     )
            );
            add_settings_field(
                'wp_team_management-setting_circle_hover', 
                'Circle Hover', 
                array(&$this, 'wprm_settings_field_input_colorpiker'), 
                'wp_team_management_theme', 
                'WP_team_management_theme-section',
                array(
                    'field' => 'setting_circle_hover'
                )
            );
            add_settings_field(
                'wp_team_management-font_icon_color', 
                'Font Icon Color', 
                array(&$this, 'wprm_settings_field_input_colorpiker'), 
                'wp_team_management_theme', 
                'WP_team_management_theme-Iconsection',
                array(
                    'field' => 'setting_font_icon_color'
                )
            );

            add_settings_field(
                'wp_team_management-font_icon_bgcolor', 
                'Font Icon Background Color', 
                array(&$this, 'wprm_settings_field_input_colorpiker'), 
                'wp_team_management_theme', 
                'WP_team_management_theme-Iconsection',
                array(
                    'field' => 'setting_font_icon_bgcolor'
                )
            );
            add_settings_field(
                'wp_team_management-setting_font_icon_hover_color', 
                'Font Icon Hover Color', 
                array(&$this, 'wprm_settings_field_input_colorpiker'), 
                'wp_team_management_theme', 
                'WP_team_management_theme-Iconsection',
                array(
                    'field' => 'setting_font_icon_hover_color'
                )
            );
           
            add_settings_field(
                'wp_team_management-setting_custom_css', 
                'Custom Css', 
                array(&$this, 'wprm_settings_field_input_textarea'), 
                'wp_team_management_theme', 
                'WP_team_management_theme-csssection',
                array(
                    'field' => 'setting_custom_css'
                )
            );


            // Possibly do additional admin_init tasks
        } 
        // END of layout tab
       
        public function wprm_settings_section_wp_team_management()
        {
            // Think of this as help text for the section.
            //echo 'hi';
        } 

        public function wprm_font_settings_section_wp_team_management()
        {
            // Think of this as help text for the section.
            //echo 'hi';
        }

        public function wprm_icon_settings_section_wp_team_management()
        {
            // Think of this as help text for the section.
            //echo 'hi';
        }
        
        /**
         * This function provides text inputs for settings fields
         */
        public function wprm_settings_field_input_text($args)
        {
            // Get the field name from the $args array
            $field = $args['field'];
            $class = @$args['class'];
            // Get the value of this setting
            $value = get_option($field);
            // echo a proper input type="text"
            echo @sprintf('<input type="text" name="%s" id="%s" value="%s" class="%s"/>', $field, $field,$value,$class);
        } // END public function settings_field_input_text($args)
        
         /**
         * This function provides textarea inputs for settings fields
         */
        public function wprm_settings_field_input_textarea($args)
        {
            // Get the field name from the $args array
            $field = $args['field'];
            $class = @$args['class'];
            // Get the value of this setting
            $value = get_option($field);
            // echo a proper input type="text"
            echo @sprintf('<textarea name="%s" id="%s" class="%s"/>%s</textarea>', $field,$field,$class,$value);
        } // END public function settings_field_input_text($args)
        
        
        /**
         * This function provides color inputs for settings fields
         */
        public function wprm_settings_field_input_colorpiker($args)
        {
            // Get the field name from the $args array
            $field = $args['field'];
            // Get the value of this setting
            $value = get_option($field);
            // echo a proper input type="text"
            echo @sprintf('<input type="text" name="%s" class="jscolor {hash:true}" id="%s" value="%s" />', $field, $field, $value);
        } // END public function settings_field_input_text($args)
        
        /**
         * This function provides checkbox inputs for settings fields
         */
        public function wprm_settings_field_input_checkbox($args)
        {
            // Get the field name from the $args array
            $field = $args['field'];
            // Get the value of this setting
            $value = get_option($field);
            // echo a proper input type="checkobx"
            if($value=='yes') $checked ='checked';
            echo @sprintf('<input type="checkbox" name="%s" %s id="%s" value="yes" />',$field,$checked,$field);
        } // END public function settings_field_input_chechbox($args)
        
        public function wprm_settings_field_input_select($args)
        {
            // Get the field name from the $args array
            $field = $args['field'];
            $options = $args['options'];
            
            $below_text = @$args['below_text'];
            // Get the value of this setting
            $val = get_option($field);
            // echo a proper input type="select"
            echo @sprintf('<select name="%s">',$field);
            echo @sprintf('<option value="">%s</option>','select option');
            foreach($options as $key=>$value):
            
            if($val==$value) : $flag= 'selected'; else: $flag= ' '; endif;

            echo @sprintf('<option value="%s" %s>%s</option>',$value,$flag,$value);
            endforeach;
            echo "</select>";
            if($below_text) echo $below_text;
        } // END public function settings_field_input_select($args)
       
        /**
         * add a menu
         */     
        public function wprm_add_menu()
        {
            // Add a page to manage this plugin's settings
            add_menu_page(
                'WP_team_management Settings', 
                'Responsive WP Meet the Team', 
                'manage_options', 
                'wp_team_management', 
                array(&$this, 'wprm_settings_page'),
                'dashicons-businessman'
            );

             // Add a page to manage this plugin's settings
            add_submenu_page(
                'wp_team_management', 
                'Team Layout', 
                'Team Layout', 
                'manage_options', 
                'wp_team_management_layout', 
                array(&$this, 'wprm_settings_page')
            );

             // Add a page to manage this plugin's settings
            add_submenu_page(
                'wp_team_management', 
                'Team Theme option', 
                'Team Theme option', 
                'manage_options', 
                'wp_team_management_theme', 
                array(&$this, 'wprm_settings_page')
            );
        }
       
         // END public function add_menu()
        
         /**
         * Menu Callback
         */     
        public function wprm_settings_page()
        {
            if(!current_user_can('manage_options'))
            {
                wp_die(__('You do not have sufficient permissions to access this page.'));
            }
    
            // Render the settings template
            include(sprintf("%s/admin/settings.php", dirname(__FILE__)));
        } // END public function plugin_settings_page()
    } // END class WP_team_management_Settings
} // END if(!class_exists('WP_team_management_Settings'))
