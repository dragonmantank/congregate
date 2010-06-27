<?php

class Project_Form_CreateBug extends Zend_Form
{
    public function init()
    {
        $title = new Zend_Form_Element_Text('title');
        $description = new Zend_Form_Element_TextArea('description');
        $reproduction = new Zend_Form_Element_TextArea('reproduction');
        $additionalInfo = new Zend_Form_Element_TextArea('additionalInfo');
        $submit = new Zend_Form_Element_Submit('submit');

        $title->setLabel('Title:')
              ->setRequired(true);

        $description->setLabel('Description:')
                    ->setRequired(true);

        $reproduction->setLabel('Steps to Reproduce:');

        $additionalInfo->setLabel('Any Additional Info:');

        $submit->setLabel('Submit');

        $this->addElements(array(
            $title, $description, $reproduction, $additionalInfo, $submit
        ));
    }
}