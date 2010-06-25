<?php

class Project_Form_Add extends Zend_Form
{
    public function init()
    {
        $name = new Zend_Form_Element_Text('name');
        $description = new Zend_Form_Element_Textarea('description');
        $submit = new Zend_Form_Element_Submit('submit');

        $name->setLabel('Project Name:')
             ->setRequired(true);

        $description->setLabel('Description:')
                    ->setRequired(true);

        $submit->setLabel('Create Project');

        $this->addElements(array(
            $name, $description, $submit
        ));
    }
}