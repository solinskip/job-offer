<?

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\GuardianProfile;

/**
 * app\models\search\GuardianProfileSearch represents the model behind the search form about `app\models\GuardianProfile`.
 */
 class GuardianProfileSearch extends GuardianProfile
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_user', 'phone'], 'integer'],
            [['name', 'email'], 'safe'],
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
        $query = GuardianProfile::find();

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
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
