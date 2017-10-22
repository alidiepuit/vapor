<?php

class Application_Form_Location extends Zend_Form
{

    public function init()
    {
        // Set the method for the display form to POST
        $this->setMethod('post');


        // Add an email element
        $this->addElement('text', 'full_address', array(
            'label'      => 'address',
            'required'   => true,
            'filters'    => array('StringTrim', 'StripTags'),
            
        ));
    }


}