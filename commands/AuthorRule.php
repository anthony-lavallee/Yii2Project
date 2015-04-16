<?php
namespace app\commands;

use yii\rbac\Rule;

/**
 * Checks if authorID matches user passed via params
 */
class AuthorRule extends Rule
{
    public $name = 'isAuthor';

    /**
     * @param string|integer $user the user ID.
     * @param Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return boolean a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
        $user_id = $params['country']['user_id'];

        /*var_dump($params['country']->getAuthor());
        exit();*/

        /*var_dump($params['country']->getAuthor()->link['id']);
        exit();*/

        return isset($params['country']) ? $params['country']->getAuthor($user_id)->link['id'] == $user : false;
        //return isset($params['country']) ? $params['country']->getAuthor()->link['id'] == $user : false;
    }
}
