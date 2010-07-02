<?php

class Project_Form_UploadFile extends Zend_Form
{
    public function init()
    {
        $title = new Zend_Form_Element_Text('title');
        $file = new Zend_Form_Element_File('file');
        $submit = new Zend_Form_Element_Submit('submit');

        $title->setLabel('Title:')
              ->setRequired();

        $file->setLabel('File to Upload:');

        $submit->setLabel('Upload File');
        
        $this->addElements(array(
            $title, $file, $submit,
        ));
    }
}