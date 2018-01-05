<?php
/**
 * Plugin Name:       NotifyLK SMS for Ninja Forms
 * Description:       Send SMS for Ninja Form submissions with Notify.LK SMS Gateway.
 * Version:           0.1
 * Author:            Notify.lk
 * Author URI:        http://notify.lk/
 * License:           GPLv2 or laterx
 * Text Domain:       notifylk
 */
include 'includes/core-import.php';

function notifyNinjaHead() {
    ?>
    <script>var ninja_notify_plugin_url = "<?php echo plugins_url("", __FILE__); ?>";</script>
    <?php
}

add_action('wp_head', 'notifyNinjaHead');

/*
 * 
 * Format phone number to support API format
 * 
 */

function notifyReformatPhoneNumbers($value) {
    $number = preg_replace("/[^0-9]/", "", $value);
    if (strlen($number) == 9) {
	$number = "94" . $number;
    } elseif (strlen($number) == 10 && substr($number, 0, 1) == '0') {
	$number = "94" . ltrim($number, "0");
    } elseif (strlen($number) == 12 && substr($number, 0, 3) == '940') {
	$number = "94" . ltrim($number, "940");
    }
    return $number;
}

/*
 *
 * Ninja Forms Custom Field
 *
 */

function notifyNinjaTemplatePaths($paths) {
    $paths[] = plugin_dir_path(__FILE__) . "includes/templates/";
    return $paths;
}

add_filter('ninja_forms_field_template_file_paths', 'notifyNinjaTemplatePaths');



add_filter('ninja_forms_register_fields', function($fields) {
    $fields['notify_ninja_phone'] = new NotifyNinjaPhoneField;
    return $fields;
});

add_action('wp_enqueue_scripts', 'theme_enqueue_styles');

function theme_enqueue_styles() {
    wp_enqueue_style('intlTelInput', plugins_url('includes/css/intlTelInput.css', __FILE__));
    wp_enqueue_style('notify-ninja', plugins_url('includes/css/main.css', __FILE__));

    wp_enqueue_script('intlTelInput', plugins_url('includes/js/intlTelInput.min.js', __FILE__), array('jquery'), FALSE, TRUE);
    wp_enqueue_script('notify-ninja', plugins_url('includes/js/main.js', __FILE__), array('jquery', 'intlTelInput', 'nf-front-end'), FALSE, TRUE);
}

/*
 * 
 * Action Registration
 * 
 */

add_filter('ninja_forms_register_actions', function($actions) {
    $actions['notifylk'] = new NF_Actions_Notifylk();
    return $actions;
});

