 <?php
/**
 * DASHBOARD API
 *
 * @author      Lavi Tyagi
 * @category    User Review
 * @version     1.0
 */
if (!defined('ABSPATH')) {
    exit();
}
class WPLMS_UserReview_API
{
    public static $instance;
    public static function init()
    {
        if (is_null(self::$instance)) {
            self::$instance = new WPLMS_UserReview_API();
        }
        return self::$instance;
    }
    private function __construct()
    {
        add_action('rest_api_init', array($this, 'register_rest_routes'));
    }

    function register_rest_routes() {
   

        register_rest_route( BP_USER_REVIEW_API_NAMESPACE, '/fetch_user_review/', array(
             array(
                 'methods'             =>  'POST',
                 'callback'            =>  array( $this, 'fetch_user_review' ),
                 'permission_callback'       => array( $this, 'check_permission' ),
             ),
         ));

        register_rest_route( BP_USER_REVIEW_API_NAMESPACE, '/set_user_review/', array(
            array(
                'methods'             =>  'POST',
                'callback'            =>  array( $this, 'set_user_review' ),
                'permission_callback'       => array( $this, 'check_permission' ),
            ),
        ));
    }
    function check_permission($request) {
    	return true;
        //print_r('BP_USER_REVIEW_API_NAMESPACE');
    }

//to fetch data through api this is api functioning

   function fetch_user_review($request){
        $args = json_decode($request->get_body(),true);
        $comments_query = new WP_Comment_Query;
        $comments = $comments_query->query( Array(
            'number'=>10,
                'type'=>'user_review',
                'orderby'=>'comment_date',
                'order'=>'DESC',
                'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key' => 'bp_ur_reviewed_user_id',
                        'value' => $args['user_id'],
                    ),
                )
           ));

                // print_r($comments);
                /*  if ( !empty( $comments ) ) {
               foreach ( $comments as $comment ) {
                
               $comment_meta_title= get_comment_meta( $comment->comment_ID, 'bp_ur_review_title', true );
               $comment_content_data= ($comment->comment_content) ;
               
               $comment_meta_stars= get_comment_meta( $comment->comment_ID, 'bp_ur_review_stars', true );
                
}
        }
        print_r($comment_meta_stars);*/

      if ($comments) {
            return new WP_REST_RESPONSE(array('status'=>1,'comment'=>array('title'=>get_comment_meta($comments[0]->comment_ID,'bp_ur_review_title',true),'stars'=>get_comment_meta($comments[0]->comment_ID,'bp_ur_review_stars',true),'review'=>$comments[0]->comment_content,'comment_id'=>$comments[0]->comment_ID)),200);
               
        } else {
            return new WP_REST_RESPONSE(array('status'=>1,'comment'=>$comments),200);
        }
       // return new WP_REST_RESPONSE(array('status'=>0,'comment'=>[]),200);*/
    }

    function set_user_review($request) {
          
       $args = json_decode($request->get_body(), true);
       print_r($args);
            $id = wp_insert_comment(array(
            'comment_type'=>'user_review',
              'comment_content'=>$args['review'],
                'comment_meta'=>array(
                    'bp_ur_review_title'=>$args['title'],
                    'bp_ur_review_stars'=>$args['stars'],
                    'bp_ur_reviewed_user_id'=>$args['reviewer_id']
                                    ),
                'user_id'=>$user_id
            ));
        
        }

     /*  $status = 1;
         $data = array();

      
    	return new WP_REST_RESPONSE(array('status'=>$status, 'data'=>$data),200);*/
    }

WPLMS_UserReview_API::init(); 