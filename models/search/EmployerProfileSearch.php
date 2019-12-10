<?

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EmployerProfile;

/**
 * app\models\search\EmployerSearch represents the model behind the search form about `app\models\EmployerProfile`.
 */
 class EmployerProfileSearch extends EmployerProfile
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_user', 'phone', 'fax'], 'integer'],
            [['name', 'address', 'industry', 'email', 'information'], 'safe'],
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
        $query = EmployerProfile::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'id_user' => $this->id_user,
            'phone' => $this->phone,
            'fax' => $this->fax,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'industry', $this->industry])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'information', $this->information]);

        return $dataProvider;
    }
}
