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
								 ->join(array('fd' => 'fd_FilesDetail'), 'fd.id = f.detailId')
								 ->join(array('u' => 'u_Users'), 'fd.author = u.id', array('name', 'email'))
								 ->where('f.id = ?', $fid)
								 ->setIntegrityCheck(false);

		return $this->fetchRow($select);
	}

	public function fetchFilesByProject($pid)
	{
		$select	= $this->select()->from(array('f' => $this->_name))
								 ->join(array('fd' => 'fd_FilesDetail'), 'fd.id = f.detailId')
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
}