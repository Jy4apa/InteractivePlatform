<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * User model
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $logo
 * @property string $address
 * @property string $location
 */
class Organization extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%organization}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'location', 'logo', 'address'], 'string', 'max' => 255],
            ['description', 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title' => Yii::t('common', 'Title'),
            'description' => Yii::t('common', 'Description'),
            'logo' => Yii::t('common', 'Logo'),
            'address' => Yii::t('common', 'Address'),
            'location' => Yii::t('common', 'Location'),
        ];
    }
}
