<?php

class AddTaskForm extends Zend_Form
{
	public function __construct($options = null)
    {
        parent::__construct($options);

        $feature		= new Zend_Form_Element_Text('feature');
        $tmid			= new Zend_Form_Element_Text('tmid');
        $task			= new Zend_Form_Element_Text('task');
        $priority		= new Zend_Form_Element_Text('priority');
        $origEst		= new Zend_Form_Element_Text('origEst');
		$addTaskSubmit	= new Zend_Form_Element_Submit('addTaskSubmit');
		$addTaskCancel	= new Zend_Form_Element_Submit('addTaskCancel');

		$feature->setLabel('Feature:');
		$tmid->setLabel('Matrix ID:');
		$task->setLabel('Task:');
		$priority->setLabel('Priority:');
		$origEst->setLabel('Estimate:');
		$addTaskSubmit->setLabel('Save Task');
		$addTaskCancel->setLabel('Cancel');

		$this->addElements(array(
			$feature, $tmid, $task, $priority, $origEst, $addTaskSubmit,
			$addTaskCancel,
		));
    }
}

?>