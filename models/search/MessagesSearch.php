<?

namespace app\models\search;

use app\models\Messages;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * app\models\search\MessagesController represents the model behind the search form about `app\models\Messages`.
 */
class MessagesSearch extends Messages
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_user_from', 'id_user_to', 'id_announcement', 'isRead', 'internshipRequest'], 'integer'],
            [['message', 'created_at'], 'safe'],
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
        $query = Messages::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        if (Yii::$app->controller->action->id === 'employee-index') {
            $dataProvider->sort->defaultOrder = ['created_at' => SORT_DESC];
        } elseif (Yii::$app->controller->action->id === 'employer-index') {
            $dataProvider->sort->defaultOrder = ['isRead' => SORT_DESC];
        }

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'id_user_from' => $this->id_user_from,
            'id_user_to' => $this->id_user_to,
            'id_announcement' => $this->id_announcement,
            'isRead' => $this->isRead,
            'internshipRequest' => $this->internshipRequest,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'message', $this->message]);

        return $dataProvider;
    }
}
