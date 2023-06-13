<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Mentor model
 *
 * @property integer $id
 * @property integer $organization_id
 * @property string $title
 * @property string $address
 * @property double $geo_lan
 * @property double $geo_lon
 * @property integer $status
 * @property integer $created_by
 * @property string $created_at
 * @property string $updated_at
 * @property int $direction_id
 * @property int $intern_id
 * @property int $mentor_id
 * @property int $income
 * @property string $description
 * @property string $schedule
 * @property int $is_publish
 * @property int $is_deleted
 *
 * @property Organization $organization
 */
class Vacancy extends ActiveRecord
{
    const STATUS_PENDING = 0;
    const STATUS_SUCCESS = 1;
    const STATUS_CANCEL = 2;
    const STATUS_CLOSED = 3;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%vacancy}}';
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
            [['organization_id', 'status'], 'required'],
            [['organization_id', 'status', 'created_by', 'direction_id',
                'mentor_id', 'intern_id', 'income', 'is_publish', 'is_deleted'], 'integer'],
            [['title', 'description', 'address'], 'string', 'max' => 255],
            [['created_at', 'updated_at'], 'safe'],
            ['schedule', 'string'],
            [['geo_lat', 'geo_lon'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('common', 'User ID'),
            'organization_id' => Yii::t('common', 'Organization ID'),
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

    /**
     * @return ActiveQuery
     */
    public function getOrganization(): ActiveQuery
    {
        return $this->hasOne(Organization::class, ['id' => 'organization_id']);
    }
}
