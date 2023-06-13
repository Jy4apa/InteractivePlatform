<?php

namespace backend\models\search;

use common\models\OrganizationMember;
use common\models\User;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * OrganizationMemberSearch represents the model behind the search form about `common\models\OrganizationMember`.
 */
class OrganizationMemberSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = OrganizationMember::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        return $dataProvider;
    }
}
