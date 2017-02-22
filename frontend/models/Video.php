<?php
/**
 * Created by PhpStorm.
 * User: pvp
 * Date: 2/20/2017
 * Time: 7:26 PM
 */

namespace frontend\models;


class Video extends \common\models\Video
{
    public static function find()
    {
        return parent::find()->joinWith('topic');
    }

    public function getTopic()
    {
        return $this->hasOne(Topic::className(), ['id' => 'topic_id']);
    }
}