<?php

	/**
	 * The admin class, handles the activities of the admin
	 * dashboard involing the plugin.
	 * 
	 * @author Iain Cambridge
	 * @copyright Fubra Limited 2010-2011
	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
	 * @since 2.0
	 * @package WP Survey And Quiz Tool
	 */

class Wpsqt_Admin extends Wpsqt_Core {
	
	
	/**
	 * Adds the hooks for the admin dashboard actions
	 * @since 2.0
	 */
	public function __construct(){
		parent::__construct();
		add_action('plugins_loaded', array($this, 'wpsqt_init_menus'));

		// Scripts cannot be enqueued when the wpsqt_page_files hook is run on 
		// pre 3.2.2, so fallback to standard enqueuing procedure
		global $wp_version;
		if (version_compare($wp_version, '3.2.1', '>')) {
			add_action( 'wpsqt_page_files' , array($this,"enqueue_files_admin"));
		} else {
			add_action( 'admin_init' , array($this,"enqueue_files_admin"));
		}
		add_action( 'admin_init' , array($this,"adminFilter"));
		add_action( 'admin_head-media-upload.php', array( $this, 'print_scripts_media_up' ), 11 );
		add_action( 'admin_notices' , array($this, 'admin_notices') );

		add_action('admin_init', array($this, 'download_csv'));
		
	}
	
	public function wpsqt_init_menus() {
		if(current_user_can('wpsqt-manage')) {
			add_action( 'admin_menu' , array($this,'admin_menu') );
		}
		
	}
	
	public function admin_notices() {
		

		if ( get_option('wpsqt_update_required') ){
			echo '<div class="error">';
			echo 'An upgrade is required for WPSQT. <a href="'.WPSQT_URL_MAINENTANCE.'&section=upgrade">Click here</a> to proceed to upgrade.';
			echo '</div>';
		}

		
	}
	
	
	public function print_scripts_edit_cat() {
			// Some JS to resize the Thickbox file upload overlay and commandeer the reply from
			// the overlay (which is currently expecting a post edit window JS function)
		echo <<<END
		<script type="text/javascript">
		//<![CDATA[
		
		var linkId;

		function setId(newId){
			linkId = newId;
		}
		
		// Hackety Hack: Hijack the function name which WP is expecting to choose the image
		function send_to_editor(h) {
			// Obviously need to do more stuff here
			jQuery('#image_'+linkId+'_image').html(h);
			jQuery('#image_'+linkId+'_text').val(h);
			tb_remove();
		}
		
		// thickbox settings
		var tb_cat_position;
		(function($) {
			tb_cat_position = function() {
				var tbWindow = $('#TB_window'), width = $(window).width(), H = $(window).height(), W = ( 720 < width ) ? 720 : width;
		
				if ( tbWindow.size() ) {
					tbWindow.width( W - 50 ).height( H - 45 );
					$('#TB_iframeContent').width( W - 50 ).height( H - 75 );
					tbWindow.css({'margin-left': '-' + parseInt((( W - 50 ) / 2),10) + 'px'});
					if ( typeof document.body.style.maxWidth != 'undefined' )
						tbWindow.css({'top':'20px','margin-top':'0'});
				};
		
				return $('a.thickbox').each( function() {
					var href = $(this).attr('href');
					if ( ! href ) return;
					href = href.replace(/&width=[0-9]+/g, '');
					href = href.replace(/&height=[0-9]+/g, '');
					$(this).attr( 'href', href + '&width=' + ( W - 80 ) + '&height=' + ( H - 85 ) );
				});
			};
		
			$(window).resize(function(){ tb_cat_position(); });
		
		})(jQuery);
		
		jQuery( document ).ready( function($){ tb_cat_position(); } );
		
		//]]>
		</script>
END;
	}
	
	public function print_scripts_media_up() {
		
		echo <<<END
		<script type="text/javascript">
		//<![CDATA[
		
		function rmupoc_uploadSuccess(fileObj, serverData) {
			// if async-upload returned an error message, place it in the media item div and return
			if ( serverData.match('media-upload-error') ) {
				jQuery('#media-item-' + fileObj.id).html(serverData);
				return;
			}
		
			rmupoc_prepareMediaItem(fileObj, serverData);
			updateMediaForm();
		
			// Increment the counter.
			if ( jQuery('#media-item-' + fileObj.id).hasClass('child-of-' + post_id) )
				jQuery('#attachments-count').text(1 * jQuery('#attachments-count').text() + 1);
		}
		
		function rmupoc_prepareMediaItem(fileObj, serverData) {
			var f = ( typeof shortform == 'undefined' ) ? 1 : 2, item = jQuery('#media-item-' + fileObj.id);
			// Move the progress bar to 100%
			jQuery('.bar', item).remove();
			jQuery('.progress', item).hide();
		
			try {
				if ( typeof topWin.tb_remove != 'undefined' )
					topWin.jQuery('#TB_overlay').click(topWin.tb_remove);
			} catch(e){}
		
			// New style: server data is just the attachment ID, fetch the thumbnail and form html from the server
			item.load('async-upload.php', { attachment_id:serverData, fetch:f, app: 'rmupoc', cat_id: 1 }, function(){
				prepareMediaItemInit(fileObj);
				updateMediaForm();
			});
		}
		
		//]]>
		</script>
END;
	}
	
	public function adminFilter(){		
		apply_filters('wpsqt_admin_init',$this);
	}
	
	
	/**
	 * Returns the details for a page. Basically used 
	 * during unit testing.
	 * 
	 * @param string $id
	 * @since 2.0
	 * @return array
	 */
	public function getPageDetails($id){
		
		return $this->_pages[$id];
		
	}
	
	/**
	 * Adds the hooks for the admin menu. Loops through the $this->_page
	 * array and calls either add_menu_page or add_submenu page based
	 * on if parent item of the sub array is null.
	 * 
	 * @since 2.0
	 */
	public function admin_menu(){
		
		foreach ( $this->_pages as $pagevar => $page ){
			if ( is_null($page['parent']) ){
				$pageId = add_menu_page( $page['page_title'], $page['title'], $page['capability'], $pagevar, array($this,"show_page") ) ;	
				add_action( 'admin_head-'.$pageId , array( & $this, 'print_scripts_edit_cat' ), 11 );
				
			} else {
				add_submenu_page( $page['parent'] , $page['page_title'], $page['title'], $page['capability'], $pagevar, array($this,"show_page") );
			}
		}
		
	}
	
	
	/**
	 * Handles displaying the admin pages. All admin pages for
	 * the plugin route via this method. Should allow for a 
	 * Classes for each page without having to include all the
	 * class files on every page loads.
	 * 
	 * @todo Seriously think about if this is a good idea.
	 * @since 2.0
	 */
	public function show_page( $testMode = false ){
		
		if ( !array_key_exists($_GET['page'],$this->_pages) ){
			wp_die("Invalid WPSQT page request for ".$_GET['page']);
		}
		
		$module = $this->_pages[$_GET['page']]['module'];
		$page = (isset($_GET['section'])) ? $_GET['section'] : false;
		$subPage = (isset($_GET['subsection'])) ? $_GET['subsection'] : false;
		
		require_once WPSQT_DIR.'lib/Wpsqt/Page.php';
		
		$objPage = Wpsqt_Page::getPage($module,$page,$subPage);
		$objPage->process();
		
		if ( $testMode == false ){
			$objPage->display();
		}
		
		return $objPage;
	
	}
	
	/**
	 * Enqueues the files.
	 * 
	 * @since 2.0
	 */	
	public function enqueue_files_admin(){
		wp_enqueue_script("jquery");
		wp_enqueue_style("wpsqt-print",plugins_url('/css/print.css',WPSQT_FILE));
		wp_enqueue_style("wpsqt-style",plugins_url('/css/style.css',WPSQT_FILE));
		wp_enqueue_style("wpsqt-admin",plugins_url('/css/admin.css',WPSQT_FILE));
		wp_enqueue_script("wpsqt-generic",plugins_url('/js/generic.js',WPSQT_FILE));
		wp_enqueue_script("jquery-tools",plugins_url('/js/jquery.tools.min.js',WPSQT_FILE));
		wp_enqueue_script("jquery-ui",plugins_url('/js/jquery.ui.min.js',WPSQT_FILE));
		wp_enqueue_script( 'thickbox' );
		wp_enqueue_style( 'thickbox' );

	}

	public function download_csv() {
		if (isset($_GET['wpsqt-download'])) {
			if (current_user_can('manage_options')) {
				require_once WPSQT_DIR.'lib/Wpsqt/Export/Csv.php';
				$csvExporter = new Wpsqt_Export_Csv;

				$csvExporter->quizId = $_GET['id'];
				$lines = $csvExporter->generate($_GET['id']);

				header("Content-type: application/x-msdownload",true,200);
				header("Content-Disposition: attachment; filename=results-{$_GET['wpsqt-download']}.csv");
				header("Pragma: no-cache");
				header("Expires: 0");
				echo apply_filters('wpsqt-export-csv', implode("\r\n", $lines), $_GET['id']);
				exit();
			}
		}
	}
	
}
