<?php

class Post extends EMongoDocument
{
	public $_id;
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
	
	/*
	 * Returns the shortest distance in kilometers between two points.
	 */
	public static function distance($lon1, $lat1, $lon2, $lat2)
	{
		$earthRadius = 6371;
		
		$degLon = deg2rad($lon2 - $lon1);
		$degLat = deg2rad($lat2 - $lat1);
		
		$x = sin($degLat / 2) * sin($degLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($degLon / 2) * sin($degLon / 2);
		$distance = 2 * $earthRadius * asin(sqrt($x));
		
		return $distance;
	}
	
	public function nearPosts()
	{
		
		$criteria = new EMongoCriteria;
		$criteria->addCond('location', 'nearSphere', $this->location);
		//$criteria->addCond('location', 'maxDistance', (float) 5 / 111.12);	// 5 km radius
		//$criteria->sort('location', EMongoCriteria::SORT_ASC);
		$posts = Post::model()->findAll($criteria);
		return $posts;
		
		/*
		$query = array(
			'conditions' => array(
				'location' => array(
					'near' => array($this->location[0], $this->location[1]),
				),
			)
		);
		$criteria = new EMongoCriteria($query);
		return Post::model()->findAll($criteria);
		*/
	}
	
	public function comments()
	{
		$criteria = new EMongoCriteria;
		$criteria->postId = new MongoId($this->_id);
		$criteria->sort('createTime', EMongoCriteria::SORT_DESC);
		return Comment::model()->findAll($criteria);
	}
	
	public function commentCount()
	{
		$criteria = new EMongoCriteria;
		$criteria->postId = new MongoId($this->_id);
		return Comment::model()->count($criteria);
	}
	
	public function addComment($comment)
	{
		$comment->postId = new MongoId($this->_id);
		return $comment->save();
	}
	
	public function deleteComments()
	{
		$criteria = new EMongoCriteria;
		$criteria->postId = new MongoId($this->_id);
		Comment::model()->deleteAll($criteria);
	}
}

?>