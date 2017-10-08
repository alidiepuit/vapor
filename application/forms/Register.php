<?php

class Application_Form_Register extends Zend_Form
{

    public function init()
    {
        // Set the method for the display form to POST
        $this->setMethod('post');


        // Add an email element
        $this->addElement('text', 'user_name', array(
            'label'      => 'email',
            'required'   => true,
            'filters'    => array('StringTrim', 'StripTags'),
            'validators' => array(
                'EmailAddress',
            )
        ));

        // Add an password element
        $this->addElement('text', 'user_password', array(
            'label'      => 'password',
            'required'   => true,
            'filters'    => array('StringTrim', 'StripTags'),
        ));

        // Add an repeat password element
        $confirmPassword=new Zend_Form_Element_Password('confirm_password');
        $confirmPassword->setLabel('Confirm password')
            ->setRequired('true')
            ->addFilter(new Zend_Filter_StringTrim())
            ->addValidator(new Zend_Validate_Identical('user_password'));
        $this->addElement($confirmPassword);

        // Add an display name element
        $this->addElement('text', 'user_display_name', array(
            'label'      => 'display name',
            'required'   => true,
            'filters'    => array('StringTrim', 'StripTags'),
        ));

        // Add an repeat password element
        $this->addElement('text', 'user_phone', array(
            'label'      => 'phone',
            'required'   => true,
            'filters'    => array('StringTrim', 'StripTags'),
        ));

        // Add some CSRF protection
        $this->addElement('hash', 'csrf', array(
            'salt' => Zend_Registry::get('configs')->FORM_SALT,
        ));
    }


}

