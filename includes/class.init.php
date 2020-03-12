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

     // print_r(rest_url());
      //http://localhost/wordpress1/wp-json/

    	$defaults = array(
    		'reviewee_id'=>get_current_user_id(),
    		'reviewer_id'=>get_current_user_id(),
            'commentid'=>0,
    	);

    	$args = wp_parse_args($atts,$defaults);
    	extract($args);
        //print_r($args);

    
      echo '<div class="bp_user_review"></div>';
      wp_enqueue_script('bp_user_review',plugins_url('../assets/js/bp-user-review.js',__FILE__),array('wp-element'),BP_USER_REVIEW_VERSION,true);

      wp_enqueue_style('bp_user_review_css',plugins_url('../assets/bp-user-review/src/index.css',__FILE__),array('dashicons'),BP_USER_REVIEW_VERSION);
      wp_localize_script('bp_user_review','bp_user_review',apply_filters('bp_user_review',array(
      'settings'      => $instance,
      'api'           => rest_url(BP_USER_REVIEW_API_NAMESPACE),
      'reviewer_id'   => $reviewer_id,
      'reviewee_id'   => $reviewee_id,
    )));






      return '<div class="bp_user_review" data-user="'.$reviewer_id.'" data-reviewed="'.$reviewee_id.'"></div>';
    	//return $this->user_review_form($reviewee_id,$reviewer_id,$commentid);
    }


    function user_review_form($reviewed_id,$user_id,$commentID=0){

        $content = array(
            'bp_ur_review_title'=>'',
            'comment_content'=>'',
            'bp_ur_stars'=>0
        );

        if(isset($_GET['edit_comment'])){
          //  print_r('##########1');

            $args = array('comment__in'=>[$commentID]); 
            //print_r($args);
            $comment_query = new WP_Comment_Query;
            $comments = $comment_query->query($args);
            //echo'<pre>'; 
            // print_r($comments);
              
            // $comment_content = "Test Comment  Content";

           // print_r($comments);
            $new_comment_arr = array(
                "comment_ID" => $comments[0]->comment_ID,
                "comment_content" => $_POST['bp_ur_review_message'],
                'comment_meta'=>array(
                    'bp_ur_review_title'=>$_POST['bp_ur_review_title'],
                    'bp_ur_review_stars'=>$_POST['bp_ur_review_stars'],
                
                ));
            wp_update_comment($new_comment_arr);
            //print_r($comment_query->query($args));

        } else if(!empty($_POST['bp_ur_submit_review'])){
            //print_r('##########2');

    		
    		$id = wp_insert_comment(array(
    			'comment_type'=>'user_review',
    		  'comment_content'=>$_POST['bp_ur_review_message'],
            	'comment_meta'=>array(
    				'bp_ur_review_title'=>$_POST['bp_ur_review_title'],
    				'bp_ur_review_stars'=>$_POST['bp_ur_review_stars'],
    				'bp_ur_reviewed_user_id'=>$reviewed_id
    			),
    			'user_id'=>$user_id
    		));
        
    	}else{
    		$args = array('comment__in'=>[$commentID]);	
            //print_r($args);
			$comment_query = new WP_Comment_Query;
            $comments = $comment_query->query($args);
			if($comments){
                $content['comment_content'] = $comments[0]->comment_content;
            } 
                    
 

/*if(!empty($_POST['edit_comment'])){
            
             $id = wp_update_comment(array(
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
             $args = array('comment__in'=>[$commentID]); 
             print_r($args);
             $comment_query = new WP_Comment_Query;
             $comments = $comment_query->query($args);
             if($comments){
                 $content['comment_content'] = $comments[0]->comment_content;
            }*/
        




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
	    			<textarea placeholder="<?php _e('Review Message','bp_ur'); ?>" name="bp_ur_review_message"><?php echo $content['comment_content']; ?></textarea>
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
