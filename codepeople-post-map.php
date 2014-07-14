<?php
/*
Plugin Name: CP Google Maps 
Version: 1.0.1
Author: <a href="http://www.codepeople.net">CodePeople</a>
Plugin URI: http://wordpress.dwbooster.com/content-tools/codepeople-post-map
Description: CP Google Maps Allows to associate geocode information to posts and display it on map. CP Google Maps display the post list as markers on map. The scale of map is determined by the markers, to display distant points is required to load a map with smaller scales. To get started: 1) Click the "Activate" link to the left of this description. 2) Go to your <a href="options-general.php?page=codepeople-post-map.php">CP Google Maps configuration</a> page and configure the maps settings. 3) Go to post edition page to enter the geolocation information.
 */

define('CPM_PLUGIN_DIR', WP_PLUGIN_DIR."/".dirname(plugin_basename(__FILE__)));
define('CPM_PLUGIN_URL', plugins_url()."/".dirname(plugin_basename(__FILE__)));

require (CPM_PLUGIN_DIR.'/include/functions.php');

// Create  a CPM object that contain main plugin logic
add_action( 'init', 'cpm_init');
add_action( 'admin_init', 'cpm_admin_init' );

register_activation_hook(__FILE__, 'codepeople_post_map_regiter');

if(!function_exists('codepeople_post_map_regiter')){
    function codepeople_post_map_regiter(){
        $cpm_master_obj = new CPM;
        $cpm_master_obj->set_default_configuration(true);
    }
}

function cpm_admin_init(){
	global $cpm_master_obj;
	
	load_plugin_textdomain( 'codepeople-post-map', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );	
	
	// Insert the map's insertion form below the posts and pages editor
	$form_title = __('Associate an address to the post for Google Maps association', 'codepeople-post-map');
	add_meta_box('codepeople_post_map_form', $form_title, array($cpm_master_obj, 'insert_form'), 'post', 'normal');
    add_meta_box('codepeople_post_map_form', $form_title, array($cpm_master_obj, 'insert_form'), 'page', 'normal');
	
	add_action('save_post', array(&$cpm_master_obj, 'save_map'));
	
	$plugin = plugin_basename(__FILE__);
	add_filter('plugin_action_links_'.$plugin, array(&$cpm_master_obj, 'customizationLink'));
		
}

function cpm_init(){
	global $cpm_master_obj, $cpm_objs;
	$cpm_master_obj = new CPM;
    $cpm_objs = array();
    
	add_shortcode('codepeople-post-map', array(&$cpm_master_obj, 'replace_shortcode'));
	add_action('the_post', 'cpm_populate_points' );
	add_action( 'wp_footer', 'cpm_print_points'  );	
    add_action( 'loop_start', 'cpm_loop_start' );
    add_action( 'loop_end', 'cpm_loop_end' );
}

if( !function_exists( 'cpm_loop_start' ) )
    {
        function cpm_loop_start()
        {
            global $cpm_in_loop;
            $cpm_in_loop = true;
        }
    }
if( !function_exists( 'cpm_loop_end' ) )
    {
        function cpm_loop_end()
        {
            global $cpm_in_loop;
            $cpm_in_loop = false;
        }
    }

if( !function_exists( 'cpm_populate_points' ) ){
	function cpm_populate_points( $post ){
		global $cpm_master_obj;
		$cpm_master_obj->populate_points( $post->ID );
	}
}

if( !function_exists( 'cpm_print_points' ) ){
	function cpm_print_points(){
		global $cpm_objs, $cpm_master_obj;
        
        foreach( $cpm_objs as $cpm_obj ){
            if( !empty( $cpm_obj->multiple ) )
            {
                $cpm_obj->points = $cpm_master_obj->points;
            }
			$cpm_obj->print_points();
		}
	}
}

if (!function_exists("cpm_settings")) { 
		function cpm_settings() { 
			global $cpm_master_obj; 
			
			if (!isset($cpm_master_obj)) { 
				return; 
			} 
			
			if (function_exists('add_options_page')) { 
				add_options_page('CodePeople Post Map', 'CodePeople Post Map', 'manage_options', basename(__FILE__), array(&$cpm_master_obj, 'settings_page')); 
			} 
		}    
	}
	
add_action('admin_enqueue_scripts', array(&$cpm_master_obj, 'load_admin_resources'), 1);
add_action('wp_head', array(&$cpm_master_obj, 'load_header_resources'), 10);
add_action('admin_menu', 'cpm_settings');

?>