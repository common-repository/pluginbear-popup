<h1>PluginBear PopUp</h1>

<?php
	global $wpdb;
	
	// Defaults
		$directory = '/wp-content/plugins/pluginbear-popup';
		$table_name = $wpdb->prefix."pluginbear_popup";
		
	// Update Settings
		if (isset($_POST['background'])) {
			if (!$_POST['delay']) { $delay = 0; } else { $delay = $_POST['delay']; }
			$wpdb->update($table_name,
				array(
					'background' => $_POST['background'],
					'opacity' => $_POST['opacity'],
					'foreground' => $_POST['foreground'],
					'width' => $_POST['width'],
					'height' => $_POST['height'],
					'delay' => $delay,
					'border_radius' => $_POST['border_radius'],
					'html_content' => $_POST['html_content'],
					'page_id' => $_POST['page_id'],
					'iframe_src' => $_POST['iframe_src'],
					'content_type' => $_POST['content_type'],
					'location' => $_POST['location']
				),
				array(
					'id' => $_POST['id']
				)
			);
		}
		
	// Get Settings
		$settings = $wpdb->get_row('SELECT * FROM '.$table_name);
?>

<div id="pluginbear_container" class="clearfix">
	<?php  if (isset($_POST['like_text'])) { ?>
    <div id="popup_message" class="updated">
        <p>Global settings updated.</p>
    </div>
    <?php } ?>
    <div id="content_container">
        <h3>Settings</h3>
        <form action="" method="post" id="popup_update">
            <dl class="clearfix">
              <dt><label for="background">Background</label></dt>
                <dd><input type="text" class="text" name="background" id="background" value="<?php echo $settings->background; ?>"></dd>
                <dt><label for="opacity">Background Opacity</label></dt>
                <dd class="clearfix"><div id="background_slider"></div> <input type="hidden" name="opacity" id="opacity" value="<?php echo $settings->opacity; ?>"></dd>
                <dt><label for="foreground">Foreground</label></dt>
                <dd><input type="text" class="text" name="foreground" id="foreground" value="<?php echo $settings->foreground; ?>"></dd>
                <dt><label for="border_radius">Border Radius</label></dt>
                <dd class="clearfix"><div id="radius_slider"></div> <input type="hidden" name="border_radius" id="border_radius" value="<?php echo $settings->border_radius; ?>"></dd>
                <dt><label for="width">Width (px or %)</label></dt>
                <dd><input type="text" class="text" name="width" id="width" value="<?php echo $settings->width; ?>"></dd>
                <dt><label for="height">Height (px or %)</label></dt>
                <dd><input type="text" class="text" name="height" id="height" value="<?php echo $settings->height; ?>"></dd>
                <dt><label for="delay">Popup Delay (seconds)</label></dt>
                <dd><input type="text" class="text" name="delay" id="delay" value="<?php echo $settings->delay; ?>"></dd>
                <dt><label for="height">Content Type</label></dt>
                <dd>
                	<select name="content_type" id="content_type">
                    	<option value="html_content" <?php if ($settings->content_type=='html_content') { echo 'selected="selected"'; } ?>>HTML</option>
                    	<option value="iframe_src" <?php if ($settings->content_type=='iframe_src') { echo 'selected="selected"'; } ?>>iFrame</option>
                    	<option value="page_id" <?php if ($settings->content_type=='page_id') { echo 'selected="selected"'; } ?>>Post / Page</option>
                    </select>
                </dd>
                <dt class="<?php if ($settings->content_type!='html_content') { echo 'cont_hidden '; } ?>popup_cont html_content_cont"><label for="html_content">HTML</label></dt>
                <dd class="<?php if ($settings->content_type!='html_content') { echo 'cont_hidden '; } ?>popup_cont html_content_cont"><?php wp_editor(stripslashes($settings->html_content),'html_content'); ?></dd>
                <dt class="<?php if ($settings->content_type!='iframe_src') { echo 'cont_hidden '; } ?>popup_cont iframe_src_cont"><label for="iframe_src">iFrame</label></dt>
                <dd class="<?php if ($settings->content_type!='iframe_src') { echo 'cont_hidden '; } ?>popup_cont iframe_src_cont"><input type="text" name="iframe_src" id="iframe_src" value="<?php echo $settings->iframe_src; ?>"></dd>
                <dt class="<?php if ($settings->content_type!='page_id') { echo 'cont_hidden '; } ?>popup_cont page_id_cont"><label for="page_id">Post / Page</label></dt>
                <dd class="<?php if ($settings->content_type!='page_id') { echo 'cont_hidden '; } ?>popup_cont page_id_cont">
                	<select name="page_id" id="page_id">
                    	<optgroup label="Posts">
							<?php
                                query_posts(array('post_type'=>'post','posts_per_page'=>-1));
                                while(have_posts()):the_post();
                            ?>
                                <option value="<?php the_ID(); ?>" <?php if (get_the_ID()==$settings->page_id) { echo 'selected="selected"'; } ?>><?php the_title(); ?></option>
                            <?php endwhile;wp_reset_query(); ?>
                        </optgroup>
                    	<optgroup label="Pages">
							<?php
                                query_posts(array('post_type'=>'page','posts_per_page'=>-1));
                                while(have_posts()):the_post();
                            ?>
                                <option value="<?php the_ID(); ?>" <?php if (get_the_ID()==$settings->page_id) { echo 'selected="selected"'; } ?>><?php the_title(); ?></option>
                            <?php endwhile;wp_reset_query(); ?>
                        </optgroup>
                    </select>
                </dd>
                <dt>Location</dt>
                <dd>
                	<label for="loc_home"> <input type="radio" name="location" id="loc_home" value="home" <?php if ($settings->location=="home") { echo 'checked="checked"'; } ?>> Show on Home</label>
                	<label for="loc_all"> <input type="radio" name="location" id="loc_all" value="all" <?php if ($settings->location=="all") { echo 'checked="checked"'; } ?>> Show on All</label>
                </dd>
            </dl>
            <input type="hidden" name="id" value="<?php echo $settings->id; ?>">
            <input type="submit" value="Update global settings">
        </form>
        
        <h3>Preview</h3>
        
        <div id="popup_demo" class="popup">
            <p class="popup_content">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque rhoncus aliquam metus. Pellentesque nulla mauris, laoreet et porttitor in, adipiscing et lacus. Phasellus dapibus sem quis purus congue pulvinar. Sed placerat mattis urna a feugiat. Integer tempor lacus nec sapien adipiscing vitae dictum felis dignissim. Phasellus dignissim nisl orci. Quisque magna est, congue et volutpat eu, lacinia eu leo. Nam iaculis tincidunt leo nec sodales. Quisque placerat purus eget odio lacinia rutrum. Duis elementum nunc eget magna iaculis id consequat metus consectetur. Nulla facilisi. Phasellus in ligula ante. Proin urna tortor, feugiat iaculis tincidunt vitae, aliquet vitae mi.</p>
            <p class="popup_content">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque rhoncus aliquam metus. Pellentesque nulla mauris, laoreet et porttitor in, adipiscing et lacus. Phasellus dapibus sem quis purus congue pulvinar. Sed placerat mattis urna a feugiat. Integer tempor lacus nec sapien adipiscing vitae dictum felis dignissim. Phasellus dignissim nisl orci. Quisque magna est, congue et volutpat eu, lacinia eu leo. Nam iaculis tincidunt leo nec sodales. Quisque placerat purus eget odio lacinia rutrum. Duis elementum nunc eget magna iaculis id consequat metus consectetur. Nulla facilisi. Phasellus in ligula ante. Proin urna tortor, feugiat iaculis tincidunt vitae, aliquet vitae mi.</p>
            <?php
				echo '
					<div id="pluginbear-preview-popup-panel" style="background:'.$settings->foreground.';border-radius:'.$settings->border_radius.'px;;">  
						<div id="pluginbear-preview-popup-content">
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque rhoncus aliquam metus. Pellentesque nulla mauris, laoreet et porttitor in, adipiscing et lacus. Phasellus dapibus sem quis purus congue pulvinar. Sed placerat mattis urna a feugiat. Integer tempor lacus nec sapien adipiscing vitae dictum felis dignissim. Phasellus dignissim nisl orci. Quisque magna est, congue et volutpat eu, lacinia eu leo. Nam iaculis tincidunt leo nec sodales. Quisque placerat purus eget odio lacinia rutrum. Duis elementum nunc eget magna iaculis id consequat metus consectetur. Nulla facilisi. Phasellus in ligula ante. Proin urna tortor, feugiat iaculis tincidunt vitae, aliquet vitae mi.</p>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque rhoncus aliquam metus. Pellentesque nulla mauris, laoreet et porttitor in, adipiscing et lacus. Phasellus dapibus sem quis purus congue pulvinar. Sed placerat mattis urna a feugiat. Integer tempor lacus nec sapien adipiscing vitae dictum felis dignissim. Phasellus dignissim nisl orci. Quisque magna est, congue et volutpat eu, lacinia eu leo. Nam iaculis tincidunt leo nec sodales. Quisque placerat purus eget odio lacinia rutrum. Duis elementum nunc eget magna iaculis id consequat metus consectetur. Nulla facilisi. Phasellus in ligula ante. Proin urna tortor, feugiat iaculis tincidunt vitae, aliquet vitae mi.</p>
						</div>
						<p id="pluginbear-preview-popup-close"><a href="#" style="color:'.$settings->background.';">Close</a></p>
					</div>
					<div id="pluginbear-preview-popup-container" style="background:'.$settings->background.';opacity:'.$settings->opacity.';filter:alpha(opacity='.($settings->opacity*100).');"></div>
				';
			?>
        </div>
    </div>
    <div id="donations_container">
        <h3>Keep this plugin free!</h3>
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
            <input type="hidden" name="cmd" value="_s-xclick">
            <input type="hidden" name="hosted_button_id" value="7JHGJL8PNY6X8">
            <input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal — The safer, easier way to pay online.">
            <img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
        </form>
        <p>Thanks for trying out our plugin! We hope it does what you need. If you have any feature requests or need some support, please email us at <a href="mailto:support@pluginbear.com">support@pluginbear.com</a> and we&rsquo;ll see if we can help you out.</p>
    </div>
</div>