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
		$posts = Post::model()->findAll();
		$this->render('showPost', array('posts' => $posts));
	}

	public function actionCreate()
	{
		$request = Yii::app()->request;

		if ($request->isPostRequest)
		{
			//$username = $request->getPost('username');
			$userId = Yii::app()->user->userid;
			$title = $request->getPost('title');
			$content = $request->getPost('content');

			// HIER NOCH MEHR Attribute!!!

			$post = new Post();
			$post->authorId = $userId;
			$post->title = $title;
			$post->content = $content;
			$test = $post->save();

			$posts = Post::model()->findAll();
			$this->render('showPost', array('posts' => $posts));
		}
		else
		{
			$this->render('createPost', array('actionPath' => $request->getUrl()));
		}
	}

	public function actionListAll()
	{

	}
}