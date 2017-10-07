<?php

class Application_Form_Signin extends Zend_Form
{

    public function init()
    {
        // Set the method for the display form to POST
        $this->setMethod('post');


        // Add an email element
        $this->addElement('text', 'user_name', array(
            'label'      => 'email',
            'required'   => true,
            'filters'    => array('StringTrim'),
            'validators' => array(
                'EmailAddress',
            )
        ));

        // Add an password element
        $this->addElement('text', 'user_password', array(
            'label'      => 'password',
            'required'   => true,
        ));

        // Add some CSRF protection
        $this->addElement('hash', 'csrf', array(
            'salt' => Zend_Registry::get('configs')->FORM_SALT,
        ));
    }


}

