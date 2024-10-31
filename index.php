<?php
	/*
	Plugin Name: PluginBear PopUp
	Plugin URI: http://www.pluginbear.com/popup
	Description: Create a configurable popup for your website.
	Version: 1
	Author: PluginBear
	Author URI: http://www.pluginbear.com
	*/
	
	// Defaults
		$directory = '/wp-content/plugins/pluginbear-popup';
	
	// Install Database
		global $db_version;
		$db_version = "1.0";
		
		function pluginbear_popup_db_install() {
			global $wpdb;
			global $db_version;
			
			$table_name = $wpdb->prefix."pluginbear_popup";
			
			$sql = "CREATE TABLE ".$table_name." (
				id MEDIUMINT(9) NOT NULL AUTO_INCREMENT,
				background VARCHAR(255) DEFAULT '' NOT NULL,
				opacity VARCHAR(255) DEFAULT '' NOT NULL,
				foreground VARCHAR(255) DEFAULT '' NOT NULL,
				width VARCHAR(255) DEFAULT '' NOT NULL,
				height VARCHAR(255) DEFAULT '' NOT NULL,
				delay VARCHAR(255) DEFAULT '' NOT NULL,
				border_radius VARCHAR(255) DEFAULT '' NULL,
				html_content LONGTEXT DEFAULT '' NULL,
				page_id VARCHAR(255) DEFAULT '' NULL,
				iframe_src VARCHAR(255) DEFAULT '' NULL,
				content_type VARCHAR(255) DEFAULT '' NULL,
				location VARCHAR(255) DEFAULT '' NOT NULL,
				UNIQUE KEY id (id)
			);";
			
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);
			
			add_option("db_version", $db_version);
		}
		
		function pluginbear_popup_db_install_data() {
			global $wpdb;
			
			$table_name = $wpdb->prefix."pluginbear_popup";
			
			$db_content = array(
			  'background' => '#000000',
			  'opacity' => 0.9,
			  'foreground' => '#FFFFFF',
			  'width' => "25%",
			  'height' => "50%",
			  'delay' => "0",
			  'border_radius' => 10,
			  'html_content' => "",
			  'page_id' => "",
			  'iframe_src' => "",
			  'content_type' => "html_content",
			  'location' => "home"
		   );
			
			$wpdb->insert($table_name,array('background'=>$db_content['background'],'opacity'=>$db_content['opacity'],'foreground'=>$db_content['foreground'],'width'=>$db_content['width'],'height'=>$db_content['height'],'delay'=>$db_content['delay'],'border_radius'=>$db_content['border_radius'],'html_content'=>$db_content['html_content'],'page_id'=>$db_content['page_id'],'iframe_src'=>$db_content['iframe_src'],'content_type'=>$db_content['content_type'],'location'=>$db_content['location']));
		}
		
		register_activation_hook(__FILE__,'pluginbear_popup_db_install');
		register_activation_hook(__FILE__,'pluginbear_popup_db_install_data');
		
	// Get Settings
		global $wpdb;
		$table_name = $wpdb->prefix."pluginbear_popup";
		$settings = $wpdb->get_row('SELECT * FROM '.$table_name);
	
	// Create WP Menu
		if (!function_exists('pluginbear_menu')) {
			add_action('admin_menu', 'pluginbear_menu');
			
			function pluginbear_menu() {
				add_menu_page('PluginBear', 'PluginBear', 'manage_options', 'pluginbear', 'pluginbear_function');
			}
			
			function pluginbear_function() {
				if (!current_user_can('manage_options'))  {
					wp_die( __('You do not have sufficient permissions to access this page.') );
				}
				echo '<p>PluginBear Homepage</p>';
			}
		}
	
	// Create popup Submenu
		add_action('admin_menu', 'pluginbear_popup_submenu');
		
		function pluginbear_popup_submenu() {
			add_submenu_page("pluginbear", "PluginBear PopUp", "PopUp", 0, "pluginbear_popup", "pluginbear_popup_function");
		}
		
		function pluginbear_popup_function() {
			if (!current_user_can('manage_options'))  {
				wp_die( __('You do not have sufficient permissions to access this page.') );
			}
			include("settings.php");
		}
	
	if (is_admin()&&($_GET['page']=='pluginbear_popup')) {
		// Add Admin Styles
			wp_enqueue_style('pluginbear-colorpicker',$directory.'/css/pluginbear_colorpicker.css',false,'1.0','all');
			wp_enqueue_style('pluginbear-slider',$directory.'/css/pluginbear_slider.css',false,'1.0','all');
			wp_enqueue_style('pluginbear-popup',$directory.'/css/pluginbear_popup.css',false,'1.0','all');
		
		// Add Admin Scripts
			wp_enqueue_script('pluginbear-colorpicker-js',$directory.'/js/pluginbear_colorpicker.js',array('jquery'),'1.0',true);
			wp_enqueue_script('pluginbear-slider-js',$directory.'/js/pluginbear_slider.js',array('jquery'),'1.0',true);
			wp_enqueue_script('pluginbear-popup-admin',$directory.'/js/pluginbear_popup_admin.js',array('jquery'),'1.0',true);
			wp_enqueue_script('pluginbear-popup',$directory.'/js/pluginbear_popup.js',array('jquery'),'1.0',true);
	}
	
	if (!is_admin()) {
		// Add Public Styles
			wp_enqueue_style('pluginbear-popup',$directory.'/css/pluginbear_popup.css',false,'1.0','all');
		
		// Add Public Scripts
			wp_enqueue_script('pluginbear-popup',$directory.'/js/pluginbear_popup.js',array('jquery'),'1.0',true);
	}
		
	// Add Global Settings
		function pluginbear_popup_register_shortcodes() {
			global $settings;
			global $post;
				
			extract(shortcode_atts(array(
				'background' => $settings->background,
				'opacity' => $settings->opacity,
				'foreground' => $settings->foreground,
				'width' => $settings->width,
				'height' => $settings->height,
				'delay' => $settings->delay,
				'border_radius' => $settings->border_radius,
				'html_content' => $settings->html_content,
				'page_id' => $settings->page_id,
				'iframe_src' => $settings->iframe_src,
				'content_type' => $settings->content_type,
				'location' => $settings->location
			), $atts));
			
			if (is_front_page()&&$settings->location=="home"||$settings->location=="all") {
				echo '
					<div id="pluginbear-popup-panel" style="background:'.$foreground.';border-radius:'.$border_radius.'px;width:'.$width.';height:'.$height.';">  
						<div id="pluginbear-popup-content">';
						if ($content_type=="html_content") { echo apply_filters('the_content',$html_content); }
						else if ($content_type=="iframe_src") { echo '<iframe src="'.$iframe_src.'" width="100%" height="100%" frameborder="0"></iframe>'; }
						else if ($content_type=="page_id") {
							query_posts(array('post_type'=>array('post','page'),'p'=>$page_id));
                            while(have_posts()):the_post();
							echo 'URL: '.$location;
                                echo apply_filters('the_content',get_the_content());
                            endwhile;wp_reset_query();
						}
				echo '
						</div>
						<p id="pluginbear-popup-close"><a href="#" style="color:'.$background.';">Close</a></p>
					</div>
					<div id="pluginbear-popup-container" style="background:'.$background.';opacity:'.$opacity.';filter:alpha(opacity='.($opacity*100).');"></div>
					<script>var delay = '.$settings->delay.'000;</script>
				';
			}
		}
		
		add_action('wp_footer', 'pluginbear_popup_register_shortcodes');
		
	// Uninstall
		function popup_uninstall() {
			global $wpdb;
			
			$table_name = $wpdb->prefix."pluginbear_popup";
			$sql = "DROP TABLE ".$table_name;
			$wpdb->query($sql);
		}
		
		register_deactivation_hook(__FILE__, 'popup_uninstall');