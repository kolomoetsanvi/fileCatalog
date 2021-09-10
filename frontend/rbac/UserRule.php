<?php

namespace frontend\rbac;

use yii\rbac\Item;
use yii\rbac\Rule;

class UserRule extends Rule
{
    public $name = 'isOwner';

    /**
     * @param string|int $user the user ID.
     * @param Item $item the role or permission that this rule is associated width.
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return bool a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
        return isset($params['file']) ? $params['file']->created_by_user == $user : false;
    }
}