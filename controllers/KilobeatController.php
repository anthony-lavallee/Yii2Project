<?php
namespace app\controllers;

use Yii;
use app\models\Kilobeat;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\rest\ActiveController;

class KilobeatController extends ActiveController
{
    public $modelClass = 'app\models\Kilobeat';
}
