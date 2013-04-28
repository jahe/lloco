<?php

class Category extends EMongoDocument
{
  public $title;

  public static function getAllCategories()
  {
    $categories = Category::model()->findAll();
    return $categories;
  }

  public function getCollectionName()
  {
    return 'categories';
  }

  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }
}

?>