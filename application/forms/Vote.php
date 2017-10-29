<?php

class Application_Form_Vote extends Zend_Form
{

    public function init()
    {
        // Set the method for the display form to POST
        $this->setMethod('post');


        // Add an email element
        $this->addElement('text', 'vote', array(
            'label'      => 'Vote',
            'required'   => true,
            'validators' => array ( 
                array('Digits'),    
                array('Between', false, array('min' => 1, 'max' => 5))
            )
        ));

        // Add an email element
        $this->addElement('text', 'comment', array(
            'label'      => 'Comment',
            'required'   => true,
            'filters'    => array('StringTrim', 'StripTags'),
        ));

        // Add an email element
        $this->addElement('text', 'grouporder', array(
            'label'      => 'Order',
            'required'   => true,
            'validators' => array ( 
                array('name' => 'Digits'),
            )
        ));
    }


}