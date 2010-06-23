<?php

class Files extends Zend_Db_Table_Abstract
{
	protected $_name	= 'f_Files';

	public function add(array $fileData)
	{
		$p			= new Projects();
		$fd			= new FilesDetail();
		$slug		= $p->fetchSlug($fileData['projectId']);
		$extPos		= strrpos($fileData['filename'], '.');
		$ext		= substr($fileData['filename'], $extPos);
		$fileName	= substr($fileData['filename'], 0, $extPos);
		$fsFilename	= $fileName . '_1' . $ext;

		if(is_uploaded_file($fileData['tmp_name'])) {
			$directory	= INSTALL_PATH . '/data/' . $slug;
			if(!is_dir($directory)) {
				mkdir($directory);
			}

			if(move_uploaded_file($fileData['tmp_name'], $directory . '/'. $fsFilename)) {
				$header['projectId']		= $fileData['projectId'];
				$header['section']			= $fileData['section'];
				$header['filename']	 		= $fileData['filename'];
				$header['directory']		= $slug;
				$header['originalAuthor']	= $fileData['author'];
				$header['title']			= $fileData['title'];
				$header['revision']		 	= 1;

				$headerId	= $this->insert($header);

				$detail['fileId']		= $headerId;
				$detail['fsFilename']	= $fsFilename;
				$detail['mimetype']		= $fileData['mimetype'];
				$detail['size']			= $fileData['size'];
				$detail['author']		= $fileData['author'];

				$detailId	= $fd->insert($detail);

				$this->update(array('detailId' => $detailId), 'id = ' . $headerId);

				return true;
			}
		}

	}

	public function addRevision($data)
	{
		$fileDetails	= new FilesDetail();
		$file			= $this->fetchFile($data['fileId']);
		$slug			= $file->directory;
		$extPos			= strrpos($data['fileName'], '.');
		$ext			= substr($data['fileName'], $extPos);
		$fileName		= substr($data['fileName'], 0, $extPos);
		$fsFilename		= $fileName . '_' . ($file->revision + 1) . $ext;

		if(is_uploaded_file($data['tmp_name'])) {
			$directory	= INSTALL_PATH . '/data/' . $slug;
			if(!is_dir($directory)) {
				mkdir($directory);
			}

			if(move_uploaded_file($data['tmp_name'], $directory . '/'. $fsFilename)) {
				$detail['fileId']		= $data['fileId'];
				$detail['fsFilename']	= $fsFilename;
				$detail['mimetype']		= $data['mimetype'];
				$detail['size']			= $data['size'];
				$detail['author']		= $data['author'];

				$detailId	= $fileDetails->insert($detail);

				$this->update(array('detailId' => $detailId, 'revision' => ($file->revision +1)), 'id = ' . $data['fileId']);

				return true;
			}
		}
	}

	public function addComment($fid, $author, $comment)
	{
		$file	= $this->fetchFile($fid);
		$fc		= new FilesComments();

		$data['fileId']		= $file->id;
		$data['revision']	= $file->revision;
		$data['author']		= $author;
		$data['comment']	= $comment;

		$fc->insert($data);
	}

	public function fetchAllVersions($fid)
	{
		$select	= $this->select()->from(array('f' => $this->_name))
								 ->join(array('fd' => 'fd_FilesDetail'), 'f.id = fd.fileId', array('detailId' => 'id', 'fileId', 'fsFilename', 'mimetype', 'size', 'dateAdded', 'author'))
								 ->join(array('u' => 'u_Users'), 'fd.author = u.id', array('name', 'email'))
								 ->where('f.id = ?', $fid)
								 ->order('fd.dateAdded DESC')
								 ->setIntegrityCheck(false);

		return $this->fetchAll($select);
	}

	public function fetchComments($fid)
	{
		$fc	= new FilesComments();

		return $fc->fetchCommentsByFile($fid);
	}

	public function fetchCurrentRevision($pid)
	{
		$select	= $this->select()->from($this, 'revision')
								 ->where('id = ?', $pid);

		$row	= $this->fetchRow($select);
		return $row->revision;
	}

	public function fetchFile($fid)
	{
		$select	= $this->select()->from(array('f' => $this->_name))
								 ->join(array('fd' => 'fd_FilesDetail'), 'fd.id = f.detailId', array('detailId' => 'id', 'fileId', 'fsFilename', 'mimetype', 'size', 'dateAdded', 'author'))
								 ->join(array('u' => 'u_Users'), 'fd.author = u.id', array('name', 'email'))
								 ->where('f.id = ?', $fid)
								 ->order('fd.dateAdded DESC')
								 ->setIntegrityCheck(false);

		return $this->fetchRow($select);
	}

	public function fetchFilesByProject($pid)
	{
		$select	= $this->select()->from(array('f' => $this->_name))
								 ->join(array('fd' => 'fd_FilesDetail'), 'fd.id = f.detailId', array('detailId' => 'id', 'fileId', 'fsFilename', 'mimetype', 'size', 'dateAdded', 'author'))
								 ->join(array('u' => 'u_Users'), 'fd.author = u.id', array('name', 'email'))
								 ->where('f.projectId = ?', $pid)
								 ->setIntegrityCheck(false);

		return $this->fetchAll($select);
	}

	public function fetchProjectId($fid)
	{
		$select	= $this->select()->from($this, 'projectId')
								 ->where('id = ?', $fid);

		$row	= $this->fetchRow($select);
		return $row->projectId;
	}

	public function viewFile($detailId, $type = 'browser')
	{
		$select	= $this->select()->from(array('fd' => 'fd_FilesDetail'), array('detailId' => 'id', 'fileId', 'fsFilename', 'mimetype', 'size', 'dateAdded', 'author'))
								 ->join(array('f' => 'f_Files'), 'fd.fileId = f.id')
								 ->join(array('u' => 'u_Users'), 'fd.author = u.id', array('name', 'email'))
								 ->where('fd.id = ?', $detailId)
								 ->order('fd.dateAdded DESC')
								 ->setIntegrityCheck(false);

		$file		= $this->fetchRow($select);
		$fullPath	= INSTALL_PATH . '/data/' .$file->directory . '/' . $file->fsFilename;
		$disposition	= ($type == 'browser' ? 'inline' : 'attachment');

		header("Pragma: public");
	    header("Expires: 0");
	    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	    header("Cache-Control: private", false);
	    header("Content-Type: ".$file->mimetype);
	    header("Content-Disposition: " . $disposition . "; filename=\"".$file->filename."\";");
	    header("Content-Transfer-Encoding: binary");
	    header("Content-Length: ".filesize($fullPath));
	    readfile($fullPath);
	    die();
	}
}