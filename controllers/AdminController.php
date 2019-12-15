<?

namespace app\controllers;

use app\models\search\AnnouncementSearch;
use app\models\search\EmployerProfileSearch;
use app\models\search\EmployeeProfileSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class AdminController extends Controller
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
                        'actions' => ['index'],
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
        $searchModelAnnouncement = new AnnouncementSearch();
        $dataProviderAnnouncement = $searchModelAnnouncement->search(Yii::$app->request->queryParams);
        $searchModelEmployer = new EmployerProfileSearch();
        $dataProviderEmployer = $searchModelEmployer->search(Yii::$app->request->queryParams);
        $searchModelEmployee = new EmployeeProfileSearch();
        $dataProviderEmployee = $searchModelEmployee->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'dataProviderAnnouncement' => $dataProviderAnnouncement,
            'dataProviderEmployer' => $dataProviderEmployer,
            'dataProviderEmployee' => $dataProviderEmployee,
        ]);
    }
}