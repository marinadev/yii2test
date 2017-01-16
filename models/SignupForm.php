<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

/**
 * SignupForm is the model behind the register form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class SignupForm extends ActiveRecord
{

    private $_user = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password_hash'], 'required'],
            [['username'], 'string', 'min' => 3, 'max' => 255],
            [['username'], 'trim'],
            [['username'], 'unique'],
            // password is validated by validatePassword()
        ];
    }

    /**
     * Registers a new user, but doesn't log him in
     */
    public function register()
    {
        if ($this->validate()) {
            $this->password_hash = Yii::$app->getSecurity()->generatePasswordHash($this->password_hash);
            $this->save();
            return true;
        }
    }

    
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password_hash' => 'Password',
        ];
    }
}
