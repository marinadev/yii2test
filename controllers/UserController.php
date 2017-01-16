<?php

namespace app\controllers;
use Yii;
use yii\filters\AccessControl;
use app\models\LoginForm;
use app\models\SignupForm;

class UserController extends \yii\web\Controller
{

	public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'signup'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout', 'index'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * redirects either to login page or to user's image library
     */
    public function actionIndex()
    {
        return $this->redirect(['image/index']);
    }

    /**
     * Login action.
     *
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
            'newreg' => Yii::$app->request->get('l'),
        ]);
    }

    /**
     * Logout action.
     *
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * signup action
     */
    public function actionSignup()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->register()) {
            return $this->redirect(['login', 'l' => 'newreg']);
        }
        return $this->render('signup', [
            'model' => $model,
        ]);
    }

}
