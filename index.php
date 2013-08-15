<?php
/*
Plugin Name: WP Awesome FAQ
Plugin URI: http://h2cweb.net
Description:Accordion based awesome WordPress FAQ. 
Version: 1.0
Author: Liton Arefin
Author URI: http://www.h2cweb.net
License: GPL2
http://www.gnu.org/licenses/gpl-2.0.html
*/

//Custom FAQ Post Type 
function h2cweb_faq() {
    $labels = array(
        'name'               => _x( 'FAQ', 'post type general name' ),
        'singular_name'      => _x( 'FAQ', 'post type singular name' ),
        'add_new'            => _x( 'Add New', 'book' ),
        'add_new_item'       => __( 'Add New FAQ' ),
        'edit_item'          => __( 'Edit FAQ' ),
        'new_item'           => __( 'New FAQ Items' ),
        'all_items'          => __( 'All FAQ' ),
        'view_item'          => __( 'View FAQ' ),
        'search_items'       => __( 'Search FAQ' ),
        'not_found'          => __( 'No FAQ Items found' ),
        'not_found_in_trash' => __( 'No FAQ Items found in the Trash' ), 
        'parent_item_colon'  => '',
        'menu_name'          => 'FAQ'
    );
    $args = array(
        'labels'        => $labels,
        'description'   => 'Holds FAQ specific data',
        'public'        => true,
        'show_ui'       => true,
        'show_in_menu'  => true,
        'query_var'     => true,
        'rewrite'       => true,
        'capability_type'=> 'post',
        'has_archive'   => true,
        'hierarchical'  => false,
        'menu_position' => 5,
        'supports'      => array( 'title', 'editor'),
        'menu_icon' => get_admin_url(). '/images/press-this.png',  // Icon Path
    );
    register_post_type( 'faq', $args ); 
}
add_action( 'init', 'h2cweb_faq' );



function h2cweb_accordion_shortcode() { 
// Registering the scripts and style
// 

if(!is_admin()){
wp_register_style('h2cweb-jquery-ui-style', 'http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css', false, null);
wp_enqueue_style('h2cweb-jquery-ui-style');
wp_register_script('h2cweb-custom-js', plugins_url('/accordion.js', __FILE__ ), array('jquery-ui-accordion'), '', true);
wp_enqueue_script('h2cweb-custom-js');
}
// Getting FAQs from WordPress FAQ Manager plugin's custom post type questions
$posts = get_posts(array(  
'numberposts' => 10,
'orderby' => 'menu_order',
'order' => 'ASC',
'post_type' => 'faq',
));
	
// Generating Output 
$faq  .= '<div id="accordion">'; //Open the container
foreach ( $posts as $post ) { // Generate the markup for each Question
$faq .= sprintf(('<h3><a href="">%1$s</a></h3><div>%2$s</div>'),
$post->post_title,
$post->post_content
);
}
$faq .= '</div>'; //Close the container
return $faq; //Return the HTML.
}
add_shortcode('faq', 'h2cweb_accordion_shortcode');