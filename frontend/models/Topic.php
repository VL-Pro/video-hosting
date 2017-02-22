<?php
/**
 * Created by PhpStorm.
 * User: pvp
 * Date: 2/20/2017
 * Time: 5:52 PM
 */

namespace frontend\models;


class Topic extends \common\models\Topic
{
    public static function find()
    {
        return parent::find()->joinWith('section')->andWhere(['not in', Topic::tableName().'.status', [Topic::STATUS_INV, Topic::STATUS_DELETED]]);
    }

    public function getSection()
    {
        return $this->hasOne(Section::className(), ['id' => 'section_id']);
    }
}