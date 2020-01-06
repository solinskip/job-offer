<?

namespace app\controllers;

use app\models\Announcement;
use app\models\Internship;
use app\models\search\InternshipSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * InternshipController implements the CRUD actions for Internship model.
 */
class InternshipController extends Controller
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
                        'actions' => ['employer', 'guardian', 'willing-list', 'admission-list', 'sent-to-employer'],
                        'roles' => ['@']
                    ],
                    [
                        'allow' => false
                    ]
                ]
            ]
        ];
    }

    public function actionGuardian()
    {
        $searchModel = new InternshipSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere([
            'id_guardian' => Yii::$app->user->identity->id,
            'accepted' => 1
        ]);

        return $this->render('guardian', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionEmployer()
    {
        $searchModel = new InternshipSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere([
            'internship.id_employer' => Yii::$app->user->identity->id,
            'accepted' => 1,
            'isSent' => 1
        ]);

        return $this->render('guardian', [
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Willing list for announcement
     *
     * @param int $id_announcement
     * @return string
     */
    public function actionWillingList(int $id_announcement)
    {
        $modelAnnouncement = Announcement::findOne(['id' => $id_announcement]);

        $searchModel = new InternshipSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // Filter only internships related to this announcement
        $dataProvider->query->andWhere([
            'id_announcement' => $id_announcement
        ]);

        return $this->render('willingList', [
            'dataProvider' => $dataProvider,
            'modelAnnouncement' => $modelAnnouncement
        ]);
    }

    /**
     * Admission list for announcement
     *
     * @param int $id_announcement
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionAdmissionList(int $id_announcement)
    {
        $model = Internship::findAll(['id_announcement' => $id_announcement]);
        $modelAnnouncement = Announcement::findOne(['id' => $id_announcement]);

        if (Yii::$app->request->isPost && Internship::saveInternship(Yii::$app->request->post('Internship'))) {
            return $this->redirect(['/internship/willing-list', 'id_announcement' => $modelAnnouncement->id]);
        }

        return $this->render('admissionList', [
            'model' => $model,
        ]);
    }

    public function actionSentToEmployer($id_internship)
    {
        $model = $this->findModel($id_internship);

        if ($model->isSent === 0) {
            $model->isSent = 1;
            if ($model->save()){
                Yii::$app->session->setFlash('success', 'Dziennik został wysłany pomyślnie.');

                return $this->redirect(Url::to(['/internship-diary/index', 'id_internship' => $id_internship]));
            }
        }
    }

    /**
     * Finds the Internship model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Internship the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Internship::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}