<?php
/**
 * Created by PhpStorm.
 * User: pvp
 * Date: 2/22/2017
 * Time: 5:53 PM
 */

namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\components\rbac\UserRoleRule;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();
        $dashboard = $auth->createPermission('dashboard');
        $dashboard->description='Admin Panel';
        $auth->add($dashboard);
        $rule = new UserRoleRule();
        $auth->add($rule);

        $user = $auth->createRole('user');
        $user->description='User';
        $user->ruleName = $rule->name;
        $auth->add($user);

        $admin = $auth->createRole('admin');
        $admin->description = 'Administrator';
        $admin->ruleName = $rule->name;
        $auth->add($admin);
        $auth->addChild($admin, $dashboard);
    }
}