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
		$this->render('index', array('ansage' => 'HELLO JANNIK'));
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
			$username = $request->getPost('username');
			$title = $request->getPost('title');
			$content = $request->getPost('content');

			$post = new Post();
			$post->username = $username;
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