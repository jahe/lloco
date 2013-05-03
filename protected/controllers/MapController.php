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
}

?>