<?php

class Project_Form_ProjectSettings extends Zend_Form
{
    public function init()
    {
        $name = new Zend_Form_Element_Text('name');
        $description = new Zend_Form_Element_TextArea('description');
        $submit = new Zend_Form_Element_Submit('submit');

        $name->setLabel('Project Name:')
             ->setRequired();

        $description->setLabel('Project Description:')
                    ->setRequired();

        $submit->setLabel('Save Settings');

        $this->addElements(array(
            $name, $description, $submit,
        ));
    }
}