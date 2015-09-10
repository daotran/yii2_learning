<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\Posts;

class PostsController extends Controller
{

	public function behaviors()
	{
		return [
            'access' => [
                'class' => AccessControl::className(),
                // allow authenticated users to access the "save, delete and logout" actions only
                'only' => ['save', 'delete', 'logout'],
				'rules' => [
					[
						'actions' => ['index', 'save', 'delete'],

						// allow authenticated users
						'allow' => true,
						'roles' => ['@'],
					],
				],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
	}

	/**
	 * Handling Errors
	 * Nobody like errors, but we'll we need to handle them someway.
	 */
	public function actions()
	{
	    return [
	        'error' => [
	            'class' => 'yii\web\ErrorAction',
	        ],
	        'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
	    ];
	}

	public function actionLogout()
	{
		Yii::$app->user->logout();
		return $this->goHome();
	}

	/**
	 * Loads our model and throws an exception if we encounter an error
	 * @param int $id 	The $id of the model we want to delete
	 */
	private function loadModel($id)
	{
		$model = Posts::find()->where(['id' => $id])->one();
		if ($model == NULL)
			throw new HttpException(404, 'Model not found.');

		return $model;
	}

	/*
	 * View the posts
	 */
	public function actionIndex()
	{
    	$models = Posts::find()->all();
    	return $this->render('index', array('models' => $models));
	}

	public function actionLogin()
	{
		$this->layout = 'signin';

		if (!Yii::$app->user->isGuest) {
			$this->goHome();
		}

		$model = new LoginForm();
		if ($model->load($_POST) && $model->login()) {
			return $this->goBack();
		} else {
			return $this->render('login', [
				'model' => $model,
			]);
		}
	}

	/*
	 * Create and Update the post
	 * @param int $id 	The $id of the model we want to update
	 */
	public function actionSave($id=NULL)
	{
		// Checking user logged in or not before updating Posts
		if (Yii::$app->user->isGuest) {
			return $this->redirect('login');
		}
		
		if ($id == NULL) {
	    	$model = new Posts();
	    } else {
	    	$model = $this->loadModel($id);
	    }	        

	    if (isset($_POST['Posts']))
	    {
	        $model->load($_POST);
	        
	        if ($model->save())
	        {
	            Yii::$app->session->setFlash('success', 'Model has been saved');
	            return $this->redirect('index');
	        }
	        else
	            Yii::$app->session->setFlash('error', 'Model could not be saved');
	    }

	    return $this->render('save', array('model' => $model));
	}

	/**
	 * Delete the posts
	 */
	public function actionDelete($id=NULL)
	{
	    $model = $this->loadModel($id);
	    if (!$model->delete())
	        Yii::$app->session->setFlash('error', 'Unable to delete model');

	    return $this->redirect('index');
	}
}