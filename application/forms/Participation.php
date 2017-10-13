<?php

class Application_Form_Participation extends Zend_Form
{

    public function init()
    {
        // Set the method for the display form to POST
        $this->setMethod('post');


        // Add some CSRF protection
        $this->addElement('hash', 'csrf', array(
            'salt' => Zend_Registry::get('configs')->FORM_SALT,
        ));
    }


}

