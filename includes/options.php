<?php

function notify_ninja_regsettings() {
    register_setting('notify_ninja_settings_group', 'notify_ninja_key_phone');
    register_setting('notify_ninja_settings_group', 'notify_ninja_userid');
    register_setting('notify_ninja_settings_group', 'notify_ninja_apikey');
    register_setting('notify_ninja_settings_group', 'notify_ninja_senderid');
    register_setting('notify_ninja_settings_group', 'notify_ninja_message');
}

function notify_ninja_options() {
    add_submenu_page('options-general.php', 'Notify for Ninja', 'Notify for Ninja', 'manage_options', 'notify_ninja_options', 'notify_ninja_options_page');
    add_action('admin_init', 'notify_ninja_regsettings');
}

add_action('admin_menu', 'notify_ninja_options');

function notify_ninja_options_page() {
    ?>
    <div class="wrap">
        <h1>Notify.Lk SMS for Ninja Forms</h1>
        <form method="post" action="options.php">
	    <?php settings_fields('notify_ninja_settings_group'); ?>
	    <?php do_settings_sections('notify_ninja_settings_group'); ?>
    	<table class="form-table">
    	    <tr valign="top">
    		<th scope="row">Notify.Lk User ID</th>
    		<td><input type="text" class="regular-text" name="notify_ninja_userid" value="<?php echo esc_attr(get_option('notify_ninja_userid')); ?>" /></td>
    	    </tr>

    	    <tr valign="top">
    		<th scope="row">Notify.Lk API Key</th>
    		<td><input type="text" class="regular-text" name="notify_ninja_apikey" value="<?php echo esc_attr(get_option('notify_ninja_apikey')); ?>" /></td>
    	    </tr>

    	    <tr valign="top">
    		<th scope="row">Notify.Lk Sender ID</th>
    		<td><input type="text" class="regular-text" name="notify_ninja_senderid" value="<?php echo esc_attr(get_option('notify_ninja_senderid')); ?>" /></td>
    	    </tr>

    	    <tr valign="top">
    		<th scope="row">Ninja Forms - Phone Number Field Key or Static phone number</th>
    		<td>
		    <input type="text" class="regular-text" name="notify_ninja_key_phone" value="<?php echo esc_attr(get_option('notify_ninja_key_phone')); ?>" />
		    <p class="description">If you need to send SMS to form filled phone number enter field key as a shortcode. Eg: [phone_12412321]<br>If you need to receive a SMS to yourself add the phone number. Eg: 94777123456</p>
		</td>
    	    </tr>	

    	    <tr valign="top">
    		<th scope="row">Message to send</th>
    		<td>
		    <textarea class="regular-text" name="notify_ninja_message" ><?php echo esc_attr(get_option('notify_ninja_message')); ?></textarea>
		    <p class="description">You can use shortcodes for Ninja Form fields. Eg: [text_1232542]</p>
		</td>
    	    </tr>
	    
	    <tr>
		<td colspan="2">
		    
		</td>
	    </tr>
    	</table>

	    <?php submit_button(); ?>

        </form>
    </div>
    <?php
}
