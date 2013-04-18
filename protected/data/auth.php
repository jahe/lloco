<?php
return array (
  'createPost' => 
  array (
    'type' => 0,
    'description' => 'Creating a post.',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'readPost' => 
  array (
    'type' => 0,
    'description' => 'Reading a post.',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'deletePost' => 
  array (
    'type' => 0,
    'description' => 'Deleting a post.',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'guest' => 
  array (
    'type' => 2,
    'description' => 'A user that is not signed in.',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'readPost',
    ),
  ),
  'manageOwnPost' => 
  array (
    'type' => 1,
    'description' => 'Manage own post.',
    'bizRule' => 'return Yii::app()->user->id == $params["author"];',
    'data' => NULL,
    'children' => 
    array (
      0 => 'deletePost',
    ),
  ),
  'authenticated' => 
  array (
    'type' => 2,
    'description' => 'A signed in user.',
    'bizRule' => 'return !Yii::app()->user->isGuest;',
    'data' => NULL,
    'children' => 
    array (
      0 => 'guest',
      1 => 'createPost',
      2 => 'manageOwnPost',
    ),
  ),
  'admin' => 
  array (
    'type' => 2,
    'description' => '',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'createPost',
      1 => 'readPost',
      2 => 'deletePost',
    ),
  ),
);
