<?php
/*
Plugin Name: BP User Review
Plugin URI: http://www.VibeThemes.com/bp_user_review
Description: Review Users in BuddyPress by VibeThemes
Version: 1.0
Requires at least: WP 5.2, BuddyPress 5.0 
Tested up to: 5.3.2
License: GPLv2
Author: VibeThemes 
Author URI: http://www.VibeThemes.com
Network: false
Text Domain: bp_ur
Domain Path: /languages/
*/

define( 'BP_USER_REVIEW_VERSION', '1.0' );
define( 'BP_USER_REVIEW_API_NAMESPACE', 'bpur/v1' );

require_once( trailingslashit( plugin_dir_path( __FILE__ ) ) . 'includes/class.settings.php' );
require_once( trailingslashit( plugin_dir_path( __FILE__ ) ) . 'includes/class.profile.php' );
require_once( trailingslashit( plugin_dir_path( __FILE__ ) ) . 'includes/class.init.php' );
require_once( trailingslashit( plugin_dir_path( __FILE__ ) ) . 'includes/class.api.php' );

add_action('plugins_loaded','bp_user_review_translations');

function bp_user_review_translations(){
    $locale = apply_filters("plugin_locale", get_locale(), 'bp_ur');
    $lang_dir = dirname( __FILE__ ) . '/languages/';
    $mofile        = sprintf( '%1$s-%2$s.mo', 'bp_ur', $locale );
    $mofile_local  = $lang_dir . $mofile;
    $mofile_global = WP_LANG_DIR . '/plugins/' . $mofile;

    if ( file_exists( $mofile_global ) ) {
        load_textdomain( 'bp_ur', $mofile_global );
    } else {
        load_textdomain( 'bp_ur', $mofile_local );
    }   
}