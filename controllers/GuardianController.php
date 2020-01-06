<?

namespace app\controllers;

use app\models\EmployeeProfile;
use app\models\GuardianProfile;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * GuardianController implements the CRUD actions for EGuardianProfile model.
 */
class GuardianController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post']
                ]
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
     * Display a current logged or selected employee profile
     *
     * @param int $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex($id = null)
    {
        $id = $id ?? Yii::$app->user->identity->guardianProfile->id;

        $model = $this->findModel($id);

        return $this->render('index', [
            'model' => $model
        ]);
    }

    /**
     * Updates an existing EmployeeProfile model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @return string|\yii\web\Response
     */
    public function actionUpdate()
    {
        /** @var GuardianProfile $modelProfile */
        $modelProfile = Yii::$app->user->identity->guardianProfile;
        $modelProfile->scenario = 'update';

        if ($modelProfile->load(Yii::$app->request->post()) && $modelProfile->save() && $modelProfile->upload()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $modelProfile,
        ]);
    }

    /**
     * Finds the GuardianProfile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GuardianProfile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GuardianProfile::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}