<?php

class Users extends Zend_Db_Table_Abstract
{
	protected $_name	= 'u_Users';

	public function autoCreate($name, $email) {
		$data	= array(
			'username'		=> $email,
			'password'		=> md5(time()),
			'name'			=> $name,
			'email'			=> $email,
			'primaryGroup'	=> 1,
			'status'		=> -1,
			'challenge'		=> substr(md5(time()), 0, 10),
		);

		$this->insert($data);
		$uid	= $this->getAdapter()->lastInsertId();

		$this->sendRegistration($data['email'], $data['name'], $data['challenge']);

		return $uid;
	}

	public function sendRegistration($email, $name, $challenge)
	{
		$mail	= new Zend_Mail();
		$mail->setBodyText("<< This message is automatically generated >>\n\nYou have been added added as a Team Member in BPM. Please visit the website and click on 'Register New User' and use the following invite code:\n\n$challenge");
		$mail->setFrom('noreply@domain.com', 'BPM Registration');
		$mail->addto($email, $name);
		$mail->setSubject('BPM Registration');

		$mail->send();
	}
}