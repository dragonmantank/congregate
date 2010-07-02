<?php

class Project_Form_CreateIssue extends Zend_Form
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
                    ->setRequired(true)
                    ->setAttrib('class', 'elastic');

        $reproduction->setLabel('Steps to Reproduce:')
                     ->setAttrib('class', 'elastic');

        $additionalInfo->setLabel('Any Additional Info:')
                       ->setAttrib('class', 'elastic');

        $submit->setLabel('Submit');

        $this->addElements(array(
            $title, $description, $reproduction, $additionalInfo, $submit
        ));
    }
}