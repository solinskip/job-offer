<?

namespace app\models\search;

use app\models\Internship;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * app\models\InternshipSearch represents the model behind the search form about `app\models\Internship`.
 */
class InternshipSearch extends Internship
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_employee', 'id_employer', 'id_guardian', 'id_announcement', 'id_messages', 'accepted'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
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
        $query = Internship::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->joinWith(['announcement', 'employer epr', 'employee epe']);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'id_employee' => $this->id_employee,
            'id_employer' => $this->id_employer,
            'id_guardian' => $this->id_guardian,
            'id_announcement' => $this->id_announcement,
            'id_messages' => $this->id_messages,
            'accepted' => $this->accepted,
        ]);

        return $dataProvider;
    }
}