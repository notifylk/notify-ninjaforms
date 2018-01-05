<?php

class NotifyNinjaPhoneField extends NF_Abstracts_Input {

    protected $_name = 'notify_ninja_phone';
    protected $_type = 'notify_phone';
    protected $_nicename = 'Phone Number - Notify.Lk';
    protected $_section = 'userinfo';
    protected $_icon = 'phone';
    protected $_templates = array('notify_phone');
    protected $_test_value = '94777123456';

    public function __construct() {
	parent::__construct();
	$this->_nicename = __('Phone Number - Notify.Lk', 'ninja-forms');
    }

    public function validate($field, $data) {
	$errors = array();
	// Required check.

	$reformatted = notifyReformatPhoneNumbers($field['value']);

	if (strlen($reformatted) !== 11)
	    $errors[] = 'Please enter a correct phone number.';

	if (isset($field['required']) && 1 == $field['required'] && is_null(trim($field['value']))) {
	    $errors[] = 'Field is required.';
	}
	return $errors;
    }

}
