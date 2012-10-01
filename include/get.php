<?php 
/**
 * CodePeople Post Map 
 * Version: 1.0.1
 * Author: CodePeople
 * Plugin URI: http://wordpress.dwbooster.com
 * This file is called from AJAX for get geocode information from wordpress admin section
*/

include "../../../../wp-load.php";
if(isset($_REQUEST['filter'])){
	// Uncomment the next code if your website is behind a proxy
	/*
	define( 'WP_PROXY_HOST', 'hostname or ip number' );
	define( 'WP_PROXY_PORT', 'port number' );
	define( 'WP_PROXY_USERNAME', 'username' );
	define( 'WP_PROXY_PASSWORD', 'password' );
	*/
	
	$rtnObj = wp_remote_get($_REQUEST['filter'], array('timeout' => 120));
			
	if(!is_wp_error($rtnObj)){
		print( $rtnObj['body']);
	}
}
?>