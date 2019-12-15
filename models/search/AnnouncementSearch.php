<?

namespace app\models\search;

use app\models\Announcement;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

/**
 * app\models\search\AnnouncementSearch represents the model behind the search form about `app\models\Announcement`.
 */
class AnnouncementSearch extends Announcement
{
    public $fromSalary;
    public $toSalary;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'salary', 'active', 'created_by'], 'integer'],
            [['name', 'place', 'position', 'responsibilities', 'description', 'created_at', 'fromSalary', 'toSalary'], 'safe'],
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
        $query = Announcement::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'salary' => $this->salary,
            'active' => $this->active,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
        ]);
        // if user don't set 'fromSalary' attribute, set is min value from database
        // if user don't set 'toSalary" attribute, set is max value from database
        $fromSalary = empty($this->fromSalary) && !empty($this->toSalary) ? new Expression(Announcement::find()->min('salary')) : $this->fromSalary;
        $toSalary = empty($this->toSalary)  && !empty($this->fromSalary)? new Expression(Announcement::find()->max('salary')) : $this->toSalary;

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'place', $this->place])
            ->andFilterWhere(['like', 'position', $this->position])
            ->andFilterWhere(['like', 'responsibilities', $this->responsibilities])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['between', 'salary', $fromSalary, $toSalary]);

        return $dataProvider;
    }
}