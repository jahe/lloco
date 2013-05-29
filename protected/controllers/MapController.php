<?php

class MapController extends CController
{
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/post/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->redirect('map/show');
	}

	public function actionShow()
	{
		$this->render('showMap');
	}

	public function actionExplore()
	{
		$longitude;
		$latitude;
		$zoom = 10;

		// Direkte Angabe der gewünschten Position in der URL
		if (isset($_GET['lon']) && isset($_GET['lat']))
		{
			$longitude = floatval($_GET['lon']);
			$latitude = floatval($_GET['lat']);

			if (isset($_GET['zoom']))
				$zoom = intval($_GET['zoom']);
		}
		// Letzte Position aus den Cookies lesen
		else if (isset(Yii::app()->request->cookies['lastPos']))
		{
			$lastPosition = json_decode(Yii::app()->request->cookies['lastPos']);
			$longitude = floatval($lastPosition->longitude);
			$latitude = floatval($lastPosition->latitude);
		}
		// Postition durch GeoIP auflösen
		/*
		else
		{
			$geoip = json_decode(file_get_contents("http://www.freegeoip.net/json/" . Yii::app()->request->userHostAddress));
			$longitude = floatval($geoip->longitude);
			$latitude = floatval($geoip->latitude);
		}
		*/
		// DEFAULT: Flensburg
		else
		{
			$longitude = 9.4333333;
			$latitude = 54.7833333;

			Yii::app()->request->cookies['lastPos'] = new CHttpCookie('lastPos', json_encode(array(
				'longitude' => $longitude,
				'latitude' => $latitude)));
		}

		$this->render('explore', array(
			'longitude' => $longitude,
			'latitude' => $latitude,
			'zoom' => $zoom));
	}

	public function actionGetpost($post_id)
	{
		$postdata = Post::model()->getPostData($post_id);

		$this->renderPartial('postPopup', ['post' => $postdata]);
	}

	public function actionGetposts()
	{
		$ne = [floatval($_GET['nelng']), floatval($_GET['nelat'])];
		$sw = [floatval($_GET['swlng']), floatval($_GET['swlat'])];



		$response = Post::getPostsByBox($ne, $sw);

		header('Content-type: application/json');

		echo json_encode(array('posts' => $response));
		Yii::app()->end();
	}
}

?>