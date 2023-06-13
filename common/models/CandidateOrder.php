<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * CandidateOrder model
 *
 * @property integer $id
 * @property int $candidate_id
 * @property int $course_id
 * @property int $direction_id
 * @property int $status
 * @property int $approved_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Candidate $candidate
 * @property InternshipDirection $direction
 */
class CandidateOrder extends ActiveRecord
{
    const STATUS_PENDING = 0;
    const STATUS_SUCCESS = 1;
    const STATUS_CANCEL = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%candidate_order}}';
    }

    public static function statuses()
    {
        return [
            self::STATUS_PENDING => Yii::t('common', 'Pending'),
            self::STATUS_SUCCESS => Yii::t('common', 'Success'),
            self::STATUS_CANCEL => Yii::t('common', 'Cancel'),
        ];
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => date('Y-m-d H:i:s'),
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['candidate_id', 'course_id', 'approved_by', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'candidate_id' => Yii::t('common', 'Candidate ID'),
            'direction_id' => Yii::t('common', 'Direction ID'),
            'approved_by' => Yii::t('common', 'Approved by'),
            'status' => Yii::t('common', 'Status'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getCandidate(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'candidate_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getDirection(): ActiveQuery
    {
        return $this->hasOne(InternshipDirection::class, ['id' => 'direction_id']);
    }
}
