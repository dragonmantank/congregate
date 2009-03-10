<?php

class Tws_View_Helper_BaseUrl
{
	public function BaseUrl($file = null)
	{
		return Zend_Controller_Front::getInstance()->getRequest()->getBaseUrl()
                . ($file ? ('/' . trim((string) $file, '/\\')) : '');
	}
}