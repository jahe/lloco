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
        $postsCol = $db->posts;
        $usersCol = $db->users;

        $post = $postsCol->findOne(['_id' => $post_id]);

        $post['author'] = $usersCol->findOne(['_id' => new MongoId($post['authorId'])])['username'];
        if (!Yii::app()->user->isGuest)
            $post['likestate'] = $this->getLikeDislikeState($post['_id']->__toString(), Yii::app()->user->id);
        //$postdata['imgIds'] = $post['images'];  // Array aus ObjektIds der im GridFS gespeicherten Bilder
        if (isset($post['comments']) && (count($post['comments']) > 0))
            for ($i = 0; $i < count($post['comments']); $i++)
                $post['comments'][$i]['author'] = $usersCol->findOne(['_id' => new MongoId($post['comments'][$i]['authorId'])])['username'];

        return $post;
    }

    public function deletePost($postid)
    {
        $db = Yii::app()->edmsMongoDB();
        $postsCol = $db->posts;

        $authorId = $postsCol->findOne(['_id' => new MongoId($postid)])['authorId']->__toString();

        // Ist der Löschende auch der Author des Posts?
        if ($authorId === Yii::app()->user->id->__toString())
            $result = $postsCol->remove(['_id' => new MongoId($postid)]);
        else
            $result = false;

        return $result;
    }

    public function getLikeStats($postid)
    {
        $db = Yii::app()->edmsMongoDB();
        $postsCol = $db->posts;

        $result['likes'] = count($postsCol->findOne(['_id' => new MongoId($postid)])['likes']);
        $result['dislikes'] = count($postsCol->findOne(['_id' => new MongoId($postid)])['dislikes']);

        return $result;
    }

    public function getImg($fileid)
    {
        $db = Yii::app()->edmsMongoDB();
        $postsCol = $db->posts;

        // GridFS holen
        $gridfs = $db->getGridFS('fs');

        $mongoFile = $gridfs->get(new MongoId($fileid));

        $src = imagecreatefromstring($mongoFile->getBytes());
        //$dest = imagecreatetruecolor(intval($new_width), intval($new_height));

        //imagecopyresampled($dest, $src, 0, 0, 0, 0, $new_width, $new_height, imagesx($src), imagesy($src));

        return $src;
    }

    public function setPics($postid)
    {
        $db = Yii::app()->edmsMongoDB();
        $postsCol = $db->posts;
        $grid = $db->getGridFS();
        
        $files = array_keys($_FILES);
        foreach ($files as $file)
        {
            $fileids = $grid->storeUpload($file);
        }
        $result = $postsCol->update(['_id' => new MongoId($postid)],
            ['$set' =>
                ['pics' => $fileids]
            ]
        );
    }

    public function setComment($com)
    {
        $db = Yii::app()->edmsMongoDB();
        $postsCol = $db->posts;

        $result = $postsCol->update(['_id' => new MongoId($com['postid'])],
            ['$push' =>
                ['comments' =>
                    ['_id' => new MongoId(),
                    'authorId' => $com['userid'],
                    'content' => $com['content'],
                    'createTime' => $com['createTime'],
            ]]]
        );

        return $result;
    }

    public function toggleLikeDislike($postid, $userid, $toggleState)
    {
        $db = Yii::app()->edmsMongoDB();
        $postsCol = $db->posts;

        $oldState = $this->getLikeDislikeState($postid, $userid);

        if ($oldState === $toggleState)
            $newState = 'neutral';
        else if ($toggleState === 'like')
            $newState = 'like';
        else if ($toggleState === 'dislike')
            $newState = 'dislike';
        else
            $newState = false;

        if ($newState)
            $this->setLikeDislikeState($postid, $userid, $newState);

        return $newState;
    }

    public function setLikeDislikeState($postid, $userid, $state)
    {
        $db = Yii::app()->edmsMongoDB();
        $postsCol = $db->posts;

        $postsCol->update(
            ['_id' => new MongoId($postid)],
            ['$pull' => ['likes' => new MongoId($userid)]]);
        $postsCol->update(
            ['_id' => new MongoId($postid)],
            ['$pull' => ['dislikes' => new MongoId($userid)]]);

        switch ($state)
        {
            case 'like':
                $postsCol->update(
                    ['_id' => new MongoId($postid)],
                    ['$push' => ['likes' => new MongoId($userid)]]);
                break;
            case 'dislike':
                $postsCol->update(
                    ['_id' => new MongoId($postid)],
                    ['$push' => ['dislikes' => new MongoId($userid)]]);
                break;
            default:
                break;
        }
        
        return;
    }

    public function getLikeDislikeState($postid, $userid)
    {
        $db = Yii::app()->edmsMongoDB();
        $postsCol = $db->posts;

        if (!is_null($postsCol->findOne(['_id' => new MongoId($postid), 'likes' => ['$in' => [new MongoId($userid)]]])))
            $state = 'like';
        else if (!is_null($postsCol->findOne(['_id' => new MongoId($postid), 'dislikes' => ['$in' => [new MongoId($userid)]]])))
            $state = 'dislike';
        else
            $state = 'neutral';

        return $state;
    }

    public function delComment($commentid)
    {
        $db = Yii::app()->edmsMongoDB();
        $postsCol = $db->posts;

        $authorId = $postsCol->findOne(['comments._id' => new MongoId($commentid)], ['_id' => 0, 'comments.$' => 1])['comments'][0]['authorId']->__toString();

        // Ist der Löschende auch der Author des Kommentars?
        if ($authorId === Yii::app()->user->id->__toString())
            $result = $postsCol->update(['comments._id' => new MongoId($commentid)],
                ['$pull' =>
                    ['comments' =>
                        ['_id' => new MongoId($commentid),
                ]]]
            );
        else
            $result = false;

        return $result;
    }

    public function getPostsByFilter($filter)
    {
        $db = Yii::app()->edmsMongoDB();
        $col = $db->posts;
        $usersCol = $db->users;

        $maxDistance = 500.0 / 6371.0; // 100km in Erdradien

        if ($filter['sort'] === "close")
        {
            if ($filter['cat'] === "all")
                $result = $col->find(['location' => ['$nearSphere' => [$filter['longitude'], $filter['latitude']]]]);
            else if (Post::is_Category($filter['cat']))
                $result = $col->find(['location' => ['$nearSphere' => [$filter['longitude'], $filter['latitude']]], 'category' => $filter['cat']]);
        }
        else if ($filter['sort'] === "new")
        {
            if ($filter['cat'] === "all")
                $result = $col->find(['location' => ['$within' => ['$centerSphere' => [[$filter['longitude'], $filter['latitude']], $maxDistance]]]])->sort(['createTime' => -1]);
            else if (Post::is_Category($filter['cat']))
                $result = $col->find(['location' => ['$within' => ['$centerSphere' => [[$filter['longitude'], $filter['latitude']], $maxDistance]]], 'category' => $filter['cat']])->sort(['createTime' => -1]);
        }
        else if ($filter['sort'] === "popular")
        {
            if ($filter['cat'] === "all")
                $result = $col->find(['location' => ['$within' => ['$centerSphere' => [[$filter['longitude'], $filter['latitude']], $maxDistance]]]])->sort(['likes' => 1]);
            else if (Post::is_Category($filter['cat']))
                $result = $col->find(['location' => ['$within' => ['$centerSphere' => [[$filter['longitude'], $filter['latitude']], $maxDistance]]], 'category' => $filter['cat']])->sort(['likes' => 1]);
        }

        if (!isset($result))
            echo "FALSCHER FILTER!";

        $posts = iterator_to_array($result, false);

        // username/author der posts hinzufügen
        for ($i = 0; $i < count($posts); $i++)
        {
            $posts[$i]['author'] = $usersCol->findOne(['_id' => new MongoId($posts[$i]['authorId'])])['username'];
        }

        return $posts;
    }

    public static function is_Category($catName)
    {
        return true;
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