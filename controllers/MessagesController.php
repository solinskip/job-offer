<?

namespace app\controllers;

use app\models\Messages;
use app\models\search\MessagesSearch;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * MessagesController implements the CRUD actions for Messages model.
 */
class MessagesController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['employer-index', 'employee-index', 'create'],
                        'roles' => ['@']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'matchCallback' => static function () {
                            $modelMessages = self::findModel(Yii::$app->request->get('id'));
                            // Prevent users from previewing messages of others
                            if ($modelMessages->id_user_from === Yii::$app->user->id || ($modelMessages->id_user_to === Yii::$app->user->id)) {
                                return true;
                            }
                            return false;
                        },
                        'roles' => ['@']
                    ],
                    [
                        'allow' => false
                    ]
                ]
            ]
        ];
    }

    /**
     * Lists all Messages models.
     * @return mixed
     */
    public function actionEmployerIndex()
    {
        $searchModel = new MessagesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['id_user_to' => Yii::$app->user->id]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Messages models.
     * @return mixed
     */
    public function actionEmployeeIndex()
    {
        $searchModel = new MessagesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['id_user_from' => Yii::$app->user->id]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Messages model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        // Mark message as read
        if (Yii::$app->user->identity->account_type === User::EMPLOYER && !$model->isRead) {
            $model->isRead = 1;
            $model->save();
        }

        return $this->render('view', [
            'model' => $model
        ]);
    }

    /**
     * Creates a new Messages model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param int $id_user_to
     * @param int $id_announcement
     * @return mixed
     */
    public function actionCreate($id_user_to, $id_announcement)
    {
        $model = new Messages();

        if ($model->load(Yii::$app->request->post())) {
            $model->id_user_from = Yii::$app->user->id;
            $model->id_user_to = $id_user_to;
            $model->id_announcement = $id_announcement;
            $model->save();
            $model->upload();

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Messages model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Messages the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Messages::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}