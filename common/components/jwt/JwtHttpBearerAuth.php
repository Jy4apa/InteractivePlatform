<?php

namespace common\components\jwt;

class JwtHttpBearerAuth extends \sizeg\jwt\JwtHttpBearerAuth
{

    /**
     * @inheritdoc
     */
    public function authenticate($user, $request, $response)
    {
		try {
			return parent::authenticate($user, $request, $response);
		}
		catch(\Exception $e) {
			if($e instanceof \yii\web\HttpException)
				throw $e;
			else
				throw new \yii\web\UnauthorizedHttpException();
		}
    }
} 