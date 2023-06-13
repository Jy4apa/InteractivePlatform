<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Candidate model
 *
 * @property integer $id
 * @property int $user_id
 * @property int $order_status
 * @property int $testing_status
 * @property int $is_recommended
 * @property int $is_deleted
 *
 * @property User $user
 */
class Candidate extends ActiveRecord
{

    public int $cnt = 0;
    const NOT_RECOMMENDED = 0;
    const RECOMMENDED = 1;


    const TESTING_STATUS_NONE = 0;
    const TESTING_STATUS_SUCCESS = 1;
    const TESTING_STATUS_FAILED = 2;
    const TESTING_STATUS_IN_PROGRESS = 3;
    const TESTING_STATUS_PENDING = 4;


    const ORDER_STATUS_START = 0;
    const ORDER_STATUS_CAREER_SCHOOL = 1;
    const ORDER_STATUS_TESTING = 2;
    const ORDER_STATUS_CHAMPIONSHIP = 3;
    const ORDER_STATUS_INTERNSHIP = 4;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%candidate}}';
    }

    public static function testingStatuses(): array
    {
        return [
            self::TESTING_STATUS_NONE => 'Не пройдено',
            self::TESTING_STATUS_SUCCESS => 'Успешно',
            self::TESTING_STATUS_FAILED => 'Провалено',
            self::TESTING_STATUS_IN_PROGRESS => 'В процессе',
            self::TESTING_STATUS_PENDING => 'Ожидает результатов тестирования',
        ];
    }

    public static function orderStatuses(): array
    {
        return [
            self::ORDER_STATUS_START => 'Подача заявки',
            self::ORDER_STATUS_CAREER_SCHOOL => 'Карьерная школа',
            self::ORDER_STATUS_TESTING => 'Тестирование',
            self::ORDER_STATUS_CHAMPIONSHIP => 'Кейс-чемпионат',
            self::ORDER_STATUS_INTERNSHIP => 'Стажировка',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'is_recommended', 'testing_status', 'order_status', 'is_deleted'], 'integer'],
            ['testing_status', 'default', 'value' => self::TESTING_STATUS_NONE]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('common', 'User ID'),
            'education' => Yii::t('common', 'Education'),
            'experience' => Yii::t('common', 'Experience'),
            'is_recommended' => Yii::t('common', 'Recommended'),
            'testing_status' => Yii::t('common', 'Testing status'),
            'is_deleted' => Yii::t('common', 'Deleted'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
