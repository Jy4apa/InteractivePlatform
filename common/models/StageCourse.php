<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * StageCourse model
 *
 * @property integer $id
 * @property string $title
 * @property int $course_id
 * @property string $date_end
 * @property int $count
 */
class StageCourse extends ActiveRecord
{

    const STAGE_START = 0;
    const STAGE_CAREER_SCHOOL = 1;
    const STAGE_TESTING = 2;
    const STAGE_CHAMPIONSHIP = 3;
    const STAGE_INTERNSHIP = 4;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%stage_course}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['title', 'string', 'max' => 255],
            ['course_id', 'integer'],
            ['count', 'integer', 'min' => 0],
            [['date_end'], 'safe'],
        ];
    }

    public static function stages()
    {
        return [
            self::STAGE_START => 'Подача заявки',
            self::STAGE_CAREER_SCHOOL => 'Карьерная школа',
            self::STAGE_TESTING => 'Тестирование',
            self::STAGE_CHAMPIONSHIP => 'Кейс-чемпионат',
            self::STAGE_INTERNSHIP => 'Стажировка',
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'date_end' => Yii::t('common', 'Date end'),
            'status' => Yii::t('common', 'Status')
        ];
    }
}
