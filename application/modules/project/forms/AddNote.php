<?php

class Project_Form_AddNote extends Zend_Form
{
    public function init()
    {
        $note = new Zend_Form_Element_TextArea('note');
        $submit = new Zend_Form_Element_Submit('submit');

        $note->setLabel('Note:')
             ->setRequired(true)
             ->setAttrib('class', 'elastic');

        $submit->setLabel('Add Note');

        $this->addElements(array(
            $note, $submit,
        ));
    }
}