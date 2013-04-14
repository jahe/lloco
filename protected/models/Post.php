<?php
class Post extends EMongoDocument
{
  public $username;
  public $title;
  public $content;
  public $latitude;
  public $longitude;
  public $tags;
  public $timestamp;
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
      array('username, title, content', 'required'),
      array('username', 'length', 'max' => 255),
    );
  }

  public function attributeLabels()
  {
    return array(
      'username'  => 'Benutzername',
      'title'   => 'Titel',
      'content'   => 'Inhalt',
    );
  }

  public function createPost()
  {

  }
  public function findRecentComments($limit = 10)
  {
    $criteria = new EMongoCriteria;
    $criteria->status = self::STATUS_APPROVED;
    $criteria->sort('createTime', EMongoCriteria::SORT_DESC);
    $criteria->limit($limit);
    return Comment::model()->findAll($criteria);
  }
}
?>