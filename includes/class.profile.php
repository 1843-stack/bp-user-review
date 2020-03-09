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

        $parent_slug = _x('reviews','Slug for Profile','bp-ur');
        $parent_link = trailingslashit( bp_displayed_user_domain() . $parent_slug );

        bp_core_new_nav_item( array( 
            'name' => __('Reviews', 'bp-ur' ), 
            'slug' => $parent_slug,
            'position' => 40,
            'screen_function' => array($this,'show_reviews'), 
            //'default_subnav_slug'=>('posted_reviews','Slug for Profile','bp-ur'),
            'show_for_displayed_user' => true
        ) );
        

        bp_core_new_subnav_item( array( 
            'name' => __('Reviews Posted', 'bp-ur' ),
            'slug' => _x('posted_reviews','Slug for Profile','bp-ur'),
            'parent_slug' =>$parent_slug,
            'parent_url'=>$parent_link,
            'position' => 40,
            'screen_function' => array($this,'show_reviews'), 
            'show_for_displayed_user' => true
        ) );
       

        bp_core_new_subnav_item( array( 
            'name' => __('My Reviews', 'bp-ur' ),
            'slug' => _x('myreviews','Slug for Profile','bp-ur'),
            'parent_slug' =>$parent_slug,
            'parent_url'=>$parent_link,
            'position' => 40,
            'screen_function' => array($this,'show_myreviews'), 
            'show_for_displayed_user' => (bp_is_my_profile() || current_user_can('manage_options'))
        ) );
          bp_core_new_subnav_item( array( 
            'name' => __('Posted On Me', 'bp-ur' ),
            'slug' => _x('postedonme','Slug for Profile','bp-ur'),
            'parent_slug' =>$parent_slug,
            'parent_url'=>$parent_link,
            'position' => 40,
            'screen_function' => array($this,'show_posted'), 
            'show_for_displayed_user' => (bp_is_my_profile() || current_user_can('manage_options'))
        ) );
        
    }

    function show_reviews(){
        //Show mydrive content
        add_action( 'bp_template_title', function(){ _e('Posted Reviews','bp-ur');} );
        add_action( 'bp_template_content', array($this,'get_comment_meta'));
        bp_core_load_template( 'members/single/plugins');
    
    }

    function show_myreviews(){
        add_action( 'bp_template_title', function(){ _e('My Reviews','bp-ur');} );
        add_action( 'bp_template_content', array($this,'get_mycomments'));
        bp_core_load_template( 'members/single/plugins');
    }
    function show_posted(){
        add_action( 'bp_template_title', function(){ _e('My Reviews','bp-ur');} );
        add_action( 'bp_template_content', array($this,'comments'));
        bp_core_load_template( 'members/single/plugins');
    }


    function get_comment_meta(){
       
        $comments_query = new WP_Comment_Query;

        $paged = isset($_GET['paged'])?$_GET['paged']:1;
        $args = array (
                'number'=>10,
                'paged'=>$paged,
                'type'=>'user_review',
                'orderby'=>'comment_date',
                'order'=>'DESC',
                'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key' => 'bp_ur_reviewed_user_id',
                        'value' => bp_displayed_user_id(),
                    ),
                )
            );?>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 60%;
  margin-top:-120px;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
        
<?php

        $comments = $comments_query->query( $args );
echo '<table>
<tr> <th>Name</th>
<th>Message</th>
<th>Rating</th></tr>';
        // The comment loop
        if ( !empty( $comments ) ) {
            foreach ( $comments as $comment ) {
                echo '<tr>';
                echo '<td>' .get_comment_meta( $comment->comment_ID, 'bp_ur_review_title', true ) .'</td>';
                echo '<td>' . $comment->comment_content . '</td>';
                echo '<td>' .get_comment_meta( $comment->comment_ID, 'bp_ur_review_stars', true ) .'</td>'; 
                echo '</tr>';
                echo '<br>';


 }
 echo '</table>';
        }
        
         else {
            echo 'No comments found.';
        }
        if($comments->max_num_pages){
            echo '<form method="get"><div class="reviews_pagination">';
            for($i=1;i<=$comments->max_num_pages;$i++){
                if($i== $paged){
                    echo '<span>'.$i.'</span>';
                }else{
                    echo '<input type="submit" value="'.$i.'" class="button" name="paged" />';
                }
            }
            echo '</div>';
        }

    }//function closed


    function get_mycomments(){
        $comments_query = new WP_Comment_Query;

        if(isset($_GET['edit_comment'])){
            echo do_shortcode('[bp_user_review commentid='.$_GET['edit_comment'].']');
            return;
        }
        $paged = isset($_GET['paged'])?$_GET['paged']:1;
        $args = array (
                'number'=>10,
                'paged'=>$paged,
                'type'=>'user_review',
                'orderby'=>'comment_date',
                'order'=>'DESC',
                'user_id'=>bp_displayed_user_id(),
            );

        $comments = $comments_query->query( $args );

        // The comment loop
        if ( !empty( $comments ) ) {
            foreach ( $comments as $comment ) {
                echo '<div><form method="get"><input type="hidden" name="edit_comment" value="'. $comment->comment_ID.'" /><input type="submit" value="'.__('Update Review','bp-ur').'" /></form>' . $comment->comment_content . '</div>';
            }
        } else {
            echo 'No comments found.';
        }
        if($comments->max_num_pages){
            echo '<form method="get"><div class="reviews_pagination">';
            for($i=1;i<=$comments->max_num_pages;$i++){
                if($i== $paged){
                    echo '<span>'.$i.'</span>';
                }else{
                    echo '<input type="submit" value="'.$i.'" class="button" name="paged" />';
                }
            }
            echo '</div>';
        }
    }
 

}
BP_User_Review_Profile::init();