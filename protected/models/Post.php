<?php

class Post extends EMongoDocument
{
	public $title;
	public $content;
	public $location = array(0, 0);
	public $createTime;
	public $authorId;
	
	public function getCollectionName()
	{
		return 'posts';
	}
	
	public function rules()
	{
		return array(
			array('title, content', 'required'),
			array('location', 'safe'),
		);
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function setAttributes($values, $safeOnly=true)
	{
		parent::setAttributes($values, $safeOnly);
		if (isset($values['longitude']))
			$this->longitude = $values['longitude'];
		if (isset($values['latitude']))
			$this->latitude = $values['latitude'];
	}
	
	public function setLatitude($latitude)
	{
		echo 'test';
		$this->location[1] = floatval($latitude);
	}
	
	public function setLongitude($longitude)
	{
		$this->location[0] = floatval($longitude);
	}
	
	public function getLongitude()
	{
		return $this->location[0];
	}
	
	public function getLatitude()
	{
		return $this->location[1];
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