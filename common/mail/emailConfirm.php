<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['site/email-confirm', 'token' => $user->secret_key]);
?>

Hi, <?= Html::encode($user->username) ?>!

Thank you for visiting Video-hosting. To activate your account please click the following link

<?= Html::a(Html::encode($confirmLink), $confirmLink) ?>