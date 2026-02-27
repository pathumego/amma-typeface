<?php
/*
 * Plugin Name: Disqus Popular Threads Widget
 * Plugin URI: http://presshive.com
 * Author: <a href="http://presshive.com/">Presshive</a>
 * Version: 1.2
 * Description: Integrates with the Disqus API to show your most popular threads (most commented posts). Can be added via sidebar widget, template tag, or shortcode. 
 * Tags: disqus, popular posts, comments, most commented, most popular, popular threads, disqus most commented
 * License: GPLv2 or later
 */

/*  Copyright 2013  

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
?>
<?php
global $disqus_threads_script_counter;
$disqus_threads_script_counter = 0;
define('DISQUS_POPULAR_THREADS_PLUGIN_URL', WP_PLUGIN_URL . '/' . dirname(plugin_basename(__FILE__)));

/**
 * function add a settings page in admin end
 */
function diqus_threads_admin_menu_page(){
    add_submenu_page('options-general.php', 'Disqus Settings', 'Disqus Settings', 'manage_options', 'diqus-threads-settings-page', 'diqus_threads_settings_page');
}

// hook to add settings page in admin
add_action( 'admin_menu', 'diqus_threads_admin_menu_page' );

/**
 * function used to show settings page in admin for Disqus Popular Threads Widget.
 */
function diqus_threads_settings_page(){
    $msg = '';
    $submit = isset( $_POST['submit'] ) ? $_POST['submit'] : '';
    if( $submit == 'Save'){
        update_option('_diqus_api_key', $_POST['api_key']);
        update_option('_diqus_forum_ID', $_POST['forum_ID']);
        update_option('_diqus_forum_domain', $_POST['forum_domain']);
        
        $msg = '<div class="updated"><p><strong>Settings saved </strong></p></div>';
    }
    $api_key = get_option('_diqus_api_key');
    $forum_ID = get_option('_diqus_forum_ID');
    $forum_domain = get_option('_diqus_forum_domain');
    ?>
<div class="wrap">
    <h2>Disqus Popular Threads Widget Settings</h2>
    <?php echo $msg; ?>
    <form action="?page=diqus-threads-settings-page" method="post" id="">
        <table width="100%">
            <tr>
                <td><label for="api_key">Disqus Public API Key</label></td>
                <td><input type="text" value="<?php echo $api_key; ?>" name="api_key" id="api_key" class="widefat"/></td>
            </tr>
            <tr>
                <td><label for="forum_ID">Forum ID</label></td>
                <td><input type="text" value="<?php echo $forum_ID; ?>" name="forum_ID" id="forum_ID" class="widefat"/></td>
            </tr>
            <tr>
                <td><label for="forum_domain">Domain</label></td>
                <td><input type="text" value="<?php echo $forum_domain; ?>" name="forum_domain" id="forum_domain" class="widefat"/></td>
            </tr>
            <tr>
                <td colspan="2"> <input type="submit" name="submit" value="Save" class="button"/></td>
            </tr>
        </table>
    </form>
</div>
<?php
}

/**
 * Class for Disqus popular threads widget
 */
class Disqus_popular_threads_widget extends WP_Widget {
        /**
         * Constructor for Disqus popular threads widget.
         */
	public function __construct() {
		parent::__construct(
	 		'Disqus_popular_threads_widget',
			'Disqus Popular Threads Widget',
			array( 'description' => __( 'Your Most Commented Threads'), ) // Args
		);
	}
        /** Echo the settings update form
	 *
	 * @param array $instance Current settings
	 */
 	public function form( $instance ) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$number = isset($instance['number']) ? absint($instance['number']) : 5;
		$days_back = isset($instance['days_back']) ? $instance['days_back'] : 90;
                $choices  = array('1h'=> '1 Hour', '6h' => '6 Hour', '12h' => '12 Hour', '1d' => '1 Day', '3d' => '3 Days', '7d' => '7 Days', '30d'=> '30 Days', '90d'=> '90 Days');
                ?>
                <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:'); ?></label>
		<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

                <p><label for="<?php echo $this->get_field_id('days_back'); ?>"><?php _e('Number of days to go back:'); ?></label>
		<select id="<?php echo $this->get_field_id('days_back'); ?>" name="<?php echo $this->get_field_name('days_back'); ?>" >
                <?php foreach ( $choices as $key => $val ){
                    echo '<option value="'.$key.'" '.selected($days_back, $key, false).'>'.$val.'</option>';
                }?>
                </select></p>

                <?php
	}
        /** Update a particular instance of disqus widget.
	 *
	 * @param array $new_instance New settings for this instance as input by the user via form()
	 * @param array $old_instance Old settings for this instance
	 * @return array Settings to save or bool false to cancel saving
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = absint( $new_instance['number'] );
		$instance['days_back'] = $new_instance['days_back'];
		return $instance;
	}
        /**
         * show disqus popular threads widget in fron end.
         */
	public function widget( $args, $instance ) {
                global $disqus_threads_script_counter;
 		extract($args, EXTR_SKIP);
 		$output = '';
                $api_key = get_option('_diqus_api_key');
                $forum_ID = get_option('_diqus_forum_ID');
                
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) )
 			$number = 5;
                
		if ( empty( $instance['days_back'] )  )
 			$days_back = '7d';
		else
                    	$days_back = $instance['days_back'];

		$output .= $before_widget;
		if ( $title )
			$output .= $before_title . $title . $after_title;

		
		$output .= "<script type=\"text/javascript\">
                                var pt{$disqus_threads_script_counter} = new DiscusMostPopularThreads({
                                    api_key: '{$api_key}',
                                    forum: '{$forum_ID}',
                                    limit: '{$number}',
                                    days_back: '{$days_back}'
                                });
                                pt{$disqus_threads_script_counter}.getData();
                            </script>";
                                    
                $output .= $after_widget;
                
                $disqus_threads_script_counter++;
		echo $output;
	}

}
// register Disqus_popular_threads_widget widget
add_action( 'widgets_init', create_function( '', 'register_widget( "Disqus_popular_threads_widget" );' ) );

/**
 *  enqueue scripts in front end for disqus popular threads widget.
 */
function diqus_threads_enqueue_scripts(){
    $forum_domain = get_option('_diqus_forum_domain');
    wp_register_script('diqus_threads_script', DISQUS_POPULAR_THREADS_PLUGIN_URL.'/js/wp-disqus-pt.js', array(), '');
    wp_localize_script('diqus_threads_script', dptObj, array( 'domain'=> json_encode($forum_domain) ), '');
    wp_enqueue_script('diqus_threads_script');
}
// hook to enqueue script in front.
add_action('wp_enqueue_scripts', 'diqus_threads_enqueue_scripts');

/**
 * function shows popular threads using Disqus API.
 *
 * @param $days_back int no of days to get threads default is 90
 * @param $show_threads int no of threads to show default is 5
 * @param $echo bool echo or return default is false
 *
 * @return string it returns script to show popular threads
 */
function diqus_get_threads( $days_back = '7d', $show_threads = 5, $echo = false ){
    global $disqus_threads_script_counter;
    $api_key = get_option('_diqus_api_key');
    $forum_ID = get_option('_diqus_forum_ID');
    $output = '';
    $output .= "<script type=\"text/javascript\">
                    var pt{$disqus_threads_script_counter} = new DiscusMostPopularThreads({
                        api_key: '{$api_key}',
                        forum: '{$forum_ID}',
                        limit: '{$show_threads}',
                        days_back: '{$days_back}'
                    });
                    pt{$disqus_threads_script_counter}.getData();
                </script>";
    $disqus_threads_script_counter++;
    
    if( $echo ){
        echo $output;
    }
    else{
        return $output;
    }
}
/**
 * shortcode callback function for disqus_threads
 */
function diqus_thread_shortcode_callback( $atts, $content = null ){
    $a = shortcode_atts( array(
                           'days_back' => '7d',
                           'show_threads' => 5,
                           ), $atts
            );
    return diqus_get_threads($a['days_back'], $a['show_threads'] );
}

// provide disqus_threads short code to show most popular threads
add_shortcode('disqus_threads', 'diqus_thread_shortcode_callback');
?>
