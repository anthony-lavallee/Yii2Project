<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
include "../vendor/bshaffer/oauth2-server-php/src/OAuth2/ResponseType/AccessToken.php";

/**
 * This is the model class for table "oauth_users".
 *
 * @property string $username
 * @property string $password
 * @property string $first_name
 * @property string $last_name
 */
class Oauthuser extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface, \OAuth2\Storage\UserCredentialsInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'oauth_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username'], 'required'],
            [['username', 'first_name', 'last_name'], 'string', 'max' => 255],
            [['password'], 'string', 'max' => 2000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Username',
            'password' => 'Password',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
        ];
    }


     /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        $user = Oauthuser::find()->where(['id' => $id])->one();

        if(isset($user))
        {
           return $user; 
        }
        return null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {

        $tokenAttributes = \filsh\yii2\oauth2server\models\OauthAccessTokens::find()->where(['access_token' => $token])->one();

        $user_id = $tokenAttributes['user_id'];

        //$user = Oauthuser::find()->where(['id' => $user_id])->one();
        $user = Oauthuser::find()->where(['username' => $user_id])->one();

       /* var_dump($user);
        exit();*/

        if(isset($user))
        {
           return $user; 
        }
        return null;
    }

    /**
     * Finds user by username
     *
     * @param  string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $user = Oauthuser::find()->where(['username' => $username])->one();
        if(isset($user))
        {
           return $user; 
        }
        return null; 
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {

    }

    public function generateAuthKey()
    {

    }

    public function generatePasswordResetToken()
    {

    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {

    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        if (Yii::$app->getSecurity()->validatePassword($password, $this->password))
        {
            return true;
        }
        return false;

        //return $this->password === $password;
    }

    public function checkUserCredentials($username, $password)
    {

    }

    public function getUserDetails($username)
    {

    }
}
