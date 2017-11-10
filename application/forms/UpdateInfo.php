<?php

class Application_Form_UpdateInfo extends Zend_Form
{

    public function init()
    {
        // Set the method for the display form to POST
        $this->setMethod('post');

        // Add an email element
        $this->addElement('text', 'email', array(
            'label'      => 'email',
            'required'   => false,
            'filters'    => array('StringTrim', 'StripTags'),
            'attribs'    => array('readonly' => 'true')
        ));

        // Add an display name element
        $this->addElement('text', 'display_name', array(
            'label'      => 'display_name',
            'required'   => true,
            'filters'    => array('StringTrim', 'StripTags'),
        ));

        // Add an phone number element
        $this->addElement('text', 'phone_number', array(
            'label'      => 'phone_number',
            'required'   => true,
            'filters'    => array('StringTrim', 'StripTags'),
            'validators'  => array('NotEmpty', 'Digits'),
        ));

        // Add some CSRF protection
        $this->addElement('hash', 'csrf_update_info', array(
            'salt' => Zend_Registry::get('configs')->FORM_SALT,
        ));
    }


}

