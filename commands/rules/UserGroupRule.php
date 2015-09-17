<?php

namespace app\commands\rules;

use Yii;
use yii\rbac\Rule;

/**
 * Checks if user group matches
 */
class UserGroupRule extends Rule
{
    public $name = 'userGroup';

    public function execute($user, $item, $params)
    {
        if (!Yii::$app->user->isGuest) {
            $role = Yii::$app->user->identity->role;
            if ($item->name === 'admin') {
                return $role === $item->name;
            } elseif ($item->name === 'author') {
                return $role === $item->name || $role === 'admin';
            }
        }
        return false;
    }
}