<?php
/*
 * Plugin Name: Disqus Recent Comments Widget
 * Description: Add a widget to display recent comments from disqus
 * Author: Deus Machine LLC
 * Version: 1.0
 * Author URI: http://deusmachine.com
 * Ported to WordPress by: Andrew Bartel, web developer for Deus Machine
 * Original Methodology and Script by: Aaron J. White http://aaronjwhite.org/
 * 
 */

class disqus_recent_comments_widget extends WP_Widget {
    
	public function __construct() {
		$widget_ops = array( 'classname' => 'deus_disqus_recent_comments_widget', 'description' => __( 'Display Recent Posts From Disqus' , 'disqus_rcw' ) );
		$control_ops = array( 'width' => 300, 'height' => 230 );
		parent::__construct( 'disqus_recent_comments', __( 'Disqus Recent Comments' , 'disqus_rcw' ), $widget_ops, $control_ops);
    }
	
	public function widget($args, $instance) {
		
		try {
			$api_key = get_option( 'disqus_rcw_api_key' );
			
			$forum_name = get_option( 'disqus_rcw_forum_name' );
			$comment_limit = $instance['comment_limit'];
			if(!$comment_limit) $comment_limit = 5;
			
			//comma delimited list  of author names."John Doe,Aaron J. White,third" (Not Usernames)
			$filter_users = $instance['filter_users'];
			
			$date_format = get_option( 'disqus_rcw_date_format' );
			if(!$date_format) $date_format = 'n/j/Y';
			
			$comment_length = $instance['comment_length'];
			if(!$comment_length) $comment_length = 200;
			
			$api_version = '3.0';
			
			$resource = 'posts/list';
			$output_type = 'json';
			
			$style_params = array(
				"comment_limit" => $comment_limit,
				"date_format" => $date_format,
				"comment_length" => $comment_length,
				"filter_users" =>$filter_users
				);
			  
			$style_params = apply_filters( 'disqus_rcw_style_parameters' , $style_params );
			
		    //put request parameters in an array
		    $disqus_params = array( 
		    	"api_key" => $api_key,
		    	"forum" => $forum_name,
		    	"include" => "approved",
		    	"limit" =>  $comment_limit * 3
				);
			
			$disqus_params = apply_filters( 'disqus_rcw_disqus_parameters' , $disqus_params );
			  
		    //Create base request string
		    $url = "http://disqus.com/api/" . $api_version . "/" . $resource . "." . $output_type;
		    //add parameters to request string
		    $request = $this->add_query_str( $url , $disqus_params );
			
		    // get response with finished request url
		    $response = $this->file_get_contents_curl( $request );
			
		    //check repsonse
		    if( $response != false ) {
		    	// convert response to php object 
		    	$response = @json_decode($response, true);
		   		// get comment items from response
		      	$comments = $response["response"];
		      	//check comment count
		      	if(count($comments) > 0) {
		      		if($comments != 'You have exceeded your hourly limit of requests') {
			      		$this->echo_comments(
				                $comments, 
				                $api_key,
				                $style_params
				              );
					}
					else
					{
						$this->no_comments(true);
					}
			    }
			    else
			    {
			      	$this->no_comments();
			    }
			}
		    else
		    {
		      $this->no_comments(); 
		    }
		
		}
		catch(Exception $e)
		{
		  	$this->no_comments();
		}
		  
    }
    
	protected function shorten_comment($comment, $comment_length) {	
		if($comment_length != 0) {
		  	if(strlen($comment) > $comment_length) {
		    
		    $comment = preg_replace(
		                  '/\s+?(\S+)?$/', '', 
		                  substr($comment, 0, $comment_length+1)
		                )."...";
			}
		}
		return $comment;
	}

	protected function get_thread_info( $thread_id, $api_key, $api_version = "3.0", $resource = "threads/details", $output_type = "json" ) {
	    $dq_request ="http://disqus.com/api/".$api_version."/".$resource.".".$output_type;
	    $dq_parameter = array( 
	                "api_key" => $api_key,
	                "thread" => $thread_id
	              );
	    $dq_request = $this->add_query_str($dq_request, $dq_parameter);
	
	    // convert response to php object 
	    $dq_response= $this->file_get_contents_curl($dq_request);
	    if($dq_response !== false) {
	      $dq_response = @json_decode($dq_response, true);
	      $dq_thread = $dq_response["response"];
	      return $dq_thread;
	    }
	    else
	    {
	      $dq_thread = array(
	                title=> "Article not found",
	                link => "#"
	              );
	      return $dq_thread;
	    }
	}

	protected function add_query_str($base_url,$parameters) {
	  	$i=0;
	    if (count($parameters) > 0) {
	    	$new_url = $base_url;
	     	foreach($parameters as $key => $value) { 
	        	if($i == 0) $new_url .="?".$key."=".$value;
	        	else $new_url .="&".$key."=".$value;
	        	$i +=1;
	      	}
	      
	      	return $new_url;
	    }
	    else return $base_url;
	}

	protected function no_comments( $comment = false ) {
	    echo '<div id="disqus_rcw_comment_wrap"><span id="disqus_rcw_no_comments">No Recent Comments Found</span>';
	    if( $comment === true ) echo '<!-- hourly limit reached -->';
	    echo '</div>';
	}

	protected function file_get_contents_curl( $url ) {
	    //Source: http://www.codeproject.com/Questions/171271/file_get_contents-url-failed-to-open-stream
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);  // don't use cached ver. of url 
		curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1); // seriously...don't use cached ver. of url
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
    }
	
	public function disqus_rcw_trim(&$val) {
		$val = trim($val);
	}

	protected function echo_comments($comment, $api_key, $style_params) {
		//basic counter
	    $comment_counter = 0;
	    //filtered user array
	    $filtered_users = explode(",",$style_params["filter_users"]);
	    //create html string
	    $recent_comments = '<div id="disqus_rcw_title"><h4 class="widgettitle">Recent comments</h4>';
		
		do_action( 'disqus_rcw_before_comments_loop' );
		
		if($comment != 'Invalid API key') {
		
		    foreach($comment as $comment_obj) {	      
		      	// first skip to next if user is filtered
		      	$author_name = $comment_obj["author"]["name"];
		      	if( !empty( $filtered_users ) )
		      	{
		      		array_walk( $filtered_users, array( $this , 'disqus_rcw_trim' ) );
		        	if( in_array( $author_name , $filtered_users ) ) continue;
		      	}
		      	//everything is fine, let's keep going
		      	$comment_counter++;
		     	 //alternate class
		      	if($comment_counter % 2 !== 0) $wrap_class ="disqus_rcw_comment_wrap";
		      	else $wrap_class ="disqus_rcw_comment_wrap alter";
				
		      	//get rest of comment data
		      	$author_profile = $comment_obj["author"]["profileUrl"];
		      	$author_avatar = $comment_obj["author"]["avatar"]["large"]["cache"];
		      	$message = $comment_obj["raw_message"];
		      	$comment_id = '#comment-'.$comment_obj["id"];
		      	$post_time = date(
	                  $style_params["date_format"] ,
	                  strtotime($comment_obj["created_at"].'+0000') 
	                );
	                
		      	$thread_info = $this->get_thread_info(
		                      $comment_obj["thread"], 
		                      $api_key
		                    );
		      	$thread_title = $thread_info["title"];
		      	$thread_link = $thread_info["link"];
		      
		      	// shorten comment
			    $message = $this->shorten_comment(
		                    $message, 
		                    $style_params["comment_length"] 
		                  );
					  
				
		      	//create comment html
		      	$comment_html = '<div class="disqus_rcw_single_comment_wrapper">
		                <div>
		                  <div>
		                    <img class="disqus_rcw_avatar" src="'.$author_avatar.'" alt="'.$author_name.'"/>
		                    <div class="disqus_rcw_author_name">
		                      <a href="'.$author_profile.'">'.$author_name.' - <span class="disqus_rcw_post_time">'.$post_time.'</span></a>
		                    </div>
		                  </div>
		                  <div class="disqus_rcw_clear"></div>
		                </div>
		                <div>
		                  <a class="disqus_rcw_thread_title" href="'.$thread_link.'">'.$thread_title.'</a>
		                  <div class="disqus_rcw_comment_actual_wrapper">
		                  	<a href="'.$thread_link.$comment_id.'">'.$message.'</a>
		                  </div>
		                </div>
		              </div>';
		      	$recent_comments .= $comment_html;
		      	//stop loop when we reach limit
		      	if($comment_counter == $style_params["comment_limit"]) break;
		    }
		} else $recent_comments .= 'Invalid API Key';

		do_action( 'disqus_rcw_after_comments_loop');

	    $recent_comments .= '</div>';
		
		$recent_comments = apply_filters( 'disqus_rcw_recent_comments' , $recent_comments );
		
		echo($recent_comments);
	}

	public function update($new_instance, $old_instance) {
		
    	$instance = $old_instance;
		
		$instance['comment_limit'] = strip_tags($new_instance['comment_limit']);
		$instance['comment_length'] = strip_tags($new_instance['comment_length']);
		$instance['filter_users'] = strip_tags($new_instance['filter_users']);
			
        return $instance;
		
    }

	public function form($instance) {
    	
		$comment_limit = isset($instance['comment_limit']) ? esc_attr($instance['comment_limit']) : 5;
		$comment_length = isset($instance['comment_length']) ? esc_attr($instance['comment_length']) : 200;
		$filter_users = isset($instance['filter_users']) ? esc_attr($instance['filter_users']) : '';
		
		?>
		
		<p><label for="<?php echo $this->get_field_id('comment_limit'); ?>"><?php _e( 'Comment Limit:' , 'disqus_rcw' ); ?></label>
		<input id="<?php echo $this->get_field_id('comment_limit'); ?>" name="<?php echo $this->get_field_name('comment_limit'); ?>" type="text" value="<?php echo $comment_limit; ?>" /></p>
		
		<p><label for="<?php echo $this->get_field_id('comment_length'); ?>"><?php _e( 'Comment Length:' , 'disqus_rcw' ); ?></label>
		<input id="<?php echo $this->get_field_id('comment_length'); ?>" name="<?php echo $this->get_field_name('comment_length'); ?>" type="text" size="4" value="<?php echo $comment_length; ?>" /></p>
		
		<p><label for="<?php echo $this->get_field_id('filter_users'); ?>"><?php _e( 'Filter Users (comma separated):' , 'disqus_rcw' ); ?></label>
		<textarea id="<?php echo $this->get_field_id('filter_users'); ?>" cols="30" name="<?php echo $this->get_field_name('filter_users'); ?>" type="text" ><?php echo $filter_users; ?></textarea></p>
		
		<?php
		
    }

}

function disqus_rcw_init() {
	register_widget( 'disqus_recent_comments_widget' );
}
add_action( 'widgets_init' , 'disqus_rcw_init' );

function disqus_rcw_settings_link($links) { 
  $settings_link = '<a href="options-general.php?page=disqus_rcw.php">'.__('Settings').'</a>'; 
  array_unshift($links, $settings_link); 
  return $links; 
}
$disqus_rcw_basename = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$disqus_rcw_basename", 'disqus_rcw_settings_link' );


$disqus_rcw_settings = new disqus_rcw_settings;
register_activation_hook( __FILE__, array( $disqus_rcw_settings, 'install' ) );

class disqus_rcw_settings {
	
	public function __construct() {
		add_action( 'admin_init' , array( $this , 'settings_api_init' ) );
		add_action( 'admin_menu' , array( $this , 'disqus_rcw_add_settings_menu_page' ) );
		add_action( 'admin_init' , array( $this , 'install_redirect' ) );
		add_action( 'wp_enqueue_scripts' , array( $this , 'enqueue_styles' ) );
		if(get_option('disqus_rcw_date_format')) $this->date_format = get_option('disqus_rcw_date_format');
		else $this->date_format = 'n/j/Y';
	}
	
	public function enqueue_styles() {
		wp_enqueue_style( 'disqus_rcw.css' , plugins_url().'/'.basename(dirname(__FILE__)).'/disqus_rcw.css' );
	}
	
	public function install() {
		
		if( !in_array( 'disqus-comment-system/disqus.php' , (array) get_option( 'active_plugins', array() ) ) )
			wp_die('<p>This plugin requires the <a href="http://wordpress.org/extend/plugins/disqus-comment-system/">Disqus comment system plugin</a> to be installed and activated on your WordPress site</p><p><a href="plugins.php">Return to plugins page</a></p>');
		else 
			add_option( 'disqus_rcw_settings_do_activation_redirect' , true );
		
	}
	
	public function install_redirect() {
		
		if (get_option( 'disqus_rcw_settings_do_activation_redirect' , false ) ) {
	        delete_option( 'disqus_rcw_settings_do_activation_redirect' );
	        wp_redirect( 'options-general.php?page=disqus_rcw' );
	    }
	}
	
	public function settings_api_init() {
		
		register_setting( 'disqus_rcw_settings_group' , 'disqus_rcw_forum_name' );
		register_setting( 'disqus_rcw_settings_group' , 'disqus_rcw_api_key' );
		register_setting( 'disqus_rcw_settings_group' , 'disqus_rcw_date_format' );
		
		add_settings_section( 'disqus_rcw_settings_section' ,'', array( $this , 'disqus_rcw_section_callback' ), 'disqus_rcw' );
		
		add_settings_field( 'disqus_rcw_forum_name' , __( 'Short Name' , 'disqus_rcw' ), array( $this , 'forum_name_callback' ), 'disqus_rcw' , 'disqus_rcw_settings_section' );
		add_settings_field( 'disqus_rcw_api_key' , __( 'API Key' , 'disqus_rcw' ) , array( $this , 'api_key_callback' ), 'disqus_rcw' , 'disqus_rcw_settings_section' );
		add_settings_field( 'disqus_rcw_date_format' , __( 'Date Format' , 'disqus_rcw' ) , array( $this , 'date_format_callback' ), 'disqus_rcw' , 'disqus_rcw_settings_section' );
	}
	
	public function disqus_rcw_display_settings() {
		?>
		<div class="wrap">
			<h2><?php _e( 'Disqus Recent Comments Widget Settings' , 'disqus_rcw' ); ?></h2>
			<form action="options.php" method="post">
				<?php settings_fields( 'disqus_rcw_settings_group' ); ?>
				<?php do_settings_sections( 'disqus_rcw' ); ?>
				<?php submit_button(); ?>
			</form>
		</div>
		<?php
	}
	
	public function disqus_rcw_section_callback() {
		_e( 'Enter your site\'s short name<a style="text-decoration: none" href="http://help.disqus.com/customer/portal/articles/466208-what-s-a-shortname"><sup>What is this?</sup></a>, your api key<a href="http://deusmachine.com/disqus-instructions.php" style="text-decoration: none;"><sup>Help</sup></a> and your preferred <a href="http://php.net/date">date format</a> here.' , 'disqus_rcw' );
	}
	
	public function date_format_callback() {
		echo '<input type="text" name="disqus_rcw_date_format" size="10" value="'. esc_attr( $this->date_format ).'">';
	}

	public function api_key_callback() {
		echo '<input type="text" name="disqus_rcw_api_key" size="90" value="'. esc_attr( get_option( 'disqus_rcw_api_key' ) ).'">';
	}
	
	public function forum_name_callback() {
		echo '<input type="text" name="disqus_rcw_forum_name" value="'. esc_attr( get_option( 'disqus_rcw_forum_name' ) ).'">';
	}
	
	public function disqus_rcw_add_settings_menu_page() {
		add_options_page( 'Disqus Comments','Disqus Comments','update_plugins','disqus_rcw',array($this,'disqus_rcw_display_settings' ) );
	}
	
}


?>