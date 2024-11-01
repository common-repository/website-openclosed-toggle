<?php

if( !defined( 'ABSPATH' ) ) { exit; }

function rs_woct_admin_init() {
	$update = rs_woct_update_settings();
	$option = rs_woct_get_option(); ?>
	<div class="wrap">
		<h1><?php echo RS_WOCT__PLUGIN_NAME; ?></h1>
		<?php if( $update == TRUE ) { ?><div id="message" class="updated notice is-dismissible"><p>Settings updated.</p></div><?php } ?>
		<p>If your theme has a <em>closed.php</em> file, this will override both <em>'Closed message'</em> and <em>'Closed HTML'</em> settings.</p>
		<form method="post" action="<?php echo RS_WOCT__PLUGIN_ADMIN_URL; ?>">
			<table class="form-table">
				<tr>
					<th scope="row"><label for="website_open">Website open?</label></th>
					<td><p><label><input name="website_open" type="radio" value="yes" class="tog"<?php if( $option['website_open'] == 'yes' ) { ?> checked="checked"<?php } ?> /> Yes</label></p>
					<p><label><input name="website_open" type="radio" value="no" class="tog"<?php if( $option['website_open'] == 'no' ) { ?> checked="checked"<?php } ?> /> No</label></p></td>
				</tr>
				<tr>
					<th scope="row"><label for="redirect_url">Redirect URL</label></th>
					<td><p>A web URL to redirect visitors to when your site is closed.</p>
					<input name="redirect_url" type="url" id="redirect_url" value="<?php echo esc_url_raw( $option['redirect_url'], array( 'http', 'https' ) ); ?>" class="regular-text" />
					<p><em>This overrides all messages including your theme's closed.php.</em></p></td>
				</tr>
				<tr>
					<th scope="row"><label for="closed_message">Closed message</label></th>
					<td><p>A short message for visitors to read when your website is closed.</p>
					<input name="closed_message" type="text" id="closed_message" value="<?php echo esc_html( stripslashes( $option['closed_message'] ) ); ?>" class="regular-text" /></td>
				</tr>
				<tr>
					<th scope="row"><label for="closed_html">Closed HTML</label></th>
					<td><p>Paste the HTML for your closed message. This should be a complete HTML page.</p>
					<p><textarea name="closed_html" rows="10" cols="50" id="closed_html" class="large-text code"><?php echo stripslashes( stripslashes( $option['closed_html'] ) ); ?></textarea></p>
					<p><em>This will override 'Closed message'.</em></p></td>
				</tr>
				<tr>
					<th scope="row"><label for="bypass_paths">Bypass paths</label></th>
					<td><p>Provide any paths which should bypass the closed page to be viewed as normal eg <em>/public/</em> or <em>/register/</em>.</p>
					<p><textarea name="bypass_paths" rows="10" cols="50" id="bypass_paths" class="large-text code"><?php echo $option['bypass_paths']; ?></textarea></p>
					<p><em>One path per line.</em></p></td>
				</tr>
				<tr>
					<th scope="row"><label for="bypass_get_key">Bypass key</label></th>
					<td><p>This query string key will allow visitors to bypass the closed page entirely on any path.</p>
					<p>This is useful for showing the site to clients before the site is ready to be opened to the public.</p>
					<input name="bypass_get_key" type="text" id="bypass_get_key" value="<?php echo esc_html( $option['bypass_get_key'] ); ?>" class="regular-text code" />
					<p><em>Your bypass URL: <strong><?php echo home_url( '/?'.$option['bypass_get_key'].'=1' ); ?></strong></em></p>
					<p><em>Unset bypass URL: <strong><?php echo home_url( '/?'.$option['bypass_get_key'].'=unset' ); ?></strong></em></p>
					<p><strong>NOTE:</strong> This is only effective while caching is switched off.</p></td>
				</tr>
				<tr>
					<th scope="row">Delete settings on deactivation?</th>
					<td><label for="delete_option_on_deactivate"><input name="delete_option_on_deactivate" type="checkbox" id="delete_option_on_deactivate" value="1"<?php if( $option['delete_option_on_deactivate'] == '1' ) { ?> checked="checked"<?php } ?> /> Check this box to delete your settings above when you deactivate the plugin.</label></td>
				</tr>
			</table>
			<p class="beer">Do you find this plugin useful? If you do and you'd like to buy me a beer to say thanks, <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=C2RMWG8RH2XMY" onclick="window.open( this ); return false;">click here</a>. Thanks!</p>
			<?php wp_nonce_field( 'rs_woct_update_settings' ); ?>
			<?php submit_button(); ?>
		</form>
	</div><?php
}