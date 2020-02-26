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

class BP_User_Review_Init{

    public static $instance;
    public static function init(){
    if ( is_null( self::$instance ) )
        self::$instance = new BP_User_Review_Init();

        return self::$instance;
    }

    private function __construct(){
    	
    	add_shortcode('bp_user_review',array($this,'user_review'));
    }


    function user_review($atts=array(),$content=null){

    	$defaults = array(
    		'reviewee_id'=>get_current_user_id(),
    		'reviewer_id'=>get_current_user_id()
    	);

    	$args = wp_parse_args($atts,$defaults);
    	extract($args);
    	return $this->user_review_form($reviewee_id,$reviewer_id);
    }

    function user_review_form($reviewed_id,$user_id){

    	if(!empty($_POST['bp_ur_submit_review'])){
    		
    		$id = wp_insert_comment(array(
    			'comment_content'=>$_POST['bp_ur_review_message'],
    			'comment_type'=>'user_review',
    			'comment_meta'=>array(
    				'bp_ur_review_title'=>$_POST['bp_ur_review_title'],
    				'bp_ur_review_stars'=>$_POST['bp_ur_review_stars'],
    				'bp_ur_reviewed_user_id'=>$reviewed_id
    			),
    			'user_id'=>$user_id
    		));
    	}else{
    		$args = array(
    			'comment_type'=>'user_review',
    			'user_id'=>$user_id,
			    'meta_query' => array(
			        array(
			            'key' => 'bp_ur_reviewed_user_id',
			            'value' => $reviewed_id
			        ),
			    )
			 );
			$comment_query = new WP_Comment_Query( $args );

			// if(!empty($comment_query->comments)){
			// 	foreach($$comment_query->comments as $comment){
			// 		//fill values To do
			// 	}
			// }
    	}
    	?>
    	<div class="bp_user_review">
			<form method="post">
	    		<div class="bp_ur_review_title">
	    			<input type="text" name="bp_ur_review_title" placeholder="<?php _e('Review Title','bp_ur'); ?>" value="" />
	    		</div>
	    		<div class="bp_ur_review_stars">
					<div class="bp_ur_stars">
						<label for="bp_ur_stars_1"><input type="radio" id="bp_ur_stars_1" name="bp_ur_review_stars" value="1" /><span>☆</span></label>
						<label for="bp_ur_stars_2"><input type="radio" id="bp_ur_stars_2" name="bp_ur_review_stars" value="2" /><span>☆</span></label>
						<label for="bp_ur_stars_3"><input type="radio" id="bp_ur_stars_3" name="bp_ur_review_stars" value="3" /><span>☆</span></label>
						<label for="bp_ur_stars_4"><input type="radio" id="bp_ur_stars_4" name="bp_ur_review_stars" value="4" /><span>☆</span></label>
						<label for="bp_ur_stars_5"><input type="radio" id="bp_ur_stars_5" name="bp_ur_review_stars" value="5" /><span>☆</span></label>
					</div>
	    		</div>
	    		<div class="bp_ur_review_message">
	    			<textarea placeholder="<?php _e('Review Message','bp_ur'); ?>" name="bp_ur_review_message"></textarea>
	    		</div>
    			<?php wp_nonce_field('security','security'); ?>
    			<input type="submit" value="<?php _e('Post Review','bp_ur'); ?>" name="bp_ur_submit_review" />
    		</form>
    		<style>
			.bp_ur_stars > label:hover>span:before,
			.bp_ur_stars > label>input:checked+span:before {
			   content: "\2605";
			   position: absolute;
			}.bp_ur_stars input{display:none;}
    		</style>
    	</div>
    	<?php
    }
}

BP_User_Review_Init::init();
