<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Mentor model
 *
 * @property integer $id
 * @property int $user_id
 * @property int $organization_id
 * @property int $organization_member_id
 * @property double $rating
 * @property int $is_deleted
 *
 * @property User $user
 * @property Organization $organization
 * @property Vacancy $vacancy
 */
class Mentor extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mentor}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'organization_id', 'organization_member_id', 'is_deleted'], 'integer'],
            ['rating', 'number', 'max' => 5]
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
            'organization_member_id' => Yii::t('common', 'Organization member ID'),
            'rating' => Yii::t('common', 'Rating'),
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

    /**
     * @return ActiveQuery
     */
    public function getVacancy(): ActiveQuery
    {
        return $this->hasOne(Vacancy::class, ['id' => 'mentor_id']);
    }
}
