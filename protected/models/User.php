<?php
class User extends EMongoDocument
{
  public $_id;
  public $username;
  public $password;

  // This has to be defined in every model, this is same as with standard Yii ActiveRecord
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  // This method is required!
  public function getCollectionName()
  {
    return 'users';
  }
}
?>