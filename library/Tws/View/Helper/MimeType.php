<?php

class Tws_View_Helper_MimeType
{
	public function MimeType($mimetype)
	{
		switch($mimetype) {
			case 'application/octet-stream':
				$human	= 'Executable Program';
				break;
			case 'application/x-javascript':
				$human	= 'JavaScript File';
				break;
			case 'application/zip':
				$human	= 'Zip File';
				break;
			case 'image/bmp':
				$human	= 'Bitmap Image';
				break;
			default:
				$human	= $mimetype;
				break;
		}

		return $human;
	}
}