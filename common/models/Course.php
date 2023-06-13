<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Course model
 *
 * @property integer $id
 * @property string $title
 * @property string $date_start
 * @property string $date_end
 * @property int $status
 */
class Course extends ActiveRecord
{

    const STATUS_NOT_ACTIVE = 0;
    const STATUS_ACTIVE = 1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%course}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['title', 'string', 'max' => 255],
            ['status', 'integer'],
            [['date_start', 'date_end'], 'safe'],
        ];
    }

    public static function statuses()
    {
        return [
            self::STATUS_NOT_ACTIVE => 'Не активен',
            self::STATUS_ACTIVE => 'Активен',
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
            'status' => Yii::t('common', 'Status')
        ];
    }

    public static function getActiveCourse()
    {
        return self::find()->where(['status' => self::STATUS_ACTIVE])->orderBy('date_start DESC')->one();
    }

    public static function getLast()
    {
        return self::find()->orderBy('id DESC')->one();
    }

    public static function getList()
    {
        $courses = self::find()->select(['id', 'title'])->all();
        $data = [];
        foreach ($courses as $course)
            $data[] = [
                $course->id => $course->title
            ];
        return $data;
    }
}
