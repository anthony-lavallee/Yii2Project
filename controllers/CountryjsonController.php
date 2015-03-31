<?php
namespace app\controllers;

use Yii;
use app\models\Country;
use yii\web\Controller;
//use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;

use yii\rest\ActiveController;

class CountryjsonController extends ActiveController
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

            'authenticator' => [
                'class' => HttpBasicAuth::className(),
                //'class' => QueryParamAuth::className(),
                /*'class' => CompositeAuth::className(),

                'authMethods' => [
                    //HttpBasicAuth::className(),
                    //HttpBearerAuth::className(),
                    //QueryParamAuth::className(),
                ],*/
            ],
        ];
    }

    public  $modelClass = 'app\models\Country';
}
