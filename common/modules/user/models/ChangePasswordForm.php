<?php

namespace common\modules\user\models;

use common\models\User;
use Yii;
use yii\base\Model;

/**
 * Account form
 */
class ChangePasswordForm extends Model
{
    /**
     * @var User
     */
    private $user;
    public $password;
    public $password_confirm;

    /**
     * @param $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['password', 'string', 'length' => [8, 999]],
            [['password', 'password_confirm'], 'required'],
            ['password_confirm', 'compare', 'compareAttribute' => 'password', 'skipOnEmpty' => false],

        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'password' => Yii::t('app', 'Password'),
            'password_confirm' => Yii::t('app', 'Confirm Password'),
        ];
    }

    /**
     * @return bool
     */
    public function save()
    {
        if ($this->password) {
            $this->user->setPassword($this->password);
        }
        return $this->user->save();
    }
}
