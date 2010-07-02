<?php

class Project_Form_CreateConversation extends Zend_Form
{
    public function init()
    {
        $title = new Zend_Form_Element_Text('title');
        $remark = new Zend_Form_Element_TextArea('remark');
        $submit = new Zend_Form_Element_Submit('submit');

        $title->setLabel('Conversation Title:')
              ->setRequired();

        $remark->setLabel('Remark:')
               ->setRequired()
               ->setAttrib('class', 'elastic');

        $submit->setLabel('Create Conversation');

        $this->addElements(array(
            $title, $remark, $submit,
        ));
    }
}