<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * OrganizationMember model
 *
 * @property integer $id
 * @property int $user_id
 * @property int $organization_id
 * @property string $position
 * @property bool $is_deleted
 *
 * @property User $user
 * @property Organization $organization
 */
class OrganizationMember extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%organization_member}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'organization_id'], 'required'],
            [['user_id', 'organization_id', 'is_deleted'], 'integer'],
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
    public function getOrganization(): ActiveQuery
    {
        return $this->hasOne(Organization::class, ['id' => 'organization_id']);
    }
}
