<?

namespace app\controllers;

use app\models\EmployerProfile;
use app\models\search\AnnouncementSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * EmployerController implements the CRUD actions for EmployerProfile model.
 */
class EmployerController extends Controller
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
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
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
     * Display a current login employer profile
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AnnouncementSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // Display only those announcements that current logged user created
        $dataProvider->query->andWhere(['created_by' => Yii::$app->user->id]);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Updates an existing EmployerProfile model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @return string|\yii\web\Response
     */
    public function actionUpdate()
    {
        /** @var EmployerProfile $modelProfile */
        $modelProfile = Yii::$app->user->identity->employerProfile;
        $modelProfile->scenario = 'update';

        if ($modelProfile->load(Yii::$app->request->post()) && $modelProfile->save() && $modelProfile->upload()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $modelProfile,
        ]);
    }

    /**
     * Deletes an existing EmployerProfile model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    /**
     * Finds the EmployerProfile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EmployerProfile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EmployerProfile::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}