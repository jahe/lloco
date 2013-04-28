<?php

class PostController extends CController
{
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/post/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index', array('ansage' => Yii::app()->user->isGuest));
	}

	public function actionShow()
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$criteria = new EMongoCriteria;
			$criteria->addCond('location', 'nearSphere', array($_POST['longitude'], $_POST['latitude']));
			$posts = Post::model()->findAll($criteria);
			$this->renderPartial('_listPosts', array('posts' => $posts));
		}
		else
		{
			//$posts = Post::model()->findAll();
			//$this->render('showPost', array('posts' => $posts));
			$this->render('showPost');
		}
	}
	
	/*public function actionPartial()
	{
		$criteria = new EMongoCriteria;
		$criteria->addCond('location', 'nearSphere', array($_POST['longitude'], $_POST['latitude']));
		$posts = Post::model()->findAll($criteria);
		$this->renderPartial('_listPosts', array('posts' => $posts));
	}*/

	public function actionCreate()
	{
		$request = Yii::app()->request;

		if ($request->isPostRequest)
		{
			//$username = $request->getPost('username');
			$userId = Yii::app()->user->userid;
			$title = $request->getPost('title');
			$content = $request->getPost('content');
			$category = $request->getPost('category');
			$latitude = $request->getPost('latitude');
			$longitude = $request->getPost('longitude');

			// HIER NOCH MEHR Attribute!!!

			$post = new Post();
			$post->authorId = $userId;
			$post->title = $title;
			$post->content = $content;
			$post->category = $category;
			$post->latitude = $latitude;
			$post->longitude = $longitude;
			$test = $post->save();

			$posts = Post::model()->findAll();
			$this->render('showPost', array('posts' => $posts));
		}
		else
		{
			$categories = Category::getAllCategories();
			$this->render('createPost', array(	'actionPath' => $request->getUrl(),
												'categories' => $categories));
		}
	}

	public function actionListAll()
	{

	}
}