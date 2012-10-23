<?php
/*
Plugin Name: Read Offline
Plugin URI: http://soderlind.no/archives/2012/10/01/read-offline/
Description: Download a post or page as pdf, epub, or mobi  (see settings). 
Version: 0.1.0
Author: Per Soderlind
Author URI: http://soderlind.no
*/
/*

Changelog:
v0.1.0:
* Added the Read Offline shortcode
* Added, in Settings->Read Offline, option to add Read Offline to top and/or bottom of post and page
v0.0.2: 
* Filename based on the posts slug
* Added meta data
v0.0.1: 
* Initial release

*/
/*
Credits: 
	This template is based on the template at http://pressography.com/plugins/wordpress-plugin-template/ 
	My changes are documented at http://soderlind.no/archives/2010/03/04/wordpress-plugin-template/
	

*/


if (!class_exists('ps_read_offline')) {
	class ps_read_offline {
		/**
		* @var string The options string name for this plugin
		*/
		var $optionsName = 'ps_read_offline_options';

		/**
		* @var array $options Stores the options for this plugin
		*/
		var $options = array();
		/**
		* @var string $localizationDomain Domain used for localization
		*/
		var $localizationDomain = "ps_read_offline";

		/**
		* @var string $url The url to this plugin
		*/ 
		var $url = '';
		/**
		* @var string $urlpath The path to this plugin
		*/
		var $urlpath = '';

		//Class Functions
		/**
		* PHP 4 Compatible Constructor
		*/
		function ps_read_offline(){$this->__construct();}

		/**
		* PHP 5 Constructor
		*/		
		function __construct(){
			//Language Setup
			$locale = get_locale();
			$mo = plugin_dir_path(__FILE__) . 'languages/' . $this->localizationDomain . '-' . $locale . '.mo';	
			load_textdomain($this->localizationDomain, $mo);

			//"Constants" setup
			$this->url = plugins_url(basename(__FILE__), __FILE__);
			$this->urlpath = plugins_url('', __FILE__);	
			//Initialize the options
			$this->getOptions();

			add_action("admin_menu", array(&$this,"admin_menu_link"));
			add_action('admin_enqueue_scripts', array(&$this,'ps_read_offline_admin_script'));
			add_action('the_content', array(&$this,'ps_read_offline_embed'));
			add_action('wp_enqueue_scripts', array(&$this,'ps_read_offline_wp_script'));
			add_shortcode('readoffline', array(&$this,'ps_read_offline_shortcode'));
		}
		
		function ps_read_offline_admin_script() {
			wp_enqueue_script('jquery');
			wp_enqueue_script('jquery-validate', 'http://ajax.microsoft.com/ajax/jquery.validate/1.6/jquery.validate.min.js', array('jquery'));
			wp_enqueue_script('ps_read_offline', $this->urlpath.'/read-offline.js',array('jquery-validate'),$this->_version());
			wp_localize_script( 'ps_read_offline', 'ps_read_offline_lang', array(
				'required' => __('Please select a format below', $this->localizationDomain),
			));
		}
		
		function ps_read_offline_wp_script() {
			wp_enqueue_style('ps_read_offline_icons', $this->urlpath.'/e-book-icons/e-book-icons.css',array(),$this->_version());
			wp_enqueue_style('ps_read_offline_style', $this->urlpath.'/read-offline.css',array(),$this->_version());
		}
		
		function ps_read_offline_embed($content) {		
			global $post;
			
			$placements = array_intersect(array("top_post","bottom_post","top_page","bottom_page"), $this->options['ps_read_offline_option_placement']);	
			$formats = array_uintersect(					
					array(
						 'pdf'  => 'PDF'
						,'epub' => 'ePub'
						,'mobi' => 'mobi'
					)
					, $this->options['ps_read_offline_option_format']
					, "strcasecmp"
			);		
			$readoffline ='<div class="readoffline-embed">';
			$text = $this->options['ps_read_offline_option_link_header'];
			$text = str_ireplace('%title%', $post->post_title,$text);
			if ($text !== '') {
					$readoffline .= sprintf('<div class="readoffline-embed-text">%s</div>',stripslashes($text));
			}			
			foreach ($formats as $type => $document_type) {
				$str_info =  (in_array('yes',$this->options['ps_read_offline_option_iconsonly'])) ? '' : sprintf("%s %s",__('Download',$this->localizationDomain),$document_type);
				$readoffline .= sprintf ('<div><a class="%s" href="%s?id=%s&read-offline=%s" title="%s %s.%s">%s</a></div>',
					$type,plugins_url("download.php", __FILE__),$post->ID,$type,
					__('Download',$this->localizationDomain),$post->post_name,$type,
					$str_info
				);
			}
			$readoffline .= "</div>";
			if ((is_single() && array_search('top_post',$placements) !== false) || (is_page() && array_search('top_page',$placements) !== false) ) {
				$content = $readoffline . $content;
			}
			if ((is_single() && array_search('bottom_post',$placements) !== false) || (is_page() && array_search('bottom_page',$placements) !== false) ) {
				$content =  $content . $readoffline;
			}	
			return $content;
		}
		
		
		
		function ps_read_offline_shortcode($atts) {
			if (!is_single() && !is_page()) return;
			global $post;
			extract(shortcode_atts(array(
				// default values
				'format'   	=>	'pdf,epub,mobi'
				,'text'		=>	''
				,'icononly' => false
			), $atts));

			// do param testing	
			$formats = array_intersect(array("pdf", "epub", "mobi"), explode(',', $format));		
			$text = str_ireplace('%title%', $post->post_title,$text);

			//
			$formats = array_uintersect(					
					array(
						'pdf' => 'PDF'
						,'epub' => 'ePub'
						,'mobi' => 'mobi'
					)
					, $formats
					, "strcasecmp"
			);			
			if (count($formats)>0) {
				$ret ='<div class="readoffline-shortcode">';
				if ($text !== '') {
					$ret .= sprintf('<div class="readoffline-shortcode-text">%s</div>',$text);
				}
				foreach ($formats as $type => $document_type) {
					$str_info = ($icononly) ? '' : sprintf("%s %s",__('Download',$this->localizationDomain),$document_type);
					$ret .= sprintf ('<div><a class="%s" href="%s?id=%s&read-offline=%s" title="%s %s.%s">%s</a></div>',
						$type,plugins_url("download.php", __FILE__),$post->ID,$type,
						__('Download ',$this->localizationDomain),$post->post_name,$type,
						$str_info
					);
				}
				$ret .= "</div>";
				return $ret;						
			}
			return;
		}

		
		function _version() {
			$default_headers = get_plugin_data( __FILE__, false, false);
			return $default_headers['Version'];
		}
		
		/**
		* @desc Retrieves the plugin options from the database.
		* @return array
		*/
		function getOptions() {
			if (isset($_GET['ps_read_offline_reset']) || !$theOptions = get_option($this->optionsName)) {
				$theOptions = array(
					'ps_read_offline_option_format'=> array('pdf','epub','mobi'),
					'ps_read_offline_option_zip' => array('no'),
					'ps_read_offline_option_placement'=>array('widget'),
					'ps_read_offline_option_iconsonly'=>array('no'),
					'ps_read_offline_option_link_header'=>'Read Offline:'
				);
				update_option($this->optionsName, $theOptions);
			}
			$this->options = $theOptions;
		}
		/**
		* Saves the admin options to the database.
		*/
		function saveAdminOptions(){			
			update_option($this->optionsName, $this->options);
		}

		/**
		* @desc Adds the options subpanel
		*/
		function admin_menu_link() {
			add_options_page('Read Offline', 'Read Offline', 'manage_options', basename(__FILE__), array(&$this,'admin_options_page'));
			add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array(&$this, 'filter_plugin_actions'), 10, 2 );
		}

		/**
		* @desc Adds the Settings link to the plugin activate/deactivate page
		*/
		function filter_plugin_actions($links, $file) {
		   $settings_link = '<a href="options-general.php?page=' . basename(__FILE__) . '">' . __('Settings') . '</a>';
		   array_unshift( $links, $settings_link ); // before other links

		   return $links;
		}

		/**
		* Adds settings/options page
		*/
		function admin_options_page() { 
			if(isset($_POST['ps_read_offline_save'])){
				if (! wp_verify_nonce($_POST['_wpnonce'], 'ps_read_offline-update-options') ) {
					die('Whoops! There was a problem with the data you posted. Please go back and try again.'); 
				}
				$this->options['ps_read_offline_option_format'] = $_POST['ps_read_offline_option_format'];				   
				$this->options['ps_read_offline_option_zip'] = isset($_POST['ps_read_offline_option_zip']) ? $_POST['ps_read_offline_option_zip'] : array('no');				   
				$this->options['ps_read_offline_option_placement'] = isset($_POST['ps_read_offline_option_placement']) ? $_POST['ps_read_offline_option_placement'] : array('widget');				   
				$this->options['ps_read_offline_option_iconsonly'] = isset($_POST['ps_read_offline_option_iconsonly']) ? $_POST['ps_read_offline_option_iconsonly'] : array('no');				   
				$this->options['ps_read_offline_option_link_header'] = esc_attr($_POST['ps_read_offline_option_link_header']);	

				$this->saveAdminOptions();
				_e('<div class="updated"><p>Success! Your changes were sucessfully saved!</p></div>',$this->localizationDomain);
			} ?>			

			<div class="wrap">
			<h2>Read Offline</h2>

			<div style="float:left; width:80%;">
				<form method="post" id="ps_read_offline_options">
				<?php wp_nonce_field('ps_read_offline-update-options'); ?>
					<table width="100%" cellspacing="2" cellpadding="5" class="form-table" > 
						<tr valign="top"> 
							<th width="33%" scope="row">
								<?php _e('Formats available for your visitors', $this->localizationDomain); ?>
								<div class="error" style="display:none;"></div>
							</th> 
							<td>
								<input name="ps_read_offline_option_format[]" id="ps_read_offline_option_format_pdf" type="checkbox" value="pdf" <?php if (in_array('pdf',$this->options['ps_read_offline_option_format'])) echo ' checked="checked" ';?>/> <label for="ps_read_offline_option_format_pdf"><?php _e('PDF', $this->localizationDomain);?></label><br />
								<input name="ps_read_offline_option_format[]" id="ps_read_offline_option_format_epub" type="checkbox" value="epub" <?php if (in_array('epub',$this->options['ps_read_offline_option_format'])) echo ' checked="checked" ';?>/> <label for="ps_read_offline_option_format_epub"><?php _e('ePub', $this->localizationDomain);?></label><br />
								<input name="ps_read_offline_option_format[]" id="ps_read_offline_option_format_mobi" type="checkbox" value="mobi" <?php if (in_array('mobi',$this->options['ps_read_offline_option_format'])) echo ' checked="checked" ';?>/> <label for="ps_read_offline_option_format_mobi"><?php _e('mobi', $this->localizationDomain);?></label><br />
								
								<br /><span class="setting-description"><?php _e("
									If direct linking to ePub and mobi doesn't work, add the following to your .htaccess file:
									<p>
									<div style='font-family:\"Courier New\", Courier, monospace;'>
										AddType application/epub+zip .epub<br/>
										AddType application/x-mobipocket-ebook .mobi
									</div>
									</p>
								", $this->localizationDomain); ?>
							</td> 
						</tr>
						<tr valign="top"> 
							<th width="33%" scope="row"><?php _e('Download link placements', $this->localizationDomain); ?></th>
							<td>
								<input name="ps_read_offline_option_placement[]" id="ps_read_offline_option_placement_top_post" type="checkbox" value="top_post" <?php if (in_array('top_post',$this->options['ps_read_offline_option_placement'])) echo ' checked="checked" ';?>/> <label for="ps_read_offline_option_placement_top_post"><?php _e('At the top of the post', $this->localizationDomain);?></label><br />
								<input name="ps_read_offline_option_placement[]" id="ps_read_offline_option_placement_bottom_post" type="checkbox" value="bottom_post" <?php if (in_array('bottom_post',$this->options['ps_read_offline_option_placement'])) echo ' checked="checked" ';?>/> <label for="ps_read_offline_option_placement_bottom_post"><?php _e('On the botom of the post', $this->localizationDomain);?></label><br />
								<input name="ps_read_offline_option_placement[]" id="ps_read_offline_option_placement_top_page" type="checkbox" value="top_page" <?php if (in_array('top_page',$this->options['ps_read_offline_option_placement'])) echo ' checked="checked" ';?>/> <label for="ps_read_offline_option_placement_top_page"><?php _e('At the top of the page', $this->localizationDomain);?></label><br />
								<input name="ps_read_offline_option_placement[]" id="ps_read_offline_option_placement_bottom_page" type="checkbox" value="bottom_page" <?php if (in_array('bottom_page',$this->options['ps_read_offline_option_placement'])) echo ' checked="checked" ';?>/> <label for="ps_read_offline_option_placement_bottom_page"><?php _e('On the botom of the page', $this->localizationDomain);?></label><br />
								<span class="setting-description"><?php _e("Also available via the the <a href='widgets.php'>Read Offline widget</a> and the <a href='http://soderlind.no/archives/2012/10/01/read-offline/#shortcode'>[readoffline] shortcode</a>.", $this->localizationDomain); ?>
							</td> 
						</tr>
						<tr valign="top"> 
							<th width="33%" scope="row"><?php _e('Download link header:', $this->localizationDomain); ?></th>
							<td>
								<input class="regular-text" name="ps_read_offline_option_link_header" id="ps_read_offline_option_link_header" type="text" value="<?php printf("%s", stripslashes($this->options['ps_read_offline_option_link_header'])); ?>" />
								<br /><span class="setting-description"><?php _e("Use %title% to insert the post and page title", $this->localizationDomain); ?>
							</td> 
						</tr>
						
						<tr valign="top"> 
							<th width="33%" scope="row"><?php _e('Download link, icons only?:', $this->localizationDomain); ?></th>
							<td>
								<input name="ps_read_offline_option_iconsonly[]" id="ps_read_offline_option_iconsonly_yes" type="radio" value="yes" <?php if (in_array('yes',$this->options['ps_read_offline_option_iconsonly'])) echo ' checked="checked" ';?>/> <label for="ps_read_offline_option_iconsonly_yes"><?php _e('Yes', $this->localizationDomain);?></label><br />
								<input name="ps_read_offline_option_iconsonly[]" id="ps_read_offline_option_iconsonly_no" type="radio" value="no" <?php if (in_array('no',$this->options['ps_read_offline_option_iconsonly'])) echo ' checked="checked" ';?>/> <label for="ps_read_offline_option_iconsonly_no"><?php _e('No', $this->localizationDomain);?></label><br />
								<br /><span class="setting-description"><?php _e("", $this->localizationDomain); ?>
							</td> 
						</tr>
						
					</table>
					<p class="submit"> 
						<input type="submit" name="ps_read_offline_save" class="button-primary" value="<?php _e('Save Changes', $this->localizationDomain); ?>" /> <a href="options-general.php?page=<?php echo basename(__FILE__);?>&ps_read_offline_reset" class="submit"><?php _e('Reset', $this->localizationDomain);?></a>
					</p>
				</form>	
			</div>
			<div style="float:left;width:20%;">
				<div style="float:right;text-align:center;width:200px;padding:5px; border: 2px solid #ccc; background-color: #fff;">
					<p>
						 I'm coding after midnight. You can buy me some  coffees to keep me awake :) Thank you! 
					 </p>
					 <p>
					 	<form action="https://www.paypal.com/cgi-bin/webscr" method="post"><div class="paypal-donations"><input type="hidden" name="cmd" value="_donations"><input type="hidden" name="business" value="HYB5R27TC6W8J"><input type="hidden" name="page_style" value="Donate"><input type="hidden" name="return" value="http://soderlind.no/donate/"><input type="hidden" name="currency_code" value="USD"><input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_SM.gif" name="submit" alt="PayPal - The safer, easier way to pay online."><img alt="" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1"></div></form>
					 </p>
				</div>
			</div>
			<?php
		}		   
	} //End Class
} //End if class exists statement


if (!class_exists('ps_read_offline_widget')) {
	class ps_read_offline_widget extends WP_Widget {
	
		var $localizationDomain = "ps_read_offline";
	
		function __construct() {	
			parent::__construct(
				'read_offline_widget', // Base ID
				'Read Offline', // Name
				array( 'description' => __( 'Adds a download link for the current post and page. PDF, EPUB and MOBI is supported. Configurable in Settings->Read Offline', $this->localizationDomain ), ) // Args
			);	
		}
		function widget($args, $instance) {
			global $post;
			
			if (!is_single() && !is_page()) return;
			
			extract($args, EXTR_SKIP);
			echo $before_widget;


			$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
			$text = empty($instance['text']) ? ' ' : apply_filters('widget_text', $instance['text']);
			
			$icononly = ($instance['icononly'] == 'yes');

			$text = str_ireplace('%title%', $post->post_title,$text);
			if ( !empty( $title ) ) { 
				echo $before_title . $title . $after_title; 
			}
			echo '<div class="readoffline-widget">';
				$options = get_option('ps_read_offline_options');
				$formats = array_uintersect(					
					array(
						'pdf' => 'PDF'
						,'epub' => 'ePub'
						,'mobi' => 'mobi'
					)
					, $options['ps_read_offline_option_format']
					, "strcasecmp"
				);
				echo  $text, '<br/>';
				
				if ($icononly === true) {
					foreach ($formats as $type => $document_type) {
						printf ('<div><a class="%s" href="%s?id=%s&read-offline=%s" title="%s %s.%s"></a></div>',
							$type,plugins_url("download.php", __FILE__),$post->ID,$type,
							__('Download ',$this->localizationDomain),$post->post_name,$type
						);
					}
				} else {					
					echo "<ul>";
					foreach ($formats as $type => $document_type) {
						printf ('<li><a class="%s" href="%s?id=%s&read-offline=%s" title="%s %s.%s">%s%s</a></li>',
							$type,plugins_url("download.php", __FILE__),$post->ID,$type,
							__('Download ',$this->localizationDomain),$post->post_name,$type,
							__('Download ',$this->localizationDomain),$document_type
						);
					}
					echo "</ul>";
				}
			echo '</div>';

			echo $after_widget;
		}
		
		function update($new_instance, $old_instance) {
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['text'] = strip_tags($new_instance['text']);
			$instance['icononly'] = $new_instance['icononly'];
			
			return $instance;
		}
		
		function form($instance) {
			$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '', 'icononly' => 'no'  ));
			$title = strip_tags($instance['title']);
			$text = strip_tags($instance['text']);
			$icononly = $instance['icononly'];		
			printf('<p><label for="%s">%s <input class="widefat" id="%s" name="%s" type="text" value="%s" /></label></p>',$this->get_field_id('title'),__('Title:',$this->localizationDomain),$this->get_field_id('title'),$this->get_field_name('title'),attribute_escape($title));
			printf('<p><label for="%s">%s <textarea class="widefat" id="%s" name="%s" >%s</textarea></label></p>',$this->get_field_id('text'),__('Text:',$this->localizationDomain),$this->get_field_id('text'),$this->get_field_name('text'),attribute_escape($text));
			printf('
				<p>Icons only?: 
					<input class="radio" type="radio" %s id="%s_yes" name="%s" value="yes"/> <label for="%s_yes">%s</label> 
					<input class="radio" type="radio" %s id="%s_no" name="%s" value="no"/> <label for="%s_no">%s</label>
				</p>',
					checked( $instance['icononly'], 'yes', false),$this->get_field_id( 'icononly' ),$this->get_field_name( 'icononly' ),$this->get_field_id( 'icononly' ),__('Yes'),
					checked( $instance['icononly'], 'no', false), $this->get_field_id( 'icononly' ),$this->get_field_name( 'icononly' ),$this->get_field_id( 'icononly' ),__('No')
			);	
		}
	} // end class
	add_action( 'widgets_init', create_function( '', 'register_widget( "ps_read_offline_widget" );' ) );
}


if (class_exists('ps_read_offline')) { 
	$ps_read_offline_var = new ps_read_offline();
}
?>