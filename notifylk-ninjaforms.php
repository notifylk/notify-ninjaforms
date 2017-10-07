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


/*
 * 
 * Ninja forms submission hook
 * 
 */

function notify_ninja_after_submission($form_data) {

    $settings = array(
	'phone_number_field' => get_option('notify_ninja_key_phone'),
	'message' => get_option('notify_ninja_message'),
	'user_id' => get_option('notify_ninja_userid'),
	'api_key' => get_option('notify_ninja_apikey'),
	'sender_id' => get_option('notify_ninja_senderid'),
    );


    preg_match_all("/\[(.+?)\]/", $settings['message'], $shortcodes);
    $shortcodes_to_replace = $shortcodes[0];
    $form_fields = array();

    foreach ($form_data['fields'] as $field) { // Field settigns, including the field key and value.
	$form_fields[$field['key']] = $field['value']; // Update the submitted field value.
    }

    $values_to_replace = array();
    foreach ($shortcodes[1] as $key) {
	array_push($values_to_replace, $form_fields[$key]);
    }

    $message = str_replace($shortcodes_to_replace, $values_to_replace, $settings['message']);
    $phone_num = $form_fields[$settings['phone_number_field']];
    $phone_num = notifyReformatPhoneNumbers($phone_num);

    $apiInt = new \NotifyLk\Api\SmsApi();
    $apiInt->sendSMS($settings['user_id'], $settings['api_key'], $message, $phone_num, $settings['sender_id']);
}

add_action('ninja_forms_after_submission', 'notify_ninja_after_submission');

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
