<?

namespace app\controllers;

use app\models\Login;
use app\models\ResetPassword;
use app\models\Signup;
use app\models\User;
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
     * For guests display homepage with information about login
     * For logged users display announcements list
     * For administrator display control panel
     *
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->render('index');
        }
        if (Yii::$app->user->identity->isAdministrator) {
            return $this->redirect('admin/index');
        }

        return $this->redirect('announcement/index');
    }

    /**
     * Signup new users
     *
     * @param bool $withAccountType
     * @return string|Response
     * @throws \yii\base\Exception
     */
    public function actionSignup($withAccountType = true)
    {
        $scenario = $withAccountType ? 'signup' : 'guardian';
        $model = new Signup(['scenario' => $scenario]);

        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            if ($withAccountType) {
                Yii::$app->session->setFlash('success', 'Rejestracja przebiegła pomyślnie, teraz możesz się zalogować na swoje konto.');
                return $this->redirect(Url::to(['/site/index']));
            }

            Yii::$app->session->setFlash('success', 'Rejestracja opiekuna przebiegła pomyślnie.');
            return $this->redirect(Url::to(['employer/added-guardians']));
        }

        return $this->renderAjax('signup', [
            'model' => $model
        ]);
    }

    /**
     * Login action
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

    /**
     * Reset password current logged user
     *
     * @return string|Response
     */
    public function actionResetPassword()
    {
        $model = new ResetPassword();

        if ($model->load(Yii::$app->request->post()) && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'Zmiana hasła przebiegła pomyślnie.');

            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->renderAjax('reset-password', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Allows to download local file
     *
     * @return \yii\console\Response|Response
     * @throws \yii\base\InvalidConfigException
     */
    public function actionStorageDownload()
    {
        $requestedPath = urldecode(Yii::$app->request->getUrl());
        // Path to local file
        $path = realpath(Yii::getAlias('@storage') . '/' . $requestedPath);

        if (file_exists($path)) {
            return Yii::$app->response->sendFile($path);
        }

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

        $path = Url::to('@storage/') . $dir . '/' . $key . '/' . $fileName;
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
     * Finds the data for ajax select lists
     *
     * @param string $q
     * @param string|null $type
     * @return Response
     */
    public function actionAjaxList(string $q = '', string $type = null)
    {
        // Get all guardians
        if ($type === 'internshipGuardian') {
            $out['results'] = User::find()
                ->select(['id' => 'user.id', 'text' => 'username'])
                ->where(['LIKE', 'username', $q])
                ->andWhere(['IS NOT', 'id_employer', null])
                ->asArray()
                ->limit(20)
                ->all();
        }

        return $this->asJson($out);
    }

    /**
     * @param ActiveRecord $model
     * @param string $scenario
     * @return array|bool
     */
    public function actionValidateForm($model, $scenario = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if ($model) {
            $model = new $model;
            // Set scenario if is different than default
            if ($scenario !== null) {
                $model->scenario = $scenario;
            }
            $model->load(Yii::$app->request->post());

            return \kartik\form\ActiveForm::validate($model);
        }

        return false;
    }
}
