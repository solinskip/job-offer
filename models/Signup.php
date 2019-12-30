<?

namespace app\models;

use Yii;
use yii\base\Exception;
use yii\base\Model;


class Signup extends Model
{
    public const SCENARIO_SIGNUP = 'signup';
    public const SCENARIO_GUARDIAN = 'guardian';

    public $username;
    public $account_type;
    public $password;

    /**
     * Scenarios from Msa are inherited to relations
     */
    public function scenarios()
    {
        $allAttributes = ['username', 'account_type', 'password'];
        return [
            self::SCENARIO_SIGNUP => $allAttributes,
            self::SCENARIO_GUARDIAN => $allAttributes
        ];
    }

    /**
     * List od required attributes for each scenario
     */
    public function required()
    {
        return [
            self::SCENARIO_SIGNUP => ['username', 'account_type', 'password'],
            self::SCENARIO_GUARDIAN => ['username', 'password']
        ];
    }


    public function rules()
    {
        return [
            [$this->required()[$this->scenario], 'required'],
            [['username'], 'unique', 'targetClass' => User::class, 'message' => 'Podana nazwa użytkownika jest już zajętą.'],

            [['account_type'], 'integer'],
            [['account_type'], 'filter', 'filter' => 'intval'],

            [['username'], 'string', 'max' => 50],
            [['username'], 'trim'],

            [['password'], 'string', 'min' => 6, 'message' => '{attribute} musi zawierać przynajmniej 6 znaków.'],
            [['password'], 'string', 'max' => 255, 'message' => '{attribute} może zawierać 255 znaków.'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Nazwa użytkownika',
            'account_type' => 'Typ konta',
            'password' => 'Hasło',
        ];
    }

    /**
     * Signs user up
     *
     * @return bool|null
     * @throws Exception
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        if ($this->scenario === 'guardian') {
            $user->account_type = User::GUARDIAN;
            // Assigns guardian to the employer
            $user->id_employer = Yii::$app->user->id;
        } else {
            $user->account_type = $this->account_type;
        }
        $user->setPassword($this->password);

        if ($user->save()) {
            if ($user->account_type === User::EMPLOYER) {
                $modelClass = EmployerProfile::class;
            } elseif ($user->account_type === User::EMPLOYEE) {
                $modelClass = EmployeeProfile::class;
            } elseif ($user->account_type === User::GUARDIAN) {
                $modelClass = GuardianProfile::class;
            } else {
                throw new Exception('Account type not allowed');
            }

            $profile = new $modelClass(['scenario' => 'signup']);
            $profile->id_user = $user->id;

            if ($profile->save()) {
                return true;
            }
        }

        return false;
    }
}