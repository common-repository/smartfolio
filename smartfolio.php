<?php
/*
Plugin Name: SmartFolio
Plugin URI: http://workbold.com/smartFolio
Description: Easily Manage Your Photos.
Version: v1.0
Author: Nolan Dempster
Author URI: http://www.workbold.com
License: GPL2
*/

//Add Stylesheet to Admin Side
function write_sfm_admin_CSS() {
wp_register_style( 'write_admin_CSS', plugins_url('/css/add2adminstyle.css', __FILE__) );

wp_enqueue_style("write_admin_CSS", WP_PLUGIN_DIR . '/smartfolio/css/add2adminstyle.css');
}
add_action('admin_init', 'write_sfm_admin_CSS');

//Register Settings Menu 

//function smf_options() {
	//add_menu_page('smartFolio', 'smartFolio', 'edit_themes', 'smf_plugin_settings.php', 'smf_plugin_settings', plugins_url() . '/smartfolio/images/portfolio.png');
	//add_submenu_page('smf_plugin_settings.php', 'Settings', 'Settings', 'edit_themes', 'smf_plugin_settings.php', 'smf_plugin_settings');
	//add_submenu_page('smf_plugin_settings.php', 'Company', 'Company', 'edit_themes', 'smf_company_info.php', 'smf_company_info');
//}
//add_action('admin_menu', 'smf_options');


//Add smartFolio Custom Post Template

function get_smartfolio_post_type_template($single_template) {
     global $post;

     if ($post->post_type == 'smartfolios') {
          $single_template = dirname( __FILE__ ) . '/theme_files/single-smartfolio.php';
     }
     return $single_template;
}

add_filter( "single_template", "get_smartfolio_post_type_template" ) ;

function smf_album_post() {

	$my_portfolio_page_id = get_option('SMF_album_page');
	$my_portfolio_post = array();
	$my_portfolio_post['post_title'] = 'Portfolio';
	$my_portfolio_post['post_content'] = 'This is a fake page used for the smartFolio "portfolio". This content is not displayed on the page when the plugin is active, but DO NOT DELETE this content unless you know what you are doing.';
 	$my_portfolio_post['post_status'] = 'publish';
	$my_portfolio_post['post_author'] = '1';
	$my_portfolio_post['post_type'] = 'page';
	$my_portfolio_post = wp_insert_post($my_portfolio_post);
	add_option('SMF_album_page', $my_portfolio_page_id);
}

register_activation_hook( __FILE__, 'smf_album_post');

// delete subscription page
function smf_uninstall() {

    wp_delete_post( get_option('SMF_album_page') );
    }

register_deactivation_hook( __FILE__, 'smf_uninstall' );


//add myAccount custom post template

function get_smf_album_template($page_template) {
     global $post;

     if ($post->post_name == 'portfolio') {
          $page_template = dirname( __FILE__ ) . '/theme_files/single-album.php';
     }
     return $page_template;
}

add_filter( "page_template", "get_smf_album_template" ) ;




//Add all the rest of the required files

require_once('smartfolio_type.php');

