<?

namespace app\models;

use yii\base\Exception;
use yii\base\Model;


class Signup extends Model
{
    public $username;
    public $account_type;
    public $password;

    public function rules()
    {
        return [
            [['username', 'account_type', 'password'], 'required', 'message' => '{attribute} nie może pozostać bez wartości.'],
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
        $user->account_type = $this->account_type;
        $user->setPassword($this->password);

        if ($user->save()){
            if ($user->account_type === User::EMPLOYER) {
                $profile = new EmployerProfile(['scenario' => 'signup']);
            } elseif ($user->account_type === User::EMPLOYEE) {
                $profile = new EmployeeProfile(['scenario' => 'signup']);
            } else {
                throw new Exception('Account type not allowed');
            }

            $profile->id_user = $user->id;

            if ($profile->save()) {
                return true;
            }
        }

        return false;
    }
}