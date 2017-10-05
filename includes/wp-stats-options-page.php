<div class="wrap">
	<div class="bsf-options-form-wrap clearfix">
		<h1><?php esc_html_e( 'WP Theme Stats Settings', 'wp-active-stats' ); ?></h1>
		<form method="post" action="options.php"> 
			<?php settings_fields( 'wp-active-stats-settings-group' ); ?>
			<?php do_settings_sections( 'wp-active-stats-settings-group' ); ?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e( 'WP Theme Name', 'bsf-docs' ); ?></th>
					<td>
						<input type="text" class="code" name="wp_theme_name" value="<?php echo get_option( 'wp_theme_name' ); ?> "/>
					</td>
				</tr>	
				<tr valign="top">
					<th scope="row"><?php _e( 'WP Theme Author', 'bsf-docs' ); ?></th>
					<td>
						<input type="text" class="code" name="wp_theme_author" value="<?php echo get_option( 'wp_theme_author' ); ?> "/>
					</td>
				</tr>	
				<tr valign="top">
					<th scope="row"><?php _e( 'WP Theme Tag', 'bsf-docs' ); ?></th>
					<td>
						<input type="text" class="code" name="wp_theme_tag" value="<?php echo get_option( 'wp_theme_tag' ); ?> "/>
					</td>
				</tr>	
			</table>
			<?php submit_button(); ?>
		</form>
	</div>

	<div class="wp-stats-shortcodes-wrap">
		<h2 class="title"><?php _e( 'Shortcodes', 'wp-active-stats' ); ?></h2>
		<p><?php _e( 'Copy below shortcode and paste it into your post, page, or text widget.', 'wp-active-stats' ); ?></p>

		<div class="wp-active-stats-container">
			<table class="form-table">
				 <tr valign="top">
					 <th scope="row"><?php _e( 'Display Theme Active Install', 'wp-active-stats' ); ?></th>
					<td>
						<div class="wp-stats-shortcode-container wp-ui-text-highlight">
						   [wp_theme_active_install]
						</div>  
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>

