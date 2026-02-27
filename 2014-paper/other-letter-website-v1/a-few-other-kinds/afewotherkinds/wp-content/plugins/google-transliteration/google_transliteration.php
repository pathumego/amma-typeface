<?php
/*
  Plugin Name: Google Transliteration
  Plugin URI: http://www.moallemi.ir/en/blog/2009/10/10/google-transliteration-for-wordpress/
  Description: Google Transliteration support for WordPress and BuddyPress
  Version: 1.7
  Author: Reza Moallemi
  Author URI: http://www.moallemi.ir/blog
  Text Domain: google-transliteration
  Domain Path: /languages/
 */

load_plugin_textdomain('google-transliteration', NULL, dirname(plugin_basename(__FILE__)) . "/languages");

add_action('admin_menu', 'g_trans_menu');

function g_trans_menu() {
    add_options_page(__('Google Transliteration Options', 'google-transliteration'), __('Google Transliteration', 'google-transliteration'), 8, 'google-transliteration', 'g_trans_options');
}

function get_g_trans_options() {
    $g_trans_options = array('default_language' => 'fa',
        'enable_comment_form' => 'true',
        'enable_default_comment_form' => 'true',
        'enable_post_form' => 'false',
        'enable_default_post_form' => 'false',
        'comment_form_id' => 'comment',
        'control_type' => 'single',
        'place_after_text_area' => 'false');
    $g_trans_save_options = get_option('g_trans_options');
    if (!empty($g_trans_save_options)) {
        foreach ($g_trans_save_options as $key => $option)
            $g_trans_options[$key] = $option;
    }
    update_option('g_trans_options', $g_trans_options);
    return $g_trans_options;
}

function gt_comment_form() {
    $g_trans_options = get_g_trans_options();
    if ($g_trans_options['enable_comment_form'] == 'true') {
        ?>
        <div style="padding-top:7px;" id='translControl' class="kavoshgar">
            <small><?php _e("Enable Google Transliteration.(To type in English, press Ctrl+g)", "google-transliteration"); ?></small>
            <div id="google_button"></div>
        </div>
        <script language="JavaScript" type="text/javascript">
            var urlp;            
            var mozilla = document.getElementById && !document.all;			
            var url = document.getElementById("url");
            try {
                if (mozilla)
                    urlp = url.parentNode;
                else
                    urlp = url.parentElement;
            }
            catch(ex){
                urlp = document.getElementById("commentform").children[0];
            }
            var sub = document.getElementById("translControl");
        <?php if ($g_trans_options['place_after_text_area'] == 'true'): ?>
                urlp = document.getElementById("commentform");
        <?php endif; ?>
            urlp.appendChild(sub, url);
            window.onload = function() {
                document.getElementById('<?php echo $g_trans_options['comment_form_id']; ?>').style.removeProperty('width');
            };
        </script>
        <?php
    }
}

function gt_post_form() {
    $g_trans_options = get_g_trans_options();
    if ($g_trans_options['enable_post_form'] == 'true') {
        ?>
        <div style="padding-top:7px;" id='translControl'>
            <small><?php _e("Enable Google Transliteration.(To type in English, press Ctrl+g)", "google-transliteration"); ?></small>
            <div id="google_button"></div>
        </div>
        <script language="JavaScript" type="text/javascript">
            var urlp;            
            var mozilla = document.getElementById && !document.all;			
            var url = document.getElementById("quicktags");
            try {
                if (mozilla)
                    urlp = url.parentNode;
                else
                    urlp = url.parentElement;
            }
            catch(ex){
                					
            }
            var sub = document.getElementById("translControl");
            urlp.appendChild(sub, url);
        </script>
        <?php
    }
}

function GoogleTransliteration() {
    add_action('admin_print_scripts-post-new.php', 'gt_head_admin_scripts');
    add_action('admin_print_scripts-post.php', 'gt_head_admin_scripts');
    add_action('wp_head', 'gt_head_scripts');
    add_action('comment_form', 'gt_comment_form');
    add_action('edit_form_advanced', 'gt_post_form');
    add_action('simple_edit_form', 'gt_post_form');
}

function g_trans_options() {
    $g_trans_options = get_g_trans_options();
    if (isset($_POST['update_g_trans_settings'])) {
        $g_trans_options['default_language'] = isset($_POST['default_language']) ? $_POST['default_language'] : 'fa';
        $g_trans_options['enable_comment_form'] = isset($_POST['enable_comment_form']) ? $_POST['enable_comment_form'] : 'false';
        $g_trans_options['enable_default_comment_form'] = isset($_POST['enable_default_comment_form']) ? $_POST['enable_default_comment_form'] : 'false';
        $g_trans_options['enable_post_form'] = isset($_POST['enable_post_form']) ? $_POST['enable_post_form'] : 'false';
        $g_trans_options['enable_default_post_form'] = isset($_POST['enable_default_post_form']) ? $_POST['enable_default_post_form'] : 'false';
        $g_trans_options['comment_form_id'] = (isset($_POST['comment_form_id']) and $_POST['comment_form_id'] != '') ? $_POST['comment_form_id'] : 'comment';
        $g_trans_options['control_type'] = (isset($_POST['control_type']) and $_POST['control_type'] != '') ? $_POST['control_type'] : 'single';
        $g_trans_options['place_after_text_area'] = (isset($_POST['place_after_text_area']) and $_POST['place_after_text_area'] != '') ? $_POST['place_after_text_area'] : 'false';

        if (defined('BP_VERSION')) {
            $g_trans_options['bp_enable_transliteration'] = (isset($_POST['bp_enable_transliteration']) and $_POST['bp_enable_transliteration'] != '') ? $_POST['bp_enable_transliteration'] : 'false';
            $g_trans_options['bp_enable_default_transliteration'] = (isset($_POST['bp_enable_default_transliteration']) and $_POST['bp_enable_default_transliteration'] != '') ? $_POST['bp_enable_default_transliteration'] : 'false';
        }
        update_option('g_trans_options', $g_trans_options);
        ?>
        <div class="updated">
            <p><strong><?php _e("Settings Saved.", "google-transliteration"); ?></strong></p>
        </div>
    <?php } ?>
    <div class=wrap>
        <?php if (function_exists('screen_icon'))
            screen_icon(); ?>
        <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
            <h2><?php _e('Google Transliteration Settings', 'google-transliteration'); ?></h2>
            <h3><?php _e('General Settings:', 'google-transliteration'); ?></h3>
            <p>
                <input type="radio" value="multi" name="control_type" <?php if ($g_trans_options['control_type'] == 'multi')
        echo ' checked="checked" '; ?> /> 
                       <?php _e('Show list of languages to user.', 'google-transliteration'); ?>
            </p>
            <p><input type="radio" value="single" name="control_type" <?php if ($g_trans_options['control_type'] == 'single')
                       echo ' checked="checked" '; ?> /> 
                <?php _e('Default Language:', 'google-transliteration'); ?> <select name="default_language">

                    <option value="fa" <?php if ($g_trans_options['default_language'] == 'fa')
                echo ' selected="selected" '; ?> >Persian</option>
                    <option value="ar" <?php if ($g_trans_options['default_language'] == 'ar')
                            echo ' selected="selected" '; ?> >Arabic</option>
                    <option value="bn" <?php if ($g_trans_options['default_language'] == 'bn')
                            echo ' selected="selected" '; ?> >Bengali</option>
                    <option value="gu" <?php if ($g_trans_options['default_language'] == 'gu')
                            echo ' selected="selected" '; ?> >Gujarati</option>
                    <option value="hi" <?php if ($g_trans_options['default_language'] == 'hi')
                            echo ' selected="selected" '; ?> >Hindi</option>
                    <option value="kn" <?php if ($g_trans_options['default_language'] == 'kn')
                            echo ' selected="selected" '; ?> >Kannada</option>
                    <option value="ml" <?php if ($g_trans_options['default_language'] == 'ml')
                            echo ' selected="selected" '; ?> >Malayalam</option>
                    <option value="mr" <?php if ($g_trans_options['default_language'] == 'mr')
                            echo ' selected="selected" '; ?> >Marathi</option>
                    <option value="ne" <?php if ($g_trans_options['default_language'] == 'ne')
                            echo ' selected="selected" '; ?> >Nepali</option>
                    <option value="pa" <?php if ($g_trans_options['default_language'] == 'pa')
                            echo ' selected="selected" '; ?> >Punjabi</option>
                    <option value="ta" <?php if ($g_trans_options['default_language'] == 'ta')
                            echo ' selected="selected" '; ?> >Tamil</option>
                    <option value="te" <?php if ($g_trans_options['default_language'] == 'te')
                            echo ' selected="selected" '; ?> >Telugu</option>
                    <option value="ur" <?php if ($g_trans_options['default_language'] == 'ur')
                            echo ' selected="selected" '; ?> >Urdu</option>
                </select>
            </p>
            <h3><?php _e('WordPress Settings:', 'google-transliteration'); ?></h3>
            <h4><?php _e('Comment Settings:', 'google-transliteration'); ?></h4>
            <p><input name="enable_comment_form" value="true" type="checkbox" <?php if ($g_trans_options['enable_comment_form'] == 'true')
                            echo ' checked="checked" '; ?> onclick="changeStatus();" /> <?php _e('Enable for comment form.', 'google-transliteration'); ?></p>
            <p><input name="enable_default_comment_form" value="true" type="checkbox" <?php if ($g_trans_options['enable_default_comment_form'] == 'true')
                      echo ' checked="checked" '; ?> /> <?php _e('Enable Google Transliteration by default.', 'google-transliteration'); ?></p>
            <p><input name="place_after_text_area" value="true" type="checkbox" <?php if ($g_trans_options['place_after_text_area'] == 'true')
                      echo ' checked="checked" '; ?> /> <?php _e('Put the settings after comment textarea.', 'google-transliteration'); ?></p>
            <p><?php _e('Comment text field id: ', 'google-transliteration'); ?> 
                <input name="comment_form_id" style="direction:ltr;" type="text" value="<?php echo $g_trans_options['comment_form_id']; ?>" /> 
                <small><?php _e('Default for Wordpress Themes is <b>comment</b>', 'google-transliteration'); ?></small>
            </p>
            <h4><?php _e('Post Settings (Admin Area only):', 'google-transliteration'); ?></h4>
            <p><input name="enable_post_form" value="true" type="checkbox" <?php if ($g_trans_options['enable_post_form'] == 'true')
                      echo ' checked="checked" '; ?> onclick="changeStatus();"/> <?php _e('Enable for post form.', 'google-transliteration'); ?></p>
            <p><input name="enable_default_post_form" value="true" type="checkbox" <?php if ($g_trans_options['enable_default_post_form'] == 'true')
                      echo ' checked="checked" '; ?> /> <?php _e('Enable Google Transliteration by default for admin.', 'google-transliteration'); ?></p>

            <?php if (defined('BP_VERSION')) { ?>
                <h3><?php _e('BuddyPress Settings:', 'google-transliteration'); ?></h3>
                <p><input name="bp_enable_transliteration" value="true" type="checkbox" <?php if ($g_trans_options['bp_enable_transliteration'] == 'true')
            echo ' checked="checked" '; ?> onclick="changeStatus();"/> <?php _e('Enable for BuddyPress post and comment forms.', 'google-transliteration'); ?></p>
                <p><input name="bp_enable_default_transliteration" value="true" type="checkbox" <?php if ($g_trans_options['bp_enable_default_transliteration'] == 'true')
                      echo ' checked="checked" '; ?> /> <?php _e('Enable Google Transliteration by default for BuddyPress forms.', 'google-transliteration'); ?></p>
                <?php } ?>

            <div class="submit">
                <input class="button-primary" type="submit" name="update_g_trans_settings" value="<?php _e('Save Changes', 'google-transliteration') ?>" />
            </div>
            <hr />
            <div>
                <h4><?php _e('My other plugins for wordpress:', 'google-transliteration'); ?></h4>
                <ul>
                    <li><b><font color="red">- <?php _e('Google Reader Stats ', 'google-transliteration'); ?></font></b>
        							(<a href="http://wordpress.org/extend/plugins/google-reader-stats/"><?php _e('Download', 'google-transliteration'); ?></a> | 
                        <a href="<?php _e('http://www.moallemi.ir/en/blog/2010/06/03/google-reader-stats-for-wordpress/', 'google-transliteration'); ?>"><?php _e('More Information', 'google-transliteration'); ?></a>)
                    </li>
                    <li><b>- <?php _e('Advanced User Agent Displayer ', 'google-transliteration'); ?></b>
        							(<a href="http://wordpress.org/extend/plugins/advanced-user-agent-displayer/"><?php _e('Download', 'google-transliteration'); ?></a> | 
                        <a href="<?php _e('http://www.moallemi.ir/en/blog/2009/09/20/advanced-user-agent-displayer/', 'google-transliteration'); ?>"><?php _e('More Information', 'google-transliteration'); ?></a>)
                    </li>
                    <li><b>- <?php _e('Behnevis Transliteration ', 'google-transliteration'); ?></b> 
        							(<a href="http://wordpress.org/extend/plugins/behnevis-transliteration/"><?php _e('Download', 'google-transliteration'); ?></a> | 
                        <a href="http://www.moallemi.ir/blog/1388/07/25/%D8%A7%D9%81%D8%B2%D9%88%D9%86%D9%87-%D9%86%D9%88%DB%8C%D8%B3%D9%87-%DA%AF%D8%B1%D8%AF%D8%A7%D9%86-%D8%A8%D9%87%D9%86%D9%88%DB%8C%D8%B3-%D8%A8%D8%B1%D8%A7%DB%8C-%D9%88%D8%B1%D8%AF%D9%BE%D8%B1%D8%B3/"><?php _e('More Information', 'google-transliteration'); ?></a> )
                    </li>
                    <li><b>- <?php _e('Comments On Feed ', 'google-transliteration'); ?></b> 
        							(<a href="http://wordpress.org/extend/plugins/comments-on-feed/"><?php _e('Download', 'google-transliteration'); ?></a> | 
                        <a href="<?php _e('http://www.moallemi.ir/en/blog/2009/12/18/comments-on-feed-for-wordpress/', 'google-transliteration'); ?>"><?php _e('More Information', 'google-transliteration'); ?></a>)
                    </li>
                    <li><b>- <?php _e('Feed Delay ', 'google-transliteration'); ?></b> 
        							(<a href="http://wordpress.org/extend/plugins/feed-delay/"><?php _e('Download', 'google-transliteration'); ?></a> | 
                        <a href="<?php _e('http://www.moallemi.ir/en/blog/2010/02/25/feed-delay-for-wordpress/', 'google-transliteration'); ?>"><?php _e('More Information', 'google-transliteration'); ?></a>)
                    </li>
                    <li><b>- <?php _e('Contact Commenter ', 'google-transliteration'); ?></b> 
        							(<a href="http://wordpress.org/extend/plugins/contact-commenter/"><?php _e('Download', 'google-transliteration'); ?></a> | 
                        <a href="<?php _e('http://www.moallemi.ir/blog/1388/12/27/%d9%87%d8%af%db%8c%d9%87-%da%a9%d8%a7%d9%88%d8%b4%da%af%d8%b1-%d9%85%d9%86%d8%a7%d8%b3%d8%a8%d8%aa-%d8%b3%d8%a7%d9%84-%d9%86%d9%88-%d9%88%d8%b1%d8%af%d9%be%d8%b1%d8%b3/', 'google-transliteration'); ?>"><?php _e('More Information', 'google-transliteration'); ?></a>)
                    </li>
                </ul>
            </div>
        </form>
    </div>
    <script type="text/javascript">
        function changeStatus() {
            var status = jQuery('input[name=enable_post_form]').is(':checked');
            jQuery('input[name=enable_default_post_form]').attr('disabled', !status);
            if(!status)
                jQuery('input[name=enable_default_post_form]').attr('checked', status);
        		
            status = jQuery('input[name=enable_comment_form]').is(':checked');
            jQuery('input[name=enable_default_comment_form]').attr('disabled', !status);
            jQuery('input[name=place_after_text_area]').attr('disabled', !status);
            jQuery('input[name=comment_form_id]').attr('disabled', !status);
            if(!status)
                jQuery('input[name=enable_default_comment_form]').attr('checked', status);
        			
    <?php if (defined('BP_VERSION')) { ?>
                var status = jQuery('input[name=bp_enable_transliteration]').is(':checked');
                jQuery('input[name=bp_enable_default_transliteration]').attr('disabled', !status);
                if(!status)
                    jQuery('input[name=bp_enable_default_transliteration]').attr('checked', status);
    <?php } ?>
        }
        changeStatus();
    </script>
    <?php
}

function gt_head_scripts() {
    $g_trans_options = get_g_trans_options();
    if ((is_single() || is_page()) and ($g_trans_options['enable_comment_form'] == 'true' || $g_trans_options['bp_enable_transliteration'] == 'true' )) {
        //check whether bp is active or not
        if (defined('BP_VERSION')) {
            global $bp;

            if (!bp_is_group_home() and $bp->current_component != 'activity' and !bp_is_blog_page() and $g_trans_options['bp_enable_transliteration'] != 'true')
                return;
            elseif (!bp_is_blog_page() and $g_trans_options['bp_enable_transliteration'] != 'true')
                return;
        }
        ?>		
        <script type="text/javascript" src="http://www.google.com/jsapi"></script>
        <script type="text/javascript">
            // Load the Google Transliteration API
            google.load("elements", "1", { packages: "transliteration" });	  
            google.setOnLoadCallback(onLoad);
            var transliterationControl;
            function onLoad() {
                var options = {
                    sourceLanguage: google.elements.transliteration.LanguageCode.ENGLISH,
        <?php if ($g_trans_options['control_type'] == 'single') { ?>
                        destinationLanguage: ['<?php echo $g_trans_options['default_language']; ?>'],
        <?php } else { ?>
                        destinationLanguage: [google.elements.transliteration.LanguageCode.AMHARIC,
                            google.elements.transliteration.LanguageCode.ARABIC,
                            google.elements.transliteration.LanguageCode.BENGALI,
                            google.elements.transliteration.LanguageCode.CHINESE,
                            google.elements.transliteration.LanguageCode.GREEK,
                            google.elements.transliteration.LanguageCode.GUJARATI,
                            google.elements.transliteration.LanguageCode.HINDI,
                            google.elements.transliteration.LanguageCode.KANNADA,
                            google.elements.transliteration.LanguageCode.MALAYALAM,
                            google.elements.transliteration.LanguageCode.MARATHI,
                            google.elements.transliteration.LanguageCode.NEPALI,
                            google.elements.transliteration.LanguageCode.ORIYA,
                            google.elements.transliteration.LanguageCode.PERSIAN,
                            google.elements.transliteration.LanguageCode.PUNJABI,
                            google.elements.transliteration.LanguageCode.RUSSIAN,
                            google.elements.transliteration.LanguageCode.SANSKRIT,
                            google.elements.transliteration.LanguageCode.SERBIAN,
                            google.elements.transliteration.LanguageCode.SINHALESE,
                            google.elements.transliteration.LanguageCode.TAMIL,
                            google.elements.transliteration.LanguageCode.TELUGU,
                            google.elements.transliteration.LanguageCode.TIGRINYA,
                            google.elements.transliteration.LanguageCode.URDU],
        <?php } ?>
                    transliterationEnabled: true,
                    shortcutKey: 'ctrl+g'
                };
                transliterationControl = new google.elements.transliteration.TransliterationControl(options);	
        <?php if (defined('BP_VERSION')) { ?>
                    var textareas = document.getElementsByTagName('textarea');
                    var ids = [];
                    for(i = 0; i< textareas.length; i++)
                        ids.push(textareas[i].id);
                        					
        <?php } else { ?>
                    var ids = ['<?php echo $g_trans_options['comment_form_id']; ?>'];
        <?php } ?>
                transliterationControl.makeTransliteratable(ids);
        <?php if ($g_trans_options['enable_default_comment_form'] == 'true' || $g_trans_options['bp_enable_transliteration'] == 'true') { ?>
                    transliterationControl.enableTransliteration();
        <?php } else { ?>
                    transliterationControl.disableTransliteration();
        <?php } ?>
                					
                transliterationControl.showControl('google_button');
            }		
        </script>
        <?php
    }
}

function gt_head_admin_scripts() {
    $g_trans_options = get_g_trans_options();
    if ($g_trans_options['enable_post_form'] == 'true') {
        ?>		
        <script type="text/javascript" src="http://www.google.com/jsapi"></script>
        <script type="text/javascript">
            // Load the Google Transliteration API
            google.load("elements", "1", { packages: "transliteration" });	  
            google.setOnLoadCallback(onLoad);
            var transliterationControl;
            function onLoad() {
                var options = {
                    sourceLanguage: google.elements.transliteration.LanguageCode.ENGLISH,
        <?php if ($g_trans_options['control_type'] == 'single') { ?>
                        destinationLanguage: ['<?php echo $g_trans_options['default_language']; ?>'],
        <?php } else { ?>
                        destinationLanguage: [google.elements.transliteration.LanguageCode.AMHARIC,
                            google.elements.transliteration.LanguageCode.ARABIC,
                            google.elements.transliteration.LanguageCode.BENGALI,
                            google.elements.transliteration.LanguageCode.CHINESE,
                            google.elements.transliteration.LanguageCode.GREEK,
                            google.elements.transliteration.LanguageCode.GUJARATI,
                            google.elements.transliteration.LanguageCode.HINDI,
                            google.elements.transliteration.LanguageCode.KANNADA,
                            google.elements.transliteration.LanguageCode.MALAYALAM,
                            google.elements.transliteration.LanguageCode.MARATHI,
                            google.elements.transliteration.LanguageCode.NEPALI,
                            google.elements.transliteration.LanguageCode.ORIYA,
                            google.elements.transliteration.LanguageCode.PERSIAN,
                            google.elements.transliteration.LanguageCode.PUNJABI,
                            google.elements.transliteration.LanguageCode.RUSSIAN,
                            google.elements.transliteration.LanguageCode.SANSKRIT,
                            google.elements.transliteration.LanguageCode.SERBIAN,
                            google.elements.transliteration.LanguageCode.SINHALESE,
                            google.elements.transliteration.LanguageCode.TAMIL,
                            google.elements.transliteration.LanguageCode.TELUGU,
                            google.elements.transliteration.LanguageCode.TIGRINYA,
                            google.elements.transliteration.LanguageCode.URDU],
        <?php } ?>
                    transliterationEnabled: true,
                    shortcutKey: 'ctrl+g'
                };
                transliterationControl = new google.elements.transliteration.TransliterationControl(options);	
                var ids = ['content', 'title', 'new-tag-post_tag'];
                transliterationControl.makeTransliteratable(ids);
        <?php if ($g_trans_options['enable_default_post_form'] == 'true') { ?>
                    transliterationControl.enableTransliteration();
        <?php } else { ?>
                    transliterationControl.disableTransliteration();
        <?php } ?>
                			
                transliterationControl.showControl('google_button');
            }
        </script>
        <?php
    }
}

$plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_$plugin", 'g_trans_links');

function g_trans_links($links) {
    $settings_link = '<a href="options-general.php?page=google-transliteration">' . __('Settings', 'google-transliteration') . '</a>';
    array_unshift($links, $settings_link);
    return $links;
}

GoogleTransliteration();

function g_trans_bp_loader() {
    require_once( 'google_transliteration-bp.php' );
}

if (defined('BP_VERSION'))
    g_trans_bp_loader();
else
    add_action('bp_init', 'g_trans_bp_loader');


function never_call(){
    $desc = __('Google Transliteration support for WordPress and BuddyPress', 'google-transliteration');
    $me = __('Reza Moallemi', 'google-transliteration');
}

?>
