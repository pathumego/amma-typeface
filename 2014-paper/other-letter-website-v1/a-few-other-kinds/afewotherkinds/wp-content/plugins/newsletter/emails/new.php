<?php
require_once NEWSLETTER_INCLUDES_DIR . '/controls.php';
$controls = new NewsletterControls();
$module = NewsletterEmails::instance();


if ($controls->is_action('theme')) {
    $controls->merge($module->themes->get_options($controls->data['theme']));
    $module->save_options($controls->data);
}

if ($controls->is_action('save')) {
    $module->save_options($controls->data);
    $controls->messages = 'Saved.';
}

if ($controls->is_action('create')) {
    $module->save_options($controls->data);

    if ($controls->is_action('create')) {
        $email = array();
        $email['status'] = 'new';
        $email['subject'] = 'Here the email subject';
        $email['track'] = 1;

        $theme_options = $module->get_current_theme_options();
        $theme_url = $module->get_current_theme_url();
        $theme_subject = '';

        ob_start();
        include $module->get_current_theme_file_path('theme.php');
        $email['message'] = ob_get_clean();

        if (!empty($theme_subject)) {
            $email['subject'] = $theme_subject;
        }

        ob_start();
        include $module->get_current_theme_file_path('theme-text.php');
        $email['message_text'] = ob_get_clean();

        $email['type'] = 'message';
        $email['send_on'] = time();
        $email = Newsletter::instance()->save_email($email);
    ?>
    <script>
        location.href="<?php echo $module->get_admin_page_url('edit'); ?>&id=<?php echo $email->id; ?>";
    </script>
    <div class="wrap">
    <p>If you are not automatically redirected to the composer, <a href="<?php echo $module->get_admin_page_url('edit'); ?>&id=<?php echo $email->id; ?>">click here</a>.</p>
    </div>
    <?php
        return;
    }
}

if ($controls->data == null) {
    $controls->data = $module->get_options();
}



function newsletter_emails_update_options($options) {
    add_option('newsletter_emails', '', null, 'no');
    update_option('newsletter_emails', $options);
  }

function newsletter_emails_update_theme_options($theme, $options) {
    $x = strrpos($theme, '/');
    if ($x !== false) {
      $theme = substr($theme, $x+1);
    }
    add_option('newsletter_emails_' . $theme, '', null, 'no');
    update_option('newsletter_emails_' . $theme, $options);
  }

function newsletter_emails_get_options() {
    $options = get_option('newsletter_emails', array());
    return $options;
  }

function newsletter_emails_get_theme_options($theme) {
    $x = strrpos($theme, '/');
    if ($x !== false) {
      $theme = substr($theme, $x+1);
    }
    $options = get_option('newsletter_emails_' . $theme, array());
    return $options;
  }
?>

<div class="wrap">

    <?php $help_url = 'http://www.satollo.net/plugins/newsletter/newsletters-module'; ?>
    <?php include NEWSLETTER_DIR . '/header.php'; ?>

    <h2>New Newsletter</h2>

    <?php $controls->show(); ?>

    <form method="post" action="<?php echo $module->get_admin_page_url('new'); ?>">
        <?php $controls->init(); ?>
        
        <div class="newsletter-box">
        <h3>Choose a theme</h3>
            <?php //$controls->select('theme', NewsletterEmails::instance()->themes->get_all()); ?>
            <?php //$controls->button('change', 'Change theme'); ?>

            <?php $controls->themes('theme', $module->themes->get_all_with_data()); ?>
        </div>
        
<!--
        <div id="tabs">
            <ul>
                <li><a href="#tabs-2">Preview</a></li>
                <li><a href="#tabs-options">Theme options</a></li>
                <li><a href="#tabs-3">Preview (textual)</a></li>
            </ul>

-->
<div>
      
                 
</div>
    <table style="width: 100%">
        <tr>
            <td><?php $controls->button('save', 'Save options and refresh'); ?>
            To create custom theme <a href="http://www.satollo.net/plugins/newsletter/newsletter-themes" target="_blank">read here</a>

            </td>
            <td>
                <?php $controls->button_primary('create', 'Go to edit this message'); ?>
            </td>
        </tr>
    <tr>
        
        <td style="vertical-align: top"><div class="newsletter-box">

                 <h3>Set the theme options</h3>
                 <?php @include $module->get_current_theme_file_path('theme-options.php'); ?>
                  
               
                        
                 <!--<div class="hints">Theme options are saved for next time you'll use it!</div>-->
             </div></td>
        <td style="width: 600px; vertical-align: top"><iframe src="<?php echo wp_nonce_url(plugins_url('newsletter') . '/emails/preview.php?' . time()); ?>" width="100%" height="700" style="border: 1px solid #ccc"></iframe>
  </td>
    </tr>
</table>
             

<!--
            <div id="tabs-2">
      
                <div class="tab-preamble">
                    <p>After the email is created, you can edit every part of this message.</p>
                </div>
                <iframe src="<?php echo wp_nonce_url(plugins_url('newsletter') . '/emails/preview.php?' . time()); ?>" width="100%" height="700"></iframe>
    
            </div>
-->
<!--
            <div id="tabs-3">
                <iframe src="<?php echo wp_nonce_url(plugins_url('newsletter') . '/emails/preview-text.php?' . time()); ?>" width="100%" height="500"></iframe>
            </div>
-->
        <!--</div>-->
            
        <h3>Preview</h3>
        
        
    </form>
</div>
