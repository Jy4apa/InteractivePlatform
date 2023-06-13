<?php

namespace common\modules\user\models;

use cheatsheet\Time;
use common\commands\SendEmailCommand;
use common\models\User;
use common\models\UserToken;
use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\helpers\Url;

/**
 * Activation form
 */
class ActivationForm extends Model
{

    protected $user = null;

    public function __construct($user)
    {
        if($user->status == User::STATUS_NOT_ACTIVE || ! $user->verification_status)
            $this->user = $user;
    }

    /**
     * Activate user email.
     *
     * @return UserToken|null the saved model or null if saving fails
     * @throws Exception
     */
    public function activate()
    {
        if( ! $this->user)
            return null;

        $token = UserToken::create(
            $this->user->id,
            UserToken::TYPE_ACTIVATION,
            Time::SECONDS_IN_A_DAY
        );
        Yii::$app->commandBus->handle(new SendEmailCommand([
            'subject' => 'Activation email',
            'layout' => 'layouts/empty',
            'view' => 'activation',
            'to' => $this->user->email,
            'params' => [
                'url' => Url::to(env('FRONTEND_URL') . 'usercenter/user/activate?token=' . $token->token, true),
                'user' => $this->user
            ]
        ]));
        return $token;
    }
}
