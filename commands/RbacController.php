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

        // add "updateCountry" permission
        $updateCountry = $auth->createPermission('updateCountry');
        $updateCountry->description = 'Update country';
        $auth->add($updateCountry);

        // add "author" role and give this role the "createPost" permission
        $author = $auth->createRole('author');
        $auth->add($author);
        $auth->addChild($author, $createCountry);

        $rule = new AuthorRule;
        $auth->add($rule);

        // add the "updateOwnCountry" permission and associate the rule with it.
        $updateOwnCountry = $auth->createPermission('updateOwnCountry');
        $updateOwnCountry->description = 'Update own country';
        $updateOwnCountry->ruleName = $rule->name;
        $auth->add($updateOwnCountry);

        // "updateOwnCountry" will be used from "updateCountry"
        $auth->addChild($updateOwnCountry, $updateCountry);

        // allow "author" to update their own posts
        $auth->addChild($author, $updateOwnCountry);
    }
}