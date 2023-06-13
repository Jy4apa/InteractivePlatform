<?php

namespace common\models;

use trntv\filekit\behaviors\UploadBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user_profile".
 *
 * @property integer $user_id
 * @property integer $locale
 * @property string $firstname
 * @property string $middlename
 * @property string $lastname
 * @property string $position
 * @property string $avatar
 * @property integer $gender
 * @property string $age
 * @property string $city
 * @property string $full_address
 * @property string $phone
 * @property integer $country_id
 * @property int $role
 * @property int $scores
 *
 * @property User $user
 */
class UserProfile extends ActiveRecord
{
    protected $_oldAttributes;

    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;

    const ROLE_CANDIDATE = 0;
    const ROLE_INTERN = 1;
    const ROLE_SUPERVISOR = 2;
    const ROLE_MENTOR = 3;
    const ROLE_ORGANIZATION_MEMBER = 4;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_profile}}';
    }

    public static function roles()
    {
        return [
            self::ROLE_CANDIDATE => Yii::t('common', 'Candidate'),
            self::ROLE_INTERN => Yii::t('common', 'Intern'),
            self::ROLE_SUPERVISOR => Yii::t('common', 'Supervisor'),
            self::ROLE_MENTOR => Yii::t('common', 'Mentor'),
            self::ROLE_ORGANIZATION_MEMBER => Yii::t('common', 'Organization member'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'gender', 'role', 'country_id'], 'integer'],
            ['scores', 'integer', 'min' => 0],
            ['age', 'safe'],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country_id' => 'id']],
            [['gender'], 'in', 'range' => [NULL, self::GENDER_FEMALE, self::GENDER_MALE]],
            [['firstname', 'middlename', 'lastname', 'city', 'phone', 'avatar', 'full_address'], 'string', 'max' => 255],
            ['locale', 'default', 'value' => 'ru-RU'],
            ['locale', 'in', 'range' => array_keys(Yii::$app->params['availableLocales'])],
            ['phone', 'match', 'pattern' => '/^[+][0-9]{5,15}$/', 'skipOnEmpty' => true, 'message' => 'Формат номера телефона должен начинаться с + и содержать от 5 до 15 символов'],

            ['role', function ($attribute, $params) {
                if ($this->_oldAttributes['role'] != $this->$attribute &&
                    $this->_oldAttributes['role'] == self::ROLE_CANDIDATE) {
                    $candidate = Candidate::find()->where(['user_id' => $this->user_id])->limit(1)->one();
                    if ($candidate)
                    {
                        $candidate->is_deleted = 1;
                        $candidate->save();
                    }
                }
            }]
        ];
    }

    public function afterFind()
    {
        $this->_oldAttributes = $this->attributes;
        return parent::afterFind();
    }

    public function afterSave($insert, $changedAttributes)
    {
        $candidate = Candidate::find()->where(['user_id' => $this->user_id])->limit(1)->one();
        if ($candidate)
            self::checkCandidateRecommended($this->user_id);
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() // TODO
    {
        return [
            'user_id' => Yii::t('common', 'User ID'),
            'firstname' => Yii::t('common', 'Firstname'),
            'middlename' => Yii::t('common', 'Middlename'),
            'lastname' => Yii::t('common', 'Lastname'),
            'locale' => Yii::t('common', 'Locale'),
            'gender' => Yii::t('common', 'Gender'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return null|string
     */
    public function getFullName()
    {
        if ($this->firstname || $this->lastname) {
            return implode(' ', [$this->firstname, $this->lastname]);
        }
        return null;
    }

    /**
     * @param null $default
     * @return bool|null|string
     */
    public function getAvatar($default = null)
    {
        return $default;
    }

    public static function checkCandidateRecommended($user_id)
    {
        $user = User::findOne($user_id);

        $candidate = Candidate::find()->where(['user_id' => $user_id])->limit(1)->one();
        if ($candidate)
        {
            $candidateOrder = CandidateOrder::find()->where(['candidate_id' => $candidate->id])
                ->orderBy('id DESC')->limit(1)->one();
            // Проверка возраста
            if ($user->userProfile->age)
            {
                $age = intdiv(time() - (strtotime($user->userProfile->age)), 31536000);
                $checkAge = $age <= 35 && $age >= 18;
            }
            else return 'Неподходящий возраст';

            // Проверка гражданства
            $checkCitizenship = $user->userProfile->country_id === 192;
            if ($checkCitizenship === false)
                return 'Отсутствие Российского гражданства';

            // Проверка образования
            $educations = Education::find()->where(['user_id' => $user->id])->all();
            $checkEducation = false;
            $highLevel = Education::highLevel();
            foreach ($educations as $education)
            {
                $checkEducation = $education->date_end - date('Y') <= 1 && in_array($education->level, $highLevel);
                if ($checkEducation === true)
                    break;
            }
            if ($checkEducation === false)
                return 'Наличие высшего образования или последний год учебы';

            // Проверка опыта работы
            $experiences = Experience::find()->where(['user_id' => $user->id])->all();
            $checkExperience = false;
            foreach ($experiences as $experience)
            {
                $specializationsArray = InternshipDirection::getSkills($candidateOrder->direction_id);
                $keys = gettype($experience->key_skills) == 'array' ? $experience->key_skills : unserialize($experience->key_skills);
                foreach ($keys as $key)
                    if (in_array($key, $specializationsArray))
                    {
                        $checkExperience = true;
                        break;
                    }
                if ($checkExperience === true)
                    break;
            }
            if ($checkExperience === false)
                return 'Отсутствие опыта работы или нерелевантный опыт работы';
            $recommended = $checkAge && $checkCitizenship && $checkExperience && $checkEducation;
            if ($recommended === true)
            {
                $candidate->is_recommended = 1;
                $candidate->save();
                return true;
            }
            else $candidate->is_recommended = 0;
            $candidate->save();
            return false;
        }
    }
}
