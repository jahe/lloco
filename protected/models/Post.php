<?php

class Post extends EMongoDocument
{
    public $_id;
    public $authorId;
    public $title;
    public $content;
    public $location = array(0, 0);
    public $tags;
    public $createTime;
    public $category;

    // This has to be defined in every model, this is same as with standard Yii ActiveRecord
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    // This method is required!
    public function getCollectionName()
    {
        return 'posts';
    }

    public function rules()
    {
        return array(
          array('authorId, title, content', 'required'),
          array('location', 'safe'),
          );
    }

    public function attributeLabels()
    {
        return array(
          'title'   => 'Titel',
          'content'   => 'Inhalt',
          );
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

    public function getPostData($post_id)
    {
        $post_id = new MongoId($post_id);

        $db = Yii::app()->edmsMongoDB();
        $col = $db->posts;

        $post = $col->findOne(['_id' => $post_id]);
        return $post;
    }

    public static function getPostsByBox($ne, $sw)
    {
        //$criteria = ['location' => ['$within' => ['$box' => [[54.76613674052899, 9.543170928955076], [54.800585917712816, 9.323616027832031]]]]];
        //$criteria = ['location' => ['$geoWithin' => ['$box' => [[$sw[0], $sw[1]], [$nw[0], $nw[1]]]]]];
        //$criteria = ['title' => 'A210'];
        //return EDMSQuery::instance('posts')->find($criteria);

        $db = Yii::app()->edmsMongoDB();
        $col = $db->posts;
        $result = $col->find(['location' => ['$within' => ['$box' => [[$sw[0], $sw[1]], [$ne[0], $ne[1]]]]]], ['location' => true, 'category' => true]);
        return iterator_to_array($result, false);
    }

    public static function getPostsByProximity($longitude, $latitude)
    {
        $db = Yii::app()->edmsMongoDB();

        $result = $db->command(
          array(
            'geoNear' => 'posts',
            'near' => array(floatval($longitude), floatval($latitude)),
            'spherical' => true,
            'distanceMultiplier' => 6371,
            'query' => array(
              'title' => 'hulu'
              )
            )
          );

        return $result;
    }

    public function nearPosts()
    {
        $criteria = new EMongoCriteria;
        $criteria->addCond('location', 'nearSphere', $this->location);
        //$criteria->addCond('location', 'maxDistance', (float) 5 / 111.12);  // 5 km radius
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

    public function getAllPosts()
    {
        $posts = Post::model()->findAll();
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