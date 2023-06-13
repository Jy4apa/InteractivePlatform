<?php

namespace common\components\jwt;

class JwtValidationData extends \sizeg\jwt\JwtValidationData
{
 
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->validationData->setIssuer(env('API_HOST_INFO'));
        $this->validationData->setAudience(env('API_HOST_INFO'));

        parent::init();
    }
} 