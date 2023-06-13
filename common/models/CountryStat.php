<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "country_stat".
 *
 * @property int $user_id
 * @property int $country_id
 * @property int $count
 * @property string $updated_at
 *
 * @property Country $country
 */
class CountryStat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'country_stat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'country_id', 'count', 'updated_at'], 'required'],
            [['user_id', 'country_id', 'count'], 'integer'],
            [['updated_at'], 'safe'],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country_id' => 'code']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('app', 'User ID'),
            'country_id' => Yii::t('app', 'Country ID'),
            'count' => Yii::t('app', 'Count'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['code' => 'country_id']);
    }
}
