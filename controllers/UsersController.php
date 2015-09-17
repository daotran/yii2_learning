<?php

namespace app\controllers;

use Yii;
use app\models\Users;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UsersController implements the CRUD actions for Users model.
 */
class UsersController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Users models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Users::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Users model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Users();

        if ($model->load(Yii::$app->request->post())) {
            $data = Yii::$app->request->post();

            // Checking user email already existed in database or not
            $obj = $model->findByUsername($data['Users']['email']);
            if (isset($obj->attributes)) {
                Yii::$app->session->setFlash('error', "There is already an account with this email address, please try again.!");
                return $this->render('create', [
                    'model' => $model,                
                ]);
            }

            $model->status = 1;
            $model->setPassword($data['Users']['password']);
            $model->generateAuthKey();
            $model->generatePasswordResetToken();
            //$model->password = Yii::$app->security->generatePasswordHash($data['Users']['password']);
            //$model->auth_key = Yii::$app->security->generateRandomString();
            //$model->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();

            if ($model->save()) {
                // the following three lines were added in order for all signed up users to become authors
                $auth = Yii::$app->authManager;
                $authorRole = $auth->getRole('author');
                $auth->assign($authorRole, $model->getId());
                Yii::$app->session->setFlash('success',Yii::t('app','You have created successfully'));
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('create', [
                'model' => $model,                
            ]);
        }
    }

    /**
     * Updates an existing Users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $data = Yii::$app->request->post();
            $model->status = 1;
            $model->password = Yii::$app->security->generatePasswordHash($data['Users']['password']);
            $model->auth_key = Yii::$app->security->generateRandomString();
            $model->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();

            if ($model->save()) {
                Yii::$app->session->setFlash('success',Yii::t('app','You have updated successfully'));
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('update', [
                'model' => $model,                
            ]);
        }
    }

    /**
     * Deletes an existing Users model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
