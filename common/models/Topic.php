<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "topic".
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property integer $status
 * @property integer $section_id
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property Section $section
 * @property Video[] $videos
 */
class Topic extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'topic';
    }

    public static function findAvailable()
    {
        return parent::find()->joinWith('section')
            ->andWhere(['<>', self::tableName().'.status', self::STATUS_DELETED])
            ->andWhere(['<>', Section::tableName().'.status', Section::STATUS_DELETED]);
    }

    public static function findOneAvailable($id)
    {
        return self::findAvailable()->andWhere([self::tableName().'.id' => $id])->one();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'slug'], 'required'],
            [['status','section_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['name', 'slug', 'description'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['slug'], 'unique'],
            [['section_id'], 'exist', 'skipOnError' => true, 'targetClass' => Section::className(), 'targetAttribute' => ['section_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'slug' => 'Slug',
            'description' => 'Description',
            'status' => 'Status',
            'section_id' => 'Section',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSection()
    {
        return $this->hasOne(Section::className(), ['id' => 'section_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVideos()
    {
        return $this->hasMany(Video::className(), ['topic_id' => 'id']);
    }


    public function __toString()
    {
        return (string)$this->name;
    }

    public static function getTopic($topic_id)
    {
        return self::findOne($topic_id);
    }

    public static function getTopicSlug($topic_id)
    {
        return self::findOne($topic_id)->slug;
    }
}
