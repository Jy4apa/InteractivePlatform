<?php

namespace common\models\search;

use api\modules\member\models\Vacancy;
use common\models\User;
use common\models\UserProfile;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class VacancySearch extends Vacancy
{
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function rules()
    {
        return [
            [['organization_id', 'status', 'created_by', 'direction_id',
                'mentor_id', 'intern_id', 'income', 'is_publish', 'is_deleted'], 'integer'],
            [['title', 'description', 'address'], 'string', 'max' => 255],
            [['created_at', 'updated_at'], 'safe'],
            ['schedule', 'string'],
            [['geo_lat', 'geo_lon'], 'number']
        ];
    }

    /**
     * Creates data provider instance with search query applied
     * @return ActiveDataProvider
     */
    public function search($params, $user_id)
    {
        $query = Vacancy::find();
        $user = User::findOne($user_id);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params, '') && $this->validate())) {
            return $dataProvider;
        }

        if ($this->direction_id)
            $query->andFilterWhere(['direction_id' => $this->direction_id]);

        if ($this->title)
            $query->andFilterWhere(['like', 'title', $this->title]);

        if ($user->userProfile->role != UserProfile::ROLE_SUPERVISOR)
            $query->andFilterWhere(['is_publish' => 1]);

        return $dataProvider;
    }
}
