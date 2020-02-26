<?php
/**
 * Profile BP YUser Review
 *
 * @author      VibeThemes
 * @category    Init
 * @package     BP User Review
 * @version     1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class BP_User_Review_Profile{

    public static $instance;
    public static function init(){
    if ( is_null( self::$instance ) )
        self::$instance = new BP_User_Review_Profile();

        return self::$instance;
    }

    private function __construct(){
    	add_action( 'bp_setup_nav', array($this,'setup_nav' ));
    }

    function setup_nav(){
        bp_core_new_nav_item( array( 
            'name' => __('Reviews', 'bp-ur' ), 
            'slug' => _x('reviews','Slug for Profile','bp-ur'),
            'position' => 40,
            'screen_function' => array($this,'show_reviews'), 
            'show_for_displayed_user' => true
        ) );
    }

    function show_reviews(){
        //Show mydrive content
        add_action( 'bp_template_title', function(){ _e('My Reviews','bp-ur');} );
        add_action( 'bp_template_content', array($this,'reviews'));
        bp_core_load_template( 'members/single/plugins');
    
    }

    function reviews(){

        $user_id = bp_displayed_user_id();
        print_r('#####'.$user_id);

    }
}
BP_User_Review_Profile::init();