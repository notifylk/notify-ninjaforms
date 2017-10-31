<?php

function notify_ninja_regsettings() {
    register_setting('notify_ninja_settings_group', 'notify_ninja_key_phone');
    register_setting('notify_ninja_settings_group', 'notify_ninja_key_fname');
    register_setting('notify_ninja_settings_group', 'notify_ninja_userid');
    register_setting('notify_ninja_settings_group', 'notify_ninja_apikey');
    register_setting('notify_ninja_settings_group', 'notify_ninja_senderid');
    register_setting('notify_ninja_settings_group', 'notify_ninja_groupid');
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
    		<th scope="row">Group ID to Save Contact</th>
    		<td>
			<input type="text" class="regular-text" name="notify_ninja_groupid" value="<?php echo esc_attr(get_option('notify_ninja_groupid')); ?>" />
			<p class="description">Enter a Notify Group ID if you need to assign the contact number into a group while saving.<br>Keep it empty to ignore. You can see group IDs in <a target="_blank" href="https://app.notify.lk/contacts/groups">Groups</a> page.</p>
			</td>
    	    </tr>

    	    <tr valign="top">
    		<th scope="row">Ninja Forms - Phone Number Field Key</th>
    		<td>
		    <input type="text" class="regular-text" name="notify_ninja_key_phone" value="<?php echo esc_attr(get_option('notify_ninja_key_phone')); ?>" />
		    <p class="description"><b>This field is required</b> in order to work this integration. Eg: phone_12412321</p>
		</td>
    	    </tr>	
			
			<tr valign="top">
    		<th scope="row">Ninja Forms - First Name Field Key</th>
    		<td>
		    <input type="text" class="regular-text" name="notify_ninja_key_fname" value="<?php echo esc_attr(get_option('notify_ninja_key_fname')); ?>" />
		    <p class="description">Optional. Eg: textbox_150345329374</p>
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
