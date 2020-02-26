<?php
/**
 * Initialize BP YUser Review
 *
 * @author      VibeThemes
 * @category    Init
 * @package     BP User Review
 * @version     1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class BP_User_Review_Settings{

    public static $instance;
    public static function init(){
    if ( is_null( self::$instance ) )
        self::$instance = new BP_User_Review_Settings();

        return self::$instance;
    }

    private function __construct(){
    	add_action('admin_menu',array($this,'add_menu'));
    	
    }

    function add_menu(){
    	add_users_page( __('User Reviews Settings','bp_ur'), __('User Reviews','bp_ur'), 'manage_options','bp-user-reviews',array($this,'add_meu_page'), 100 );
    }

    function add_meu_page(){
    	echo '<h2>'.__('BuddyPress User Reviews Settings','bp_ur').'</h2>';
    	global $wp_roles;
    	$settings = get_option('bp_user_reviews');

    	if(!empty($_POST)){
    		$settings = $_POST;
    	}
    	$this->save();
    	?>
    	<form method="post">
    		<div style="display:grid;grid-template-columns:180px 1fr;grid-gap:15px;">
    			<label><?php _e('Who can be reviewed','bp_ur'); ?></label><span>
    				<select name="user_who_is_reviewed">
    						<option value="all" <?php selected($settings['user_who_is_reviewed'],'all'); ?>><?php _e('All Members','bp_ur'); ?></option>
    						<?php
    							foreach($wp_roles->roles as $role=>$values){
    								?>
    								<option value="<?php echo $role; ?>" <?php selected($settings['user_who_is_reviewed'],$role); ?>><?php echo$values['name'];?></option>
    								<?php
    							}
    							do_action('bp_user_review_who_is_reviewed',$settings);
    						?>
    				</select>
    			</span>
    			<label><?php _e('Who can review','bp_ur'); ?></label><span>
    				<select name="user_who_can_review">
    						<option value="all" <?php selected($settings['user_who_is_reviewed'],'all'); ?>><?php _e('All Members','bp_ur'); ?></option>
    						<?php
    							foreach($wp_roles->roles as $role=>$values){
    								?>
    								<option value="<?php echo $role; ?>" <?php selected($settings['user_who_is_reviewed'],$role); ?>><?php echo$values['name'];?></option>
    								<?php
    							}
    							do_action('bp_user_review_who_can_review',$settings);
    						?>
    				</select>
    			</span>
    			<label><?php _e('Show Reviews in Profile','bp_ur'); ?></label><span><input type="checkbox" name="show_review_in_profile" value="1" <?php checked($settings['show_review_in_profile'],1); ?>></span>
    			<label><?php _e('Show Reviews in Profile Home','bp_ur'); ?></label><span><input type="checkbox" name="show_review_in_profile_home" value="1" <?php checked($settings['show_review_in_profile_home'],1); ?>></span>
    			<label><?php _e('Show Review Form in Profile','bp_ur'); ?></label><span><input type="checkbox" name="show_review_form_in_profile" value="1" <?php checked($settings['show_review_form_in_profile'],1); ?>></span>
    			<input type="submit" class="button-primary" value="<?php _e('Submit','bp_ur'); ?>">
    		</div>
    		<?php wp_nonce_field('security','security'); ?>
    	</form>
    	<?php
    }


    function save(){

    	if(!empty($_POST)){
			if(wp_verify_nonce($_POST['security'],'security')){
				unset($_POST['_wp_http_referer']);
				unset($_POST['security']);
				update_option('bp_user_reviews',$_POST);
				echo '<div class="notice notice-success is-dismissible"><p><strong>'.__('Settings Saved !','bp_ur').'</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
			}
    	}
    }
}

BP_User_Review_Settings::init();
