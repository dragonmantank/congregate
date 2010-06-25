<?php

class Admin_Form_AddUser extends Zend_Form
{
    public function init()
    {
        $email = new Zend_Form_Element_Text('email');
        $name = new Zend_Form_Element_Text('name');
        $password = new Zend_Form_Element_Text('password');
        $submit = new Zend_Form_Element_Submit('submit');

        $email->setLabel('Email Address:')
              ->addValidators(array('EmailAddress'))
              ->setRequired(true);

        $name->setLabel('Name:')
              ->setRequired(true);

        $password->setLabel('Initial Password:')
                 ->setRequired(true);

        $submit->setLabel('Add New User');

        $this->addElements(array(
            $email, $name, $password, $submit,
        ));
    }
}