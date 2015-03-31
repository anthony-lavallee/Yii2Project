<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\Country;
use app\models\CountrySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\rest\ActiveController;

use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;

use yii\helpers\ArrayHelper;

include 'RbacController.php';


/**
 * CountryController implements the CRUD actions for Country model.
 */
class CountryController extends ActiveController
{
    public  $modelClass = 'app\models\Country';

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    /*'index'  => ['get'],
                    'create' => ['get', 'post'],
                    'delete' => ['post'],*/
                    //'*' => ['get', 'post'],
                ],

                
            ],

            //'authenticator' => [
            //   'class' => HttpBasicAuth::className(),
                
                //'class' => QueryParamAuth::className(),
            //    'auth' => [$this, 'auth']
                /*'class' => CompositeAuth::className(),

                'authMethods' => [
                    //HttpBasicAuth::className(),
                    //HttpBearerAuth::className(),
                    //QueryParamAuth::className(),
                ],*/
            //],
        ]);
          //var_dump(parent::behaviors);
    }

     public function auth($username, $password)
    {
        echo "<script>alert('$username')</script>";
        echo "<script>alert('$password')</script>";
        //$user = new User();
        //$identity = $user->findByUsername($username);
        return \app\models\User::findOne([
                      'username' => $username,
                      'password' => $password,
                  ]);
        //return $identity;
    }



    /**
     * Lists all Country models.
     * @return mixed
     */
    public function actionIndex()
    {
        //actionInit();
        $searchModel = new CountrySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Country model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Country model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        //if(\Yii::$app->user->can('createCountry'))
        //{
            $model = new Country();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->code]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        //}
    }

    /**
     * Updates an existing Country model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->code]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Country model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Country model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Country the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Country::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
