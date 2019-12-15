<?

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EmployeeProfile;

/**
 * app\models\search\EmployeeSearch represents the model behind the search form about `app\models\EmployeeProfile`.
 */
class EmployeeProfileSearch extends EmployeeProfile
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_user', 'phone'], 'integer'],
            [['name', 'surname', 'email', 'education', 'birth_date', 'courses', 'experience', 'information'], 'safe'],
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
        $query = EmployeeProfile::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith('user');

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'id_user' => $this->id_user,
            'birth_date' => $this->birth_date,
            'phone' => $this->phone,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'surname', $this->surname])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'education', $this->education])
            ->andFilterWhere(['like', 'courses', $this->courses])
            ->andFilterWhere(['like', 'experience', $this->experience])
            ->andFilterWhere(['like', 'information', $this->information]);

        return $dataProvider;
    }
}