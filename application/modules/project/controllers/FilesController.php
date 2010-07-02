<?php

class Project_FilesController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $files = Doctrine_Core::getTable('Model_File')->findAll();

        $this->view->files = $files;
    }

    public function uploadAction()
    {
        $form = new Project_Form_UploadFile();

        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getPost())) {
                $file = new Model_File();

                $upload = new Zend_File_Transfer_Adapter_Http();
                $fileInfo = $upload->getFileInfo();

//                $detail->filename = $fileInfo['file']['name'];
//                $detail->fsFilename = sha1(rand().time().$detail->filename);
//                $detail->mimetype = $fileInfo['file']['type'];
//                $detail->size = $fileInfo['file']['size'];
//                $detail->dateAdded = date('Y-m-d H:i:s');
//                $detail->author_id = Zend_Auth::getInstance()->getIdentity();

                $file->FileDetail->filename = $fileInfo['file']['name'];
                $file->FileDetail->fsFilename = sha1(rand().time().$file->FileDetail->filename);
                $file->FileDetail->mimetype = $fileInfo['file']['type'];
                $file->FileDetail->size = $fileInfo['file']['size'];
                $file->FileDetail->dateAdded = date('Y-m-d H:i:s');
                $file->FileDetail->author_id = Zend_Auth::getInstance()->getIdentity();

                $file->directory = realpath(APPLICATION_PATH.'/../data/documents/');
                $file->author_id = Zend_Auth::getInstance()->getIdentity();
                $file->revision = 1;
                $file->title = $form->getValue('title');
                //$file->fileDetail_id = $file->FileDetail;

                $upload->addFilter('Rename', APPLICATION_PATH.'/../data/documents/'.$file->FileDetail->fsFilename);
                if($upload->receive()) {
                    $file->save();
                    $file->FileDetail->file_id = $file->id;
                    $file->FileDetail->save();
                    $this->_redirect('project/files');
                } else {
                    echo 'We blew up.';
                    Zend_Debug::dump($upload->getErrors());
                }
            }
        }

        $this->view->form = $form;
    }
}