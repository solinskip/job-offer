<?

namespace app\controllers;

use app\models\Login;
use app\models\ResetPassword;
use app\models\Signup;
use Yii;
use yii\db\ActiveRecord;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Displays homepage with statistic transactions
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @return string|Response
     * @throws \yii\base\Exception
     */
    public function actionSignup()
    {
        $model = new Signup();

        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Rejestracja przebiegła pomyślnie, teraz możesz się zalogować na swoje konto.');

            return $this->redirect(Url::to(['/site/index']));
        }

        return $this->renderAjax('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new Login();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        return $this->renderAjax('login', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword()
    {
        $model = new ResetPassword();

        if ($model->load(Yii::$app->request->post()) && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'Zmiana hasa przebiegła pomyślnie.');

            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->renderAjax('reset-password', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Allow to download local file
     *
     * @return \yii\console\Response|Response
     * @throws \yii\base\InvalidConfigException
     */
    public function actionStorageDownload()
    {
        $requestedPath = urldecode(Yii::$app->request->getUrl());
        $path = realpath(Yii::getAlias('@images') . '/' . $requestedPath);

        if (file_exists($path)) {
            return Yii::$app->response->sendFile($path);
        }

//        Yii::$app->session->setFlash('danger', 'Plik, który próbujesz pobrać nie istnieje.');

        return $this->redirect(['/site/index']);
    }

    /**
     * Deletes the indicated files from local storage
     *
     * @return bool
     */
    public function actionDeleteFile()
    {
        ['key' => $key, 'dir' => $dir, 'fileName' => $fileName] = Yii::$app->request->post();

        $path = Url::to('@images/') . $dir . '/' . $key . '/' . $fileName;
        if (file_exists($path) && unlink($path)) {
            return true;
        }
        return false;
    }

    /**
     * Display error site when user operate on non-existent data or something goes wrong
     *
     * @return string
     */
    public function actionError()
    {
        return $this->render('error');
    }

    /**
     * @param ActiveRecord $model
     * @return array|bool
     */
    public function actionValidateForm($model)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        if ($model) {
            $model = new $model;
            $model->load(Yii::$app->request->post());

            return \kartik\form\ActiveForm::validate($model);
        }

        return false;
    }
}
