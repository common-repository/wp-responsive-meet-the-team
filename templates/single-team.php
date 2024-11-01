<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

get_header(); ?>
<div class="dp-team">
<?php 
$social_html ='';	
if(have_posts()): while(have_posts()) : the_post();
?>
<h1 class="dp-team-title">meet <span>the team - </span> - Circle - Individual</h1>
<div class="dp-layout-circle-single">
<div class="dp-col-4">
	<div class="dp-tm-pic-circle-dtl">
    <?php echo get_the_post_thumbnail( $post->ID,"full") ;?>
	</div>
</div>	
<div class="dp-col-8">
	<h2 class="dp-tm-name"><a href=""><?php the_title();?></a> </h2>
	<span class="dp-tm-position"><?php echo get_post_meta( $post->ID,'team_position',true) ;?></span> 
	<span class="dp-tm-email"><a href="mailto:<?php echo $team_email =get_post_meta( $post->ID,'team_email',true);?>"><?php echo $team_email;?></a></span> 
	<div class="dp-social-buttons">
<?php

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

echo $social_html;
?>
	</div>
	<?php the_content();?>
</div>	
</div>
<?php endwhile; endif;?>
</div>

<?php get_footer(); ?>
