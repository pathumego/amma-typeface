<?php
add_action('bp_after_activity_post_form', 'g_trans_bp_post_form');
//add_action('wp_footer', 'g_trans_bp_comment_form');

function g_trans_bp_post_form() {
    $g_trans_options = get_g_trans_options();
    if ($g_trans_options['bp_enable_transliteration'] == 'true') {
        ?>
        <div style="padding-top:7px;" id='translControl'>
            <small><?php _e("Enable Google Transliteration.(To type in English, press Ctrl+g)", "google-transliteration"); ?></small>
            <div id="google_button"></div>
        </div>
        <script language="JavaScript" type="text/javascript">     
            var urlp = document.getElementById("whats-new-textarea");
            var sub = document.getElementById("translControl");
        <?php if ($g_trans_options['place_after_text_area'] == 'true') { ?>
                        urlp = document.getElementById("whats-new-content");
        <?php } ?>
                    urlp.appendChild(sub);
                    window.onload = function() {
                    };
        </script>
        <?php
    }
}

function g_trans_bp_comment_form() {
    $g_trans_options = get_g_trans_options();
    if ($g_trans_options['bp_enable_transliteration'] == 'true') {
        ?>
        <script language="javascript" type="text/javascript">     
            window.onload = function() {
                var cforms = document.getElementsByClassName('ac-form');
                for(i = 0; i< cforms.length; i++)
                    document.getElementById(cforms[i].id).innerHTML += '<small><?php _e("(To type in English, press Ctrl+g)", "google-transliteration"); ?></small>';
            };
        </script>
        <?php
    }
}
?>
