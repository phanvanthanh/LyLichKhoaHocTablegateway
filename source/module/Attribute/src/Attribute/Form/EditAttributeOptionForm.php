<?php
namespace Attribute\Form;

use Zend\Form\Form;
use Attribute\Form\EditAttributeOptionFormFilter;

class EditAttributeOptionForm extends Form
{

    public function __construct($serviceLocator)
    {
        parent::__construct("edit_attribute_option_form");
        $this->setAttribute('method', 'post'); 

        $this->add(array(
            'name' => 'attribute_id',
            'type' => 'Zend\Form\Element\Hidden', 
            'attributes' => array(
                'id'    => 'attribute-id',
            ),            
        ));

        $this->setInputFilter(new EditAttributeOptionFormFilter());
        
    }
}