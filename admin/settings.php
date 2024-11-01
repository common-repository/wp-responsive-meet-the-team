<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly?>

<div class="wrap">
    <h2>Responsive WP Team</h2>
<div id="tabs">
<?php if(isset($_GET['page'])) : $condition_tab= $_GET['page'] ; else: $condition_tab= 'wp_team_management'; endif; ?>
   
    <ul class="nav">
    <li class="<?php if($condition_tab=='wp_team_management') echo 'active';?>"><a href="?page=wp_team_management">Post Setting</a></li>
    <li class="<?php if($condition_tab=='wp_team_management_layout') echo 'active'; ?>"><a href="?page=wp_team_management_layout">Layouts</a></li>
    
    <li class="<?php if($condition_tab=='wp_team_management_theme') echo 'active'; ?>"><a href="?page=wp_team_management_theme">Theme Settings</a></li>
    <!-- <li class="<?php if($condition_tab=='license') echo 'active'; ?>"><a href="?page=wp_team_management_theme&tab=theme">License</a></li> -->
 </ul>
</div>

<?php if($condition_tab=='wp_team_management'): ?>
  
<div id="home" class="active tab_content">
    <form method="post" action="options.php"> 
        
        <?php @settings_fields('WP_team_management-group'); ?>
        <?php @do_settings_fields('WP_team_management-group'); ?>
        
        <?php do_settings_sections('wp_team_management'); ?>
        
        <?php @submit_button(); ?>
    </form>
     <p>Use [Team-manager layout="Circle" post_per_page="-1"] for display it in post or page.</p>
     <p>Change the diffrent layouts in shortcode and the number of posts.</p>
     <p><big>You can also have an Template to show your Team on page "Team Manager Layout". Select it from page template option in  pages.</big></p>
     <p>To Override the layout of single page you need to make single-team.php file in you theme.</p>
</div>

<?php endif;?>

<?php if($condition_tab=='wp_team_management_layout'): ?>
<div id="menu1" class="tab_content fade">
      
      <form method="post" action="options.php"> 
        <?php @settings_fields('WP_team_management_layout-group'); ?>
        <?php @do_settings_fields('WP_team_management_layout-group'); ?>

        <?php do_settings_sections('wp_team_management_layout'); ?>
        <?php @submit_button(); ?>
        <div class="rows">
        <div class="col-6">
        <h2>Circle -Layout</h2>
        <?php 
        echo '<img src="' . plugins_url( '../assets/layouts/screenshot-1.png', __FILE__ ) . '" > ';
        ?>
        </div>           
        <div class="col-6">
        <h2>Boxed Right Content -Layout</h2>
        <?php 
        echo '<img src="' . plugins_url( '../assets/layouts/screenshot-2.png', __FILE__ ) . '" > ';
        ?>
        </div>           
        </div>
        <div class="rows">
        <div class="col-6">
        <h2>Boxed -Layout</h2>
        <?php 
        echo '<img src="' . plugins_url( '../assets/layouts/screenshot-3.png', __FILE__ ) . '" > ';
        ?>
        </div>           
        <div class="col-6">
        <h2>Boxed Hover -Layout</h2>
        <?php 
        echo '<img src="' . plugins_url( '../assets/layouts/screenshot-4.png', __FILE__ ) . '" > ';
        ?>
        </div>           
        </div>
        <div class="rows">
        <div class="col-6">
        <h2>Hexagon -Layout</h2>
        <?php 
        echo '<img src="' . plugins_url( '../assets/layouts/screenshot-5.png', __FILE__ ) . '" > ';
        ?>
        </div>           
        </div>
      
    </form>
</div>
<?php endif;?>

<?php if($condition_tab=='wp_team_management_theme'): ?>
<div id="menu2" class="tab_content fade">
     
      <form method="post" action="options.php"> 
      
        <?php @settings_fields('WP_team_management_theme-group'); ?>
        <?php @do_settings_fields('WP_team_management_theme-group'); ?>

        <?php do_settings_sections('wp_team_management_theme'); ?>
          
        <?php @submit_button(); ?>
    </form>
</div>
<?php endif;?>
<?php $setting_heading_font_size= chop(get_option('setting_heading_font_size'),'px');
$setting_Subheading_font_size= chop(get_option('setting_Subheading_font_size'),'px');
$setting_paragraph_font_size=  chop(get_option('setting_paragraph_font_size'),'px');?>
<script type="text/javascript">
jQuery(function() {
    jQuery('.range').attr('readonly',true);
    jQuery( "#slider-range" ).slider({
      range: "min",
      value:<?php echo ($setting_heading_font_size)? $setting_heading_font_size:'14';?> ,
      min: 1,
      max: 100,
      slide: function( event, ui ) {
        jQuery(this).next().val(ui.value +'px');
      }
    });
    //jQuery( ".range" ).val(jQuery( "range" +"px").slider( "value" ) );
  });    
jQuery(function() {
    
    jQuery( "#slider-range2" ).slider({
      range: "min",
      value: <?php echo ($setting_Subheading_font_size)? $setting_Subheading_font_size:'14';?>,
      min: 1,
      max: 100,
      slide: function( event, ui ) {
        jQuery(this).next().val(ui.value +'px');
      }
    });
    //jQuery( ".range" ).val(jQuery( "range" +"px").slider( "value" ) );
  }); 
  jQuery(function() {
    
    jQuery( "#slider-range3" ).slider({
      range: "min",
      value:<?php echo ($setting_paragraph_font_size)? $setting_paragraph_font_size:'14';?>,
      min: 1,
      max: 100,
      slide: function( event, ui ) {
        jQuery(this).next().val(ui.value +'px');
      }
    });
    //jQuery( ".range" ).val(jQuery( "range" +"px").slider( "value" ) );
  });   
</script>
</div>