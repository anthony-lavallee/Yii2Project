<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\EntryForm;

use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;

use app\models\Auth;
use app\models\User;

use yii\log\Logger;
use yii\authclient\BaseClient;
use yii\web\Response;


//include 'RbacController.php';

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                    
                        'actions' => ['logout'],
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

             //'authenticator' => [
                //'class' => HttpBasicAuth::className(),
                //'class' => QueryParamAuth::className(),
                //'class' => HttpBearerAuth::className(),
                /*'class' => CompositeAuth::className(),

                'authMethods' => [
                    //HttpBasicAuth::className(),
                    //HttpBearerAuth::className(),
                    //QueryParamAuth::className(),
                ],*/
            //],
        

        ];
    }

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

            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    public function actionIndex()
    {


        log(Yii::$app->user->isGuest);
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSay($message = 'Hello')
    {
	return $this->render('say', ['message' => $message]);
    }

    public function actionEntry()
    {
       $model = new EntryForm();

       if ($model->load(Yii::$app->request->post()) && $model->validate())
       {
	  // valid data received  in$model
	  // do something meaningful here about $model ...
 	  return $this->render('entry-confirm', ['model' => $model]);
       }
       else
       {
          //either the page is initially displayed or there is some validation error
          return $this->render ('entry', ['model' => $model]);
       }
    }

    /**
 * @inheritdoc
 */
public function beforeAction($action)
{

    if (parent::beforeAction($action)) {
        // If you want to change it only in one or few actions, add additional check

        Yii::$app->user->loginUrl = ['site/login'];

        return true;
    } else {
        return false;
    }
}


public function onAuthSuccess($client)
{

    $attributes = $client->getUserAttributes();

    /** @var Auth $auth */
    $auth = Auth::find()->where([
        'source' => $client->getId(),
        'source_id' => $attributes['id'],
    ])->one();
        
    if (Yii::$app->user->isGuest) 
    {
        if ($auth) 
        { // login

            $user = $auth->user;
            Yii::$app->user->login($user);

        } 
        else 
        { // signup
            if (isset($attributes['email']) && isset($attributes['username']) && User::find()->where(['email' => $attributes['email']])->exists()) {
                 Yii::$app->getSession()->setFlash('error', [
                     Yii::t('app', "User with the same email as in {client} account already exists but isn't linked to it. Login using email first to link it.", ['client' => $client->getTitle()]),
                ]);
            } 
            else 
            {


               //$this->actionTest($client);

                $password = Yii::$app->security->generateRandomString(6);

                $username = $attributes['emails'][0]['value'];
                $authkey = $attributes['emails'][0]['value'];
                $email =  $attributes['emails'][0]['value'];
                $id = $attributes['id'];

                $user = new User([
                    //'id' => $id,
                    'username' =>  $username,
                    'auth_key' => $authkey,
                    'email' => $email,
                    'password_hash' => $password,
                    'status' => 1,
                    ]);

                $user->generateAuthKey();
                $user->generatePasswordResetToken();
                $transaction = $user->getDb()->beginTransaction();


                if ($user->save()) 
                {
                    $auth = new Auth([
                        //'user_id' => $user->getPrimaryKey(),
                        //'user_id' => Yii::$app->user->id,
                        'user_id' => $user['oldAttributes']['id'],
                        'source' => $client->getId(),
                        'source_id' => (string)$attributes['id'],
                    ]);

                    if ($auth->save()) 
                    {
                        $transaction->commit();
                        Yii::$app->user->login($user);
                    } 
                    else 
                    {
                        print_r($auth->getErrors());
                    }
                } 
                else 
                {
                    print_r($user->getErrors());
                }
            }
        }
    } 
    else 
    { // user already logged in
        if (!$auth) 
        { // add auth provider
            $auth = new Auth([
                'user_id' => Yii::$app->user->id,
                'source' => $client->getId(),
                'source_id' => $attributes['id'],
            ]);
            $auth->save();
        }
    }
    
}
public function actionTest()
{
     $user = new User([
                        'username' =>  'Anthony',
                        'auth_key' => 'aaa',
                        'email' => 'bbb',
                        'password_hash' => 'test',
                        'status' => 1,
                        ]);


    $user->save();
    
    /*var_dump($user['oldAttributes']['id']);
    exit();*/
}


}

/*
return [
            'access' => [
                'class' => AccessControl::className(),
                //only' => ['logout'],
                'rules' => [
                    [
                        //'actions' => ['logout'],
                        'actions' => ['login', 'index', 'error'],
                        'allow' => true,
                        //'roles' => ['@'],
                    ],

                    //
                    [
                        'actions' => ['logout', 'about', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],*/