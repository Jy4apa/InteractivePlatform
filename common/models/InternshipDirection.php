<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * User model
 *
 * @property integer $id
 * @property int $supervisor_id
 * @property string $title
 * @property string $slogan
 * @property string $description
 * @property string $internship_places
 * @property string $is_deleted
 */
class InternshipDirection extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%internship_direction}}';
    }

    public function beforeValidate() {
        $this->internship_places = serialize($this->internship_places);
        return parent::beforeValidate();
    }

    public function afterFind() {
        $this->internship_places = unserialize($this->internship_places);
        return parent::afterFind();
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['supervisor_id', 'is_deleted'], 'integer'],
            [['title', 'slogan'], 'string', 'max' => 255],
            [['description', 'internship_places'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'supervisor_id' => Yii::t('common', 'Supervisor ID'),
            'title' => Yii::t('common', 'Title'),
            'slogan' => Yii::t('common', 'Slogan'),
            'description' => Yii::t('common', 'Description'),
            'internship_places' => Yii::t('common', 'Internship places'),
            'is_deleted' => Yii::t('common', 'Deleted')
        ];
    }

    public static function getSkills($id)
    {
        return Specialization::find()->select('id')->where(['direction_id' => $id])->asArray()->column();
    }
}
