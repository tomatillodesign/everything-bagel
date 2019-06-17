<?php
/*
Plugin Name: Everything Bagel
Description: A Little Bit of Everything &middot; Customizations for DataWorksNC
Author: Alex & Andrea (Code the Dream) | Chris (Tomatillo Design)
Author URI: http://www.codethedream.org
Version: 1.0
Text Domain: everything-bagel
*/


/* Start Adding Functions Below this Line */

// Enqueue custom JS
add_action( 'wp_enqueue_scripts', 'clb_enqueue_custom_scripts' );
function clb_enqueue_custom_scripts() {

     if( is_page() ) {

          wp_enqueue_script( 'ctd-custom-scripts', plugins_url() . '/everything-bagel/js/hello-world.js', array('jquery') );
          wp_enqueue_script( 'staff-card-modal', plugins_url() . '/everything-bagel/js/staff-card-modal.js', array('jquery'), '1.0', true  );

     }

     if( is_page('services') ) {

          wp_enqueue_script( 'icon-card-script', plugins_url() . '/everything-bagel/js/icon-card-script.js', array('jquery'), '1.0', true );

     }

}






add_action( 'init', 'clb_register_resource_custom_post_type_init' );
/**
 * Register a custom Resource post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function clb_register_resource_custom_post_type_init() {
	$labels = array(
		'name'               => _x( 'Resources', 'post type general name', 'everything-bagel' ),
		'singular_name'      => _x( 'Resource', 'post type singular name', 'everything-bagel' ),
		'menu_name'          => _x( 'Resources', 'admin menu', 'everything-bagel' ),
		'name_admin_bar'     => _x( 'Resource', 'add new on admin bar', 'everything-bagel' ),
		'add_new'            => _x( 'Add New', 'resource', 'everything-bagel' ),
		'add_new_item'       => __( 'Add New Resource', 'everything-bagel' ),
		'new_item'           => __( 'New Resource', 'everything-bagel' ),
		'edit_item'          => __( 'Edit Resource', 'everything-bagel' ),
		'view_item'          => __( 'View Resource', 'everything-bagel' ),
		'all_items'          => __( 'All Resources', 'everything-bagel' ),
		'search_items'       => __( 'Search Resources', 'everything-bagel' ),
		'parent_item_colon'  => __( 'Parent Resources:', 'everything-bagel' ),
		'not_found'          => __( 'No resources found.', 'everything-bagel' ),
		'not_found_in_trash' => __( 'No resources found in Trash.', 'everything-bagel' )
	);

	$args = array(
		'labels'             => $labels,
                'description'        => __( 'Custom Resources added by DataWorksNC.', 'everything-bagel' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'resource' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
          'menu_icon'          => 'dashicons-media-interactive',
          'show_in_rest'       => true,
          'rest_base'          => 'resource',
          'rest_controller_class' => 'WP_REST_Posts_Controller',
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
	);

	register_post_type( 'resource', $args );
}






/**
 * Register a Resource Category custom taxonomy, with REST API support
 *
 * Based on example at: https://codex.wordpress.org/Function_Reference/register_taxonomy
 */
add_action( 'init', 'clb_register_resource_custom_taxonomy', 30 );
function clb_register_resource_custom_taxonomy() {

  $labels = array(
    'name'              => _x( 'Resource Categories', 'taxonomy general name' ),
    'singular_name'     => _x( 'Resource Category', 'taxonomy singular name' ),
    'search_items'      => __( 'Search Resource Categorys' ),
    'all_items'         => __( 'All Resource Categorys' ),
    'parent_item'       => __( 'Parent Resource Category' ),
    'parent_item_colon' => __( 'Parent Resource Category:' ),
    'edit_item'         => __( 'Edit Resource Category' ),
    'update_item'       => __( 'Update Resource Category' ),
    'add_new_item'      => __( 'Add New Resource Category' ),
    'new_item_name'     => __( 'New Resource Category Name' ),
    'menu_name'         => __( 'Resource Category' ),
  );

  $args = array(
    'hierarchical'          => true,
    'labels'                => $labels,
    'show_ui'               => true,
    'show_admin_column'     => true,
    'query_var'             => true,
    'rewrite'               => array( 'slug' => 'resource-category' ),
    'show_in_rest'          => true,
    'rest_base'             => 'resource-category',
    'rest_controller_class' => 'WP_REST_Terms_Controller',
  );

  register_taxonomy( 'resource-category', array( 'resource' ), $args );

}


//* Change the footer text

add_filter('genesis_footer_creds_text', 'clb_footer_creds_filter');
function clb_footer_creds_filter( $creds ) {

     $blog_title = get_bloginfo();

     $creds = 'Copyright [footer_copyright] <a href="' . site_url() . '">' . $blog_title . '</a> &middot; All Rights Reserved &middot; Website by <a href="http://www.codethedream.org/" target="_blank" title="Real Talent + Real Experience">Code the Dream</a> & <a href="http://www.tomatillodesign.com/" title="Amazing, Affordable Websites for Nonprofits" target="_blank">Tomatillo Design</a>';
     return $creds;

}







// Add Read More Link to Auto Excerpts
add_filter('excerpt_more', 'get_read_more_link');
add_filter( 'the_content_more_link', 'get_read_more_link' );
function get_read_more_link() {

     return '...&nbsp;<a href="' . get_permalink() . '">Read&nbsp;More&nbsp;&#x2192;</a>';

}



// Add Read More Link to Manual Excerpts
add_filter('get_the_excerpt', 'manual_excerpt_more');
function manual_excerpt_more($excerpt) {
	$excerpt_more = '';
		if( has_excerpt() ) {
		$excerpt_more = '... <a href="'.get_permalink().'">Read&nbsp;More&nbsp;&#x2192;</a>';
		}
		return $excerpt . $excerpt_more;
}


// Remove gravatar from line 70 in single.php
add_action( 'genesis_before', 'clb_remove_gravatar', 16 );
function clb_remove_gravatar() {
     remove_action( 'genesis_entry_header', 'monochrome_gravatar_post', 7 );
}

// Display Credit Text
add_action('genesis_before_content_sidebar_wrap','clb_add_pic_credits');
function clb_add_pic_credits() {

  $pic_credit = get_field('picture_credits');

  if ( is_singular() ) {
    echo '<div class="picCreditText">' . $pic_credit . '</div>';

  }
}

//Guest Author
add_filter( 'the_author', 'guest_author_name' );
add_filter( 'get_the_author_display_name', 'guest_author_name' );

function guest_author_name( $name ) {
global $post;

$author = get_post_meta( $post->ID, 'guest_author', true );

if ( $author )
$name = $author;

return $name;
}
add_action( 'init', 'clb_register_event_custom_post_type_init' );
/**
 * Register a custom event post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function clb_register_event_custom_post_type_init() {
	$labels = array(
		'name'               => _x( 'Events', 'post type general name', 'everything-bagel' ),
		'singular_name'      => _x( 'Event', 'post type singular name', 'everything-bagel' ),
		'menu_name'          => _x( 'Events', 'admin menu', 'everything-bagel' ),
		'name_admin_bar'     => _x( 'Event', 'add new on admin bar', 'everything-bagel' ),
		'add_new'            => _x( 'Add New', 'Event', 'everything-bagel' ),
		'add_new_item'       => __( 'Add New Event', 'everything-bagel' ),
		'new_item'           => __( 'New Event', 'everything-bagel' ),
		'edit_item'          => __( 'Edit Event', 'everything-bagel' ),
		'view_item'          => __( 'View Event', 'everything-bagel' ),
		'all_items'          => __( 'All Events', 'everything-bagel' ),
		'search_items'       => __( 'Search Events', 'everything-bagel' ),
		'parent_item_colon'  => __( 'Parent Events:', 'everything-bagel' ),
		'not_found'          => __( 'No Events found.', 'everything-bagel' ),
		'not_found_in_trash' => __( 'No Events found in Trash.', 'everything-bagel' )
	);

	$args = array(
		'labels'             => $labels,
                'description'        => __( 'Custom events added by DataWorksNC.', 'everything-bagel' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'event' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
          'menu_icon'          => 'dashicons-calendar',
          'show_in_rest'       => true,
          'rest_base'          => 'event',
          'rest_controller_class' => 'WP_REST_Posts_Controller',
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
	);

	register_post_type( 'event', $args );
}






/**
 * Register a event Category custom taxonomy, with REST API support
 *
 * Based on example at: https://codex.wordpress.org/Function_Reference/register_taxonomy
 */
add_action( 'init', 'clb_register_event_custom_taxonomy', 30 );
function clb_register_event_custom_taxonomy() {

  $labels = array(
    'name'              => _x( 'Event Categories', 'taxonomy general name' ),
    'singular_name'     => _x( 'Event Category', 'taxonomy singular name' ),
    'search_items'      => __( 'Search Event Categorys' ),
    'all_items'         => __( 'All Event Categorys' ),
    'parent_item'       => __( 'Parent Event Category' ),
    'parent_item_colon' => __( 'Parent Event Category:' ),
    'edit_item'         => __( 'Edit Event Category' ),
    'update_item'       => __( 'Update Event Category' ),
    'add_new_item'      => __( 'Add New Event Category' ),
    'new_item_name'     => __( 'New Event Category Name' ),
    'menu_name'         => __( 'Event Category' ),
  );

  $args = array(
    'hierarchical'          => true,
    'labels'                => $labels,
    'show_ui'               => true,
    'show_admin_column'     => true,
    'query_var'             => true,
    'rewrite'               => array( 'slug' => 'Event-category' ),
    'show_in_rest'          => true,
    'rest_base'             => 'event-category',
    'rest_controller_class' => 'WP_REST_Terms_Controller',
  );

  register_taxonomy( 'event-category', array( 'event' ), $args );

}

function my_acf_init() {
    
    acf_update_setting('google_api_key', 'AIzaSyAi6E68dyeOC_vuQsNUoIQU1pC_UU8_6LM');
}

add_action('acf/init', 'my_acf_init');

