<?php

namespace app\controllers;

use Yii;
use app\models\Image;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
 * ImageController implements the CRUD actions for Image model.
 */
class ImageController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Displays a form for uploading files and shows images uploaded
     */
    public function actionIndex()
    {
        $model = new Image();

        if (Yii::$app->request->isPost) {
            $model->fileUpload = UploadedFile::getInstance($model, 'fileUpload');
            $model->upload();
        }

        $allimages = Image::getImages();
        return $this->render('index', [
            'model' => $model,
            'images' => $allimages,
        ]);
        
    }

    /**
     * Rotates an image
     * @param  integer $id is id of the picture
     * returns false if id is not numeric or there is no picture with such id at the user's account, or string with current picture position 
     */
    public function actionRotate($id) {
        if(!is_numeric($id))
            return false;
        echo Image::setAngle($id);
    }

    /**
     * deletes the image
     * @param  integer $id the image id
     */
    public function actionRemove($id) {
        if(!is_numeric($id))
            return false;
        if(Image::deleteImage($id))
            echo 'success';
    }
}
