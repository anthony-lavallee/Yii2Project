<?php
namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // add "createPost" permission
        $createCountry = $auth->createPermission('createCountry');
        $createCountry->description = 'Create a country';
        $auth->add($createCountry);

        // add "updatePost" permission
        $updateCountry = $auth->createPermission('updateCountry');
        $updateCountry->description = 'Update country';
        $auth->add($updateCountry);

        // add "author" role and give this role the "createPost" permission
        $author = $auth->createRole('author');
        $auth->add($author);
        $auth->addChild($author, $createCountry);

        // add "admin" role and give this role the "updatePost" permission
        // as well as the permissions of the "author" role
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $updateCountry);
        $auth->addChild($admin, $createCountry);
        $auth->addChild($admin, $author);

        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        $auth->assign($author, 2);
        $auth->assign($admin, 1);

        $auth = Yii::$app->authManager;
        $authorRole = $auth->getRole('admin');
        $auth->assign($authorRole, 100);
          echo "<script>alert('test')</script>";

    }
}