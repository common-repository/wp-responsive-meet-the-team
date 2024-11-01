<?php
get_header();
?>
<?php if(have_posts()): while(have_posts()): the_post(); ?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>

<h1 class="entry-title"><a title="Permanent link to <?php the_title_attribute(); ?>" rel="bookmark" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>

<div class="entry-content">
<?php

$layout =	get_option('setting_layout');
$setting_columns =	get_option('setting_columns');
echo do_shortcode('[Team-manager layout="'.$layout.'" post_per_page="-1" columns="'.$setting_columns.'"]' );
wp_enqueue_style( $layout, plugin_dir_url( __FILE__ ) . '../assets/layouts/'.$layout.'.css','',false );

?>

<?php
wp_link_pages();
?>
</div>

<?php the_tags(); ?>

<?php the_category(); ?>

<address class="vcard author">
<span class="n"><?php the_author(); ?></span>
</address>

<abbr class="published" title="<?php the_time( 'Y-m-d\TH:i' ); ?>"><?php the_date(); ?> @ <?php the_time(); ?></abbr>

<a href="<?php trackback_url(); ?>"><?php _e( 'Trackback URL' ); ?></a>

<?php comments_popup_link(); ?>

<?php edit_post_link(); ?>
</div>
<?php endwhile; endif;?>
<?php get_footer();