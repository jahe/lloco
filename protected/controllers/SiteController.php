<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	public function actionLogin()
	{
		$username = $_POST['username'];
		$password = $_POST['password'];

		// Benutzer mit übergebenem Benutzernamen/Passwort anmelden
		$identity = new LUserIdentity($username, $password);
		if($identity->authenticate())
		{
			Yii::app()->user->login($identity);
			$this->render('index', array('ansage' => "angemeldet"));
		}
		else
		{
			//$this->renderPartial('_ajaxContent', $data, false, true);
			//$this->render('index', array('ansage' => "FAIL: " . $identity->errorMessage));
			$this->render('login', array('errorMsg' => $identity->errorMessage));
		}
		// Aktuellen Benutzer abmelden
		//Yii::app()->user->logout();
		//$this->redirect(Yii::app()->user->returnUrl);
	}

	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

	public function actionSignup()
	{
		if (Yii::app()->request->isPostRequest)
		{
			$user = new User();
			$user->username = $_POST['username'];
			$user->email = $_POST['email'];
			$user->password = $_POST['password'];
			$user->save();

			$identity = new LUserIdentity($user->username, $user->password);
			if($identity->authenticate())
			{
				Yii::app()->user->login($identity);
			}

			$this->redirect(Yii::app()->homeUrl);
		}
		else
			$this->render('signup');
	}
}