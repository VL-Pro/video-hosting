<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'username',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
            'email:email',
            // 'secret_key',
            [
                'attribute' => 'role',
                'content' => function($data) {
                    if($data->role == \common\models\User::ROLE_ADMIN) {
                        $content = 'Admin';
                    } else {
                        $content = 'User';
                    }
                    return $content;
                }
            ],
            [
                'attribute' => 'status',
                'content' => function($data) {
                    $content = '';
                    if ($data->status == \common\models\User::STATUS_ACTIVE)
                    {
                        $content = 'Active';
                    } else {
                        $content = 'Deleted';
                    }
                    return $content;
                }
            ],
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
