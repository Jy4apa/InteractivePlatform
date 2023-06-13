<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Education model
 *
 * @property integer $id
 * @property int $date_start
 * @property int $date_end
 * @property int $user_id
 * @property int $level
 * @property string $name
 * @property string $address
 * @property string $city
 * @property string $speciality
 */
class Education extends ActiveRecord
{

    const LEVEL_HIGH = 0;
    const LEVEL_BACHELOR = 1;
    const LEVEL_MAGISTRACY = 2;
    const LEVEL_DOCTOR = 3;
    const LEVEL_CANDIDATE = 4;
    const LEVEL_MVA = 5;
    const LEVEL_AVERAGE_GENERAL = 6;
    const LEVEL_AVERAGE_PROFESSIONAL = 7;
    const LEVEL_OTHER = 8;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%education}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'level', 'date_start', 'date_end'], 'integer'],
            [['name', 'address', 'city', 'speciality'], 'string', 'max' => 255],
        ];
    }

    public static function levels()
    {
        return [
            self::LEVEL_HIGH => 'Среднее',
            self::LEVEL_BACHELOR => 'Высшее - бакалавриат',
            self::LEVEL_MAGISTRACY => 'Высшее - магистратура',
            self::LEVEL_DOCTOR => 'Доктор наук',
            self::LEVEL_CANDIDATE => 'Кандидат наук',
            self::LEVEL_MVA => 'Мва',
            self::LEVEL_AVERAGE_GENERAL => 'Среднее общее',
            self::LEVEL_AVERAGE_PROFESSIONAL => 'Среднее профессиональное',
            self::LEVEL_OTHER => 'Прочее',
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'date_start' => Yii::t('common', 'Date start'),
            'date_end' => Yii::t('common', 'Date end'),
        ];
    }

    public static function highLevel()
    {
        return [self::LEVEL_HIGH, self::LEVEL_BACHELOR, self::LEVEL_MAGISTRACY,
            self::LEVEL_DOCTOR, self::LEVEL_CANDIDATE, self::LEVEL_MVA];
    }
}
