<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "country".
 *
 * @property int $id
 * @property int $code
 * @property string $title
 * @property string $continent
 * @property string $code_three
 *
 * @property CountryStat[] $countryStats
 * @property UserProfile[] $userProfiles
 */
class Country extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'country';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'continent'], 'required'],
            [['title', 'continent'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'code' => Yii::t('app', 'Code'),
            'code_three' => Yii::t('app', 'Alpha-3 Code'),
            'title' => Yii::t('app', 'Title'),
            'continent' => Yii::t('app', 'Continent'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountryStats()
    {
        return $this->hasMany(CountryStat::className(), ['country_id' => 'code']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserProfiles()
    {
        return $this->hasMany(UserProfile::className(), ['country_id' => 'code']);
    }
	
     /**
     * Find country by it ISO code
     *
     * @param string $code
     * @return Country
     */
	public static function findByCode($code)
	{
		return self::find()
			->where(['code' => $code])
			->one();
	}
	
	public static function getDefault()
	{
		if( ! empty($_SERVER['GEOIP_COUNTRY_CODE'])) {
			$country = self::findByCode($_SERVER['GEOIP_COUNTRY_CODE']);
		}
		else {
			$countryCode = explode('-', Yii::$app->language)[1];
			$country = self::findByCode($countryCode);
		}
		return $country;
	}
}
