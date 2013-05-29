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
	
	public function actionView()
	{
		$post = null;
		if (isset($_GET['id']))
		{
			$criteria = new EMongoCriteria;
			$criteria->_id = new MongoId($_GET['id']);
			$post = Post::model()->find($criteria);
		}
		if ($post === null)
			throw new CHttpException(404, 'Dieser Post existiert nicht!');
		
		$this->render('view', array('post' => $post, 'comment' => new Comment));
	}

	public function actionTest()
	{
		$long = $_GET['lo'];
		$lat = $_GET['la'];

		$result = Post::getPostsByProximity($long, $lat);

		$this->render('test', array('result' => $result));
	}
	
	public function actionShow()
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$location = array($_POST['longitude'], $_POST['latitude']);
			$criteria = new EMongoCriteria;
			$criteria->addCond('location', 'nearSphere', $location);
			$posts = Post::model()->findAll($criteria);
			$this->renderPartial('_listPosts', array('posts' => $posts, 'location' => $location));
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
			//$userId = Yii::app()->user->userid;
			$title = $request->getPost('title');
			$content = $request->getPost('content');
			$category_id = $request->getPost('category');
			$tags = explode(",", $request->getPost('tags'));
			foreach ($tags as $key => $value)
				$tags[$key] = trim($value);
			$latitude = $request->getPost('latitude');
			$longitude = $request->getPost('longitude');

			// HIER NOCH MEHR Attribute!!!

			$post = new Post();
			//$post->authorId = $userId;
			$post->authorId = Yii::app()->user->id;
			$post->title = $title;
			$post->content = $content;
			$post->category = $category_id;
			$post->tags = $tags;
			$post->latitude = $latitude;
			$post->longitude = $longitude;
			$post->createTime = time();
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