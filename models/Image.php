<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;
use yii\helpers\BaseFileHelper;
use yii\imagine\BaseImage;

/**
 * This is the model class for table "image".
 *
 * @property integer $id
 * @property string $path
 * @property integer $angle
 * @property integer $iduser
 */
class Image extends \yii\db\ActiveRecord
{
    public $fileUpload;
    
    /**
     * returns current tablename 
     */
    public static function tableName()
    {
        return 'image';
    }

    /**
     * validating rules
     */
    public function rules()
    {
        return [
            [['fileUpload'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
            [['angle'], 'integer']
        ];
    }

    /**
     * uploading a picture
     */
    public function upload() {
        if($this->validate()) {
            $this->iduser = Yii::$app->user->getId();
            $this->path =  $this->fileUpload->baseName . '.' . $this->fileUpload->extension;
            $this->save();
            $path = 'uploads/' . $this->fileUpload->baseName . '.' . $this->fileUpload->extension;
            $this->fileUpload->saveAs($path);
            $newImage = BaseImage::watermark($path, "image/wm.png");
            $newImage->save($path);
            return true;
        }
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fileUpload' => 'Select File',
            'angle' => 'Angle',
        ];
    }

    /**
     * gets and returns all images of the current user
     * @return set of paths
     */
    static public function getImages() {
        return static::find(['path'])->where(['iduser' => Yii::$app->user->getId()])->all();
    }

    /**
     * get Image with the id specifed
     * @param  integer $id - the image id
     * @return ActiveRecord containing info about the image
     */
    static public function getImage($id) {
        return static::findOne(['id' => $id]);
    }

    /**
     * gets current angle of the image
     * @param  integer $id - image id
     * @return angle retrieved from the db
     */
    static public function getAngle($id) {
        return static::getImage($id)->angle;
    }

    /**
     * checks and returns the image angle.
     * @param  $angle current angle
     * @return 0 if angle is null or is < 0 or is > 360, otherwise returns new angle
     */
    static public function checkAngle($angle) {
        if($angle >= 360 || $angle < 0) {
            return 0;
        }
        return $angle;
    }

    /**
     * updates angle of the image specifed
     * @param $id image id
     * @return false is the user doesn't own the image or if the image not found, otherwise returns updated angle
     */
    static public function setAngle($id) {
        if(!is_numeric($id) || $id < 1)
            return false;
        
        //if the image exists and the user really owns it
        $im = static::getImage($id);
        if($im && ($im->iduser == Yii::$app->user->getId())) {
            $angle = static::getAngle($id);
            $angle = static::checkAngle($angle + 20);
            $image = self::getImage($id);
            $image->angle = $angle;
            $image->update(false); //since we want to update only one field, we don't need validation here
            return $angle;
        }

        return false;
    }

    /**
     * deletes image from db and from the uploads folder
     * @param  id the image id
     * @return true if such image exists or false if it doesn't
     */
    static public function deleteImage($id) {
        if(static::find(['path'])->where(['iduser' => Yii::$app->user->getId(), 'id' => $id])->all()) {
            $path = static::findOne(['id' => $id])->path;
            static::deleteAll(['id' => $id]);
            unlink('uploads/' . $path);
            return true;
        }
        return false;
    }
}
