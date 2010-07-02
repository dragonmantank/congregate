<?php

class Project_Form_CreateConversationPost extends Zend_Form
{
    public function init()
    {
        $remark = new Zend_Form_Element_TextArea('remark');
        $submit = new Zend_Form_Element_Submit('submit');

        $remark->setLabel('Remark:')
               ->setAttrib('class', 'elastic')
               ->setRequired();

        $submit->setLabel('Add Remark');

        $this->addElements(array(
            $remark, $submit,
        ));
    }
}