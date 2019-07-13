<?php

namespace rp\users\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\users\models\LoginHistory;

/**
 * LoginHistorySearch represents the model behind the search form about `app\modules\users\models\LoginHistory`.
 */
class LoginHistorySearch extends LoginHistory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'logintime', 'logouttime'], 'integer'],
            [['username', 'sessionid'], 'safe'],
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
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = LoginHistory::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'logintime' => $this->logintime,
            'logouttime' => $this->logouttime,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'sessionid', $this->sessionid]);

        return $dataProvider;
    }
}
