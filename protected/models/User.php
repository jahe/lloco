<?php

class User extends EMongoDocument
{
  public $username;
  public $password;
  public $email;
  
  public function getCollectionName()
  {
    return 'users';
  }
  
  public function rules()
  {
    return array(
      array('username, password, email', 'required'),
      //array('username', 'unique')
    );
  }
  
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function getProfileImg($username, $new_width, $new_height)
  {
    $db = Yii::app()->edmsMongoDB();
    $users = $db->users;

    // get MongoId des Profilbildes
    $imgId = $users->findOne(['username' => $username], ['profileImg' => true])['profileImg'];

    // GridFS holen
    $gridfs = $db->getGridFS('fs');

    if (is_null($imgId))
      $mongoFile = $gridfs->get(new MongoId("51ad1b2e27698fe2512b43d1"));
    else
      $mongoFile = $gridfs->get($imgId);

    $src = imagecreatefromstring($mongoFile->getBytes());
    $dest = imagecreatetruecolor(intval($new_width), intval($new_height));

    imagecopyresampled($dest, $src, 0, 0, 0, 0, $new_width, $new_height, imagesx($src), imagesy($src));

    return $dest;
  }
}

?>