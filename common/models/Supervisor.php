<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Supervisor model
 *
 * @property integer $id
 * @property int $user_id
 * @property int $direction_id
 * @property string $position
 * @property integer $is_deleted
 *
 * @property User $user
 * @property InternshipDirection $direction
 */
class Supervisor extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%supervisor}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'direction_id', 'is_deleted'], 'integer'],
            ['position', 'string', 'max' => 255]
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
            'position' => Yii::t('common', 'Position'),
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
    public function getDirection(): ActiveQuery
    {
        return $this->hasOne(InternshipDirection::class, ['id' => 'direction_id']);
    }
}
