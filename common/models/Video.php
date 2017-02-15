<?php

namespace common\models;

use yii\base\Exception;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "video".
 *
 * @property integer $id
 * @property string $name
 * @property string $path
 * @property string $description
 * @property integer $topic_id
 * @property integer $image_id
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property Like[] $likes
 * @property User[] $users
 * @property Image $image
 * @property Topic $topic
 */
class Video extends \common\models\BaseModel
{
    public $section;
    public $videoFile;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'video';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'path', 'topic_id'], 'required'],
            [['section', 'topic_id', 'image_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['name', 'path', 'description'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['path'], 'unique'],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Image::className(), 'targetAttribute' => ['image_id' => 'id']],
            [['topic_id'], 'exist', 'skipOnError' => true, 'targetClass' => Topic::className(), 'targetAttribute' => ['topic_id' => 'id']],
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
            'path' => 'Path',
            'description' => 'Description',
            'topic_id' => 'Topic',
            'image_id' => 'Image',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLikes()
    {
        return $this->hasMany(Like::className(), ['video_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('like', ['video_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'image_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopic()
    {
        return $this->hasOne(Topic::className(), ['id' => 'topic_id']);
    }


    /**
     * @return bool
     */
    public function uploadImage()
    {
        $file = UploadedFile::getInstance($this, 'imageFile');

        if($file) {
            if ($image = Image::upload($file, "images/" . $this->getClassName() . "/" . $this->section . "/" . $this -> topic_id, $this->image ? $this->image->id : null)) {
                $this->image_id = $image->id;
                return true;
            }
            return false;
        }
        return true;
    }

    public function uploadVideo()
    {
        $file = UploadedFile::getInstance($this, 'videoFile');
        if($file) {
            $folder = "videos/".Section::getSection($this->section)."/".Topic::getTopic($this->topic_id);

            $videoName = time() . uniqid('', false);

            $path = self::getParentFolderPath();
            $directory = $path . $folder;
            FileHelper::createDirectory($directory, 0775, $recursive = true);
            $file->saveAs("$directory/$videoName." . $file->extension);


            if($this->id){
                if(file_exists($path.$this->path)){
                    try {
                        unlink($path.$this->path);
                    } catch (Exception $exception) {
                        // log
                    }
                }
            }

            $this->path = $folder . "/$videoName." . $file->extension;
        }
        return true;
    }
}
