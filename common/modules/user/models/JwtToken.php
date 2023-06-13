<?php

namespace common\modules\user\models;

use Yii;
use yii\helpers\Url;

/**
 * Login form
 */
class JwtToken
{

    public static function getToken($data, $expires, $base = null)
    {
        $jwt = Yii::$app->jwt;
        $signer = $jwt->getSigner('HS256');
        $key = $jwt->getKey();
        $time = time();
        $tokenId = base64_encode(random_bytes(32));
        if($base === null) {
            $base = env('API_HOST_INFO');
        }

        $data['expires'] = $expires;

        $token = $jwt->getBuilder()
            ->issuedBy($base)// Configures the issuer (iss claim)
            ->permittedFor($base)// Configures the audience (aud claim)
            ->identifiedBy($tokenId, true)// Configures the id (jti claim), replicating as a header item
            ->issuedAt($time)// Configures the time that the token was issue (iat claim)
            ->expiresAt($expires)// Configures the expiration time of the token (exp claim)
            ->withClaim('uid', $data)// Configures a new claim, called "uid"
            ->getToken($signer, $key); // Retrieves the generated token

        return (string)$token;
    }
}
