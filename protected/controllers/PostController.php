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

	public function actionOverview($cat = null, $sort = null, $latitude = null, $longitude = null)
	{
		$filter['cat'] = (!is_null($cat)) ? $cat : 'all';
		$filter['sort'] = (!is_null($sort)) ? $sort : 'close';
		if (!is_null($latitude) || !is_null($longitude))
		{
			$filter['latitude'] = floatval($latitude);
			$filter['longitude'] = floatval($longitude);
		}
		// Letzte Position aus den Cookies lesen
		else if (isset(Yii::app()->request->cookies['lastPos']))
		{
			$lastPosition = json_decode(Yii::app()->request->cookies['lastPos']);

			$filter['latitude'] = floatval($lastPosition->latitude);
			$filter['longitude'] = floatval($lastPosition->longitude);
		}
		// DEFAULT: Flensburg
		else
		{
			$filter['latitude'] = 54.7833333;
			$filter['longitude'] = 9.4333333;
		}

		$sorts = ['close' => 'In der Nähe', 'new' => 'Neuigkeiten', 'popular' => 'Angesagt'];

		$categories = Category::getAllCategories();
		$this->render('overview', ['categories' => $categories, 'sorts' => $sorts, 'filter' => $filter]);
	}

	public function actionGetposts($cat = null, $sort = null, $latitude = null, $longitude = null)
	{
		// DEFAULT.. MUSS NOCH VERNÜNFTIG VALIDIERT WERDEN!
		if (is_null($latitude))
			$latitude = 54.7833333;
		if (is_null($longitude))
			$longitude = 9.4333333;

		$posts = Post::model()->getPostsByFilter(
			['cat' => $cat,
			'sort' => $sort,
			'latitude' => floatval($latitude),
			'longitude' => floatval($longitude)]
		);

		$this->renderPartial('listedPosts', ['posts' => $posts]);
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

	public function actionGetimg($fileid)
	{
		$img = Post::model()->getImg($fileid);

		header('Content-type: image/jpeg');

		imagejpeg($img);
		imagedestroy($img);


		/*
		while (!feof($imgStream)) {
			echo fread($imgStream, 8192);
		}
		*/

		Yii::app()->end();
	}

	public function actionCreatecomment()
	{
		$postId = $_POST['postId'];
		$content = $_POST['content'];
		$userId = Yii::app()->user->id;
		$createTime = time();

		$commentdata = [
			'postid' => $postId,
			'userid' => $userId,
			'content' => $content,
			'createTime' => $createTime,
		];

		$done = Post::model()->setComment($commentdata);

		header('Content-type: application/json');

		echo json_encode(['done' => $done]);
		Yii::app()->end();
	}

	public function actionLikedislike()
	{
		$toggleState = $_POST['toggle'];
		$postid = $_POST['postid'];
		$userid = Yii::app()->user->id;

		$newState = Post::model()->toggleLikeDislike($postid, $userid, $toggleState);

		header('Content-type: application/json');

		echo json_encode(['state' => $newState]);
		Yii::app()->end();
	}

	public function actionGetlikestats($postid)
	{
		$result = Post::model()->getLikeStats($postid);
		header('Content-type: application/json');

		echo json_encode($result);
		Yii::app()->end();
	}

	public function actionDelete()
	{
		$postid = $_POST['postid'];

		$result = Post::model()->deletePost($postid);

		header('Content-type: application/json');

		echo json_encode(['done' => $result]);
		Yii::app()->end();
	}

	public function actionDeletecomment()
	{
		$commentid = $_POST['commentid'];

		$done = Post::model()->delComment($commentid);

		header('Content-type: application/json');

		echo json_encode(['done' => $done]);
		Yii::app()->end();
	}

	public function actionGetcomments($postid)
	{
		$posts = Post::model()->getPostData($postid);
		$this->renderPartial('listedComments', ['comments' => $posts['comments']]);
	}
	
	public function actionShow($postid)
	{
		$postdata = Post::model()->getPostData($postid);

		$this->render('showPost', ['post' => $postdata]);
		/*
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
		*/

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


			// HIER DIE DATEIEN ÜBERPRÜFEN!
			if (isset($_FILES['pics']['name']))
			{
				foreach ($_FILES['pics']['name'] as $pic)
				{

				}
			}

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

			if (isset($_FILES['pics']['name']))
				$result = Post::model()->setPics($post->_id->__toString());

			$this->redirect(['post/show', 'postid' => $post->_id->__toString()]);
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