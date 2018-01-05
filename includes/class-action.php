<?php

class NF_Actions_Notifylk extends NF_Abstracts_Action {

    /**
     * @var string
     */
    protected $_name = 'notifylk';

    /**
     * @var array
     */
    protected $_tags = array();

    /**
     * @var string
     */
    protected $_timing = 'late';

    /**
     * @var int
     */
    protected $_priority = '-2';

    /**
     * Constructor
     */
    public function __construct() {
	parent::__construct();

	$this->_nicename = __('Notify.LK Contact Submission', 'ninja-forms');

	$settings = array(
	    'phone_num' => array(
		'name' => 'phone_num',
		'type' => 'textbox',
		'group' => 'primary',
		'label' => __('Phone Number', 'ninja-forms'),
		'placeholder' => __('Number or field', 'ninja-forms'),
		'value' => '',
		'width' => 'one-half',
		'use_merge_tags' => TRUE,
	    ),
	    'group_id' => array(
		'name' => 'group_id',
		'type' => 'textbox',
		'group' => 'primary',
		'label' => __('Notify.LK Group ID', 'ninja-forms'),
		'placeholder' => __('Group ID', 'ninja-forms'),
		'value' => '',
		'width' => 'one-half',
		'help' => 'Specify a Notify.LK group ID if you need to save the contact to a specific contact group.'
	    ),
	    'first_name' => array(
		'name' => 'first_name',
		'type' => 'textbox',
		'group' => 'primary',
		'label' => __('First Name', 'ninja-forms'),
		'placeholder' => __('First name or field', 'ninja-forms'),
		'value' => '',
		'width' => 'one-third',
		'use_merge_tags' => TRUE,
	    ),
	    'last_name' => array(
		'name' => 'last_name',
		'type' => 'textbox',
		'group' => 'primary',
		'label' => __('Last Name', 'ninja-forms'),
		'placeholder' => __('Last name or field', 'ninja-forms'),
		'value' => '',
		'width' => 'one-third',
		'use_merge_tags' => TRUE,
	    ),
	    'email_addr' => array(
		'name' => 'email_addr',
		'type' => 'textbox',
		'group' => 'primary',
		'label' => __('Email Address', 'ninja-forms'),
		'placeholder' => __('Email Address or field', 'ninja-forms'),
		'value' => '',
		'width' => 'one-third',
		'use_merge_tags' => TRUE,
	    ),
	    'message' => array(
		'name' => 'message',
		'type' => 'textarea',
		'group' => 'primary',
		'label' => __('Message', 'ninja-forms'),
		'placeholder' => __('Message', 'ninja-forms'),
		'value' => '',
		'width' => 'full',
		'use_merge_tags' => TRUE,
	    ),
	);
	$this->_settings = array_merge($this->_settings, $settings);
    }

    /*
     * PUBLIC METHODS
     */

    public function save($action_settings) {
	
    }

    public function process($action_settings, $form_id, $data) {
	$settings = array(
	    'user_id' => get_option('notify_ninja_userid'),
	    'api_key' => get_option('notify_ninja_apikey'),
	    'sender_id' => get_option('notify_ninja_senderid')
	);

	$phone_num = $action_settings['phone_num'];
	$message = $action_settings['message'];

	if (empty($phone_num) || empty($message))
	    return;

	$phone_num = notifyReformatPhoneNumbers($phone_num);
	$fname = $action_settings['first_name'];
	$lname = $action_settings['last_name'];
	$contact_group = $action_settings['group_id'];

	$apiInt = new \NotifyLk\Api\SmsApi();
	try {
	    $apiInt->sendSMS($settings['user_id'], $settings['api_key'], $message, $phone_num, $settings['sender_id'], $fname, $lname, null, null, $contact_group);
	} catch (Exception $e) {
	    
	}
	return $data;
    }

}
