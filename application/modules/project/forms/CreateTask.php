<?php

class Project_Form_CreateTask extends Zend_Form
{
    public function init()
    {
        $title = new Zend_Form_Element_Text('title');
        $description = new Zend_Form_Element_Textarea('description');
        $deadline = new Zend_Form_Element_Text('deadline');
        $submit = new Zend_Form_Element_Submit('submit');

        $title->setLabel('Title:')
              ->setRequired(true);

        $description->setLabel('Task Description:')
                    ->setRequired(true);

        $deadline->setLabel('Deadline:')
                 ->setRequired(true);

        $submit->setLabel('Create Task');

        $this->addElements(array(
            $title, $description, $deadline, $submit,
        ));
    }
}