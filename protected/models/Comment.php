<?php

class Comment extends EMongoDocument
{
	public $_id;
	public $title;
	public $content;
	public $createTime;
	public $authorId;
	public $postId;
	
	public function getCollectionName()
	{
		return 'comments';
	}
	
	public function rules()
	{
		return array(
			array('title, content', 'required'),
		);
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	protected function beforeSave()
	{
		if (parent::beforeSave())
		{
			if ($this->isNewRecord)
			{
				$this->createTime = time();
				$this->authorId = Yii::app()->user->id;
			}
			
			return true;
		}
		else
			return false;
	}
}

?>