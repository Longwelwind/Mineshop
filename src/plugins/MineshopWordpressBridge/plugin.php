<?php
/*
Plugin Name: MineshopWordpressBridge
Plugin URI: 
Description: Make a bridge between Wordpress and Mineshop.
Version: 1.0
Author: MsPtibiscuit
Author URI: http://ptibiscuit.pulseheberg.org/
License: GPL2
*/

/*
 * Configuration du plugin.
 *
 * Fin de la configuration du plugin, ne pas touchez !
 */ 

add_action("user_register", "mineshopwb_register");

function mineshopwb_register($user_id) {
  global $wpdb;
  $userdata = get_userdata($user_id);
  $wpdb->insert("", array("user_name" => $userdata->user_login),
                    array("user_password" => md5($userdata->user_pass)),
                    array("user_email" => $userdata->user_email)
                    array("%s", "%s", "%s"));
}
?>