<?php
class Exception_Authen extends Exception
{   
    const EXCEPTION_AUTHEN_UNKNOWN = array('code' => 0, 'message' => 'Something is wrong.');
    const EXCEPTION_AUTHEN_EXISTED_USER = array('code' => 100, 'message' => 'Email is existed.');
    const EXCEPTION_AUTHEN_NOT_MATCH_PASSWORD = array('code' => 101, 'message' => 'Not match password.');
    const EXCEPTION_AUTHEN_USERNAME = array('code' => 102, 'message' => 'Email is not valid.');
    const EXCEPTION_AUTHEN_PASSWORD = array('code' => 103, 'message' => 'Password is not valid.');
    const EXCEPTION_AUTHEN_EMAIL_SOCIAL = array('code' => 104, 'message' => 'This email is used by authenticating social.');
    const EXCEPTION_AUTHEN_WRONG_EMAIL_PASSWORD = array('code' => 105, 'message' => 'Email or password is wrong.');


    const EXCEPTION_POST_WRONG_ID = array('code' => 200, 'message' => 'Wrong ID post.');

    // Redefine the exception so message isn't optional
    public function __construct($exception = EXCEPTION_AUTHEN_UNKNOWN, Exception $previous = null) {
        parent::__construct($exception['message'], $exception['code'], $previous);
    }

    // custom string representation of object
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

    public function customFunction() {
        echo "A custom function for this type of exception\n";
    }
}