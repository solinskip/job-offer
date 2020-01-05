<?

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\InternshipDiary;

/**
 * app\models\search\InternshipDiarySearch represents the model behind the search form about `app\models\InternshipDiary`.
 */
class InternshipDiarySearch extends InternshipDiary
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_internship', 'working_hours'], 'integer'],
            [['date', 'description'], 'safe'],
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
        $query = InternshipDiary::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'id_internship' => $this->id_internship,
            'date' => $this->date,
            'working_hours' => $this->working_hours,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}