<?

namespace app\controllers;

use app\models\Internship;
use app\models\InternshipDiary;
use app\models\search\InternshipDiarySearch;
use kartik\widgets\ActiveForm;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * InternshipDiaryController implements the CRUD actions for InternshipDiary model.
 */
class InternshipDiaryController extends Controller
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
                'class' => \yii\filters\AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'update', 'add-internship-diary'],
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
     * Lists all InternshipDiary models.
     *
     * @param int $id_internship
     * @return mixed
     */
    public function actionIndex(int $id_internship)
    {
        $searchModel = new InternshipDiarySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->where([
            'id_internship' => $id_internship
        ]);

        return $this->render('index', [
            'id_internship' => $id_internship,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Updates a diary of internship
     *
     * @param integer $id_internship
     * @return mixed
     */
    public function actionUpdate($id_internship)
    {
        $modelInternship = Internship::findOne(['id' => $id_internship]);

        if (Yii::$app->request->isPost && $modelInternship->loadAll((Yii::$app->request->post() + ['Internship' => []])) &&  $modelInternship->saveAll()) {
            return $this->redirect(['index', 'id_internship' => $modelInternship->id]);
        }

        return $this->render('update', [
            'modelInternship' => $modelInternship,
            'rows' => $modelInternship->internshipDiaries
        ]);
    }

    /**
     * Action to add a new row to tabular form grid
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionAddInternshipDiary()
    {
        if (Yii::$app->request->isAjax) {
            $rows = Yii::$app->request->post('InternshipDiary');
            if (!empty($rows)) {
                $rows = array_values($rows);
            }
            if ((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($rows)) || Yii::$app->request->post('_action') == 'add') {
                $rows[] = [];
            }

            return $this->renderAjax('_formInternshipDiary', ['rows' => $rows, 'form' => ActiveForm::begin(['options' => ['id' => 'internship-diary-form']])]);
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Finds the InternshipDiary model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InternshipDiary the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InternshipDiary::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}