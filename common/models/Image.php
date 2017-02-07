<?php

namespace common\models;


use Yii;
use yii\base\Exception;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "image".
 *
 * @property integer $id
 * @property string $name
 * @property string $path
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property Section[] $sections
 * @property Video[] $videos
 */
class Image extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'path'], 'required'],
            [['created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['name', 'path'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['path'], 'unique'],
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
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSections()
    {
        return $this->hasMany(Section::className(), ['image_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVideos()
    {
        return $this->hasMany(Video::className(), ['image_id' => 'id']);
    }

    public static function getImageParentFolderPath()
    {
        return Yii::getAlias('@backend/web/');
    }

    public static function getImagesParentFolderLink()
    {
        return Yii::$app->request->hostInfo.'/backend/web/';
    }


    /**
     * @param $file \yii\web\UploadedFile
     * @param $folder string
     * @param null $id int
     *
     * @return Image|null
     */
    public static function upload($file, $folder, $id=null)
    {

        $imageName = time().uniqid('', false);

        $path = self::getImageParentFolderPath();

        $directory = $path.$folder;
        FileHelper::createDirectory($directory, 0775, $recursive = true);
        $file->saveAs("$directory/$imageName." . $file->extension);

        if(!$id) {
            $modelImage = new Image();
        } else {
            $modelImage = self::findOne($id);
            if(file_exists($path."$modelImage->path")) {
                try {
                    unlink($path . "$modelImage->path");
                } catch (Exception $exception) {
                    //log
                }
            }
        }

        $modelImage->name = $imageName;
        $modelImage->path = $folder."/$imageName.".$file->extension;

        if($modelImage->save()) {
            return $modelImage;
        }

        return null;
    }
}
