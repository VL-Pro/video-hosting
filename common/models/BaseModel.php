<?php
/**
 * Created by PhpStorm.
 * User: pvp
 * Date: 2/3/2017
 * Time: 8:41 PM
 */

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

class BaseModel extends ActiveRecord
{
    const STATUS_ACTIVE = 10;
    const STATUS_INV = 5;
    const STATUS_DELETED = 0;


    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
        ];
    }

    public function getCreatedBy($attribute)
    {
        $user = User::findOne($this->created_by);
        return $user->hasAttribute($attribute) ? $user->{$attribute} : $user->email;
    }

    public function getUpdatedBy($attribute)
    {
        $user = User::findOne($this->updated_by);
        return $user->hasAttribute($attribute) ? $user->{$attribute} : $user->email;
    }

    public function getDate($date)
    {
        return Yii::$app->formatter->asDate($date, 'medium');
    }


    public static function getActive()
    {
        return self::findAll(['status' => self::STATUS_ACTIVE]);
    }
}