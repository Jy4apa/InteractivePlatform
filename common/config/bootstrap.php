<?php
/**
 * Require core files
 */
require_once __DIR__ . '/../helpers.php';

/**
 * Setting path aliases
 */
Yii::setAlias('@base', dirname(__DIR__, 2) . '/');
Yii::setAlias('@common', dirname(__DIR__, 2) . '/common');
Yii::setAlias('@api', dirname(__DIR__, 2) . '/api');
Yii::setAlias('@backend', dirname(__DIR__, 2) . '/backend');
Yii::setAlias('@console', dirname(__DIR__, 2) . '/console');
Yii::setAlias('@storage', dirname(__DIR__, 2) . '/storage');
Yii::setAlias('@public', dirname(__DIR__, 2) . '/public');
Yii::setAlias('@tests', dirname(__DIR__, 2) . '/tests');

/**
 * Setting url aliases
 */
Yii::setAlias('@apiUrl', env('API_HOST_INFO') . env('API_BASE_URL'));
Yii::setAlias('@publicUrl', env('PUBLIC_HOST_INFO') . env('PUBLIC_BASE_URL'));
Yii::setAlias('@backendUrl', env('BACKEND_HOST_INFO') . env('BACKEND_BASE_URL'));
Yii::setAlias('@storageUrl', env('STORAGE_HOST_INFO') . env('STORAGE_BASE_URL'));



