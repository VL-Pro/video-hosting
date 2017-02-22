<?php
/**
 * Created by PhpStorm.
 * User: pvp
 * Date: 2/22/2017
 * Time: 5:23 PM
 */

namespace common\components\rbac;


use common\models\User;
use yii\rbac\Rule;
use yii\helpers\ArrayHelper;

class UserRoleRule extends Rule
{
    public $name = 'userRole';
    public function execute($user, $item, $params)
    {
        $user = ArrayHelper::getValue($params, 'user', User::findOne($user));
        if($user) {
            $role = $user->role;
            if($item->name === 'admin') {
                return $role == User::ROLE_ADMIN;
            } else if($item->name == 'user') {
                return $role == User::ROLE_ADMIN || $role == User::ROLE_USER;
            }
        }
        return false;
    }
}