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

                $upload->addFilter('Rename', APPLICATION_PATH.'/../data/documents/'.$file->FileDetail->fsFilename);
                if($upload->receive()) {
                    $file->save();
                    $file->FileDetail->file_id = $file->id;
                    $file->FileDetail->save();

                    Model_Message::addMessage(
                        Zend_Auth::getInstance()->getIdentity()->name.' uploaded a new File, '.$file->title,
                        'project/filess/view/file/'.$file->id,
                        Zend_Auth::getInstance()->getIdentity(),
                        $_SESSION['CurrentProject']['project']);

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