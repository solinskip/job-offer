<?

namespace app\models;

/**
 * This is the model class for table "employee_profile".
 *
 * @property int $id
 * @property int $id_user
 * @property string $name
 * @property string $surname
 * @property string $email
 * @property string $education
 * @property string $birth_date
 * @property string|null $courses
 * @property string|null $experience
 * @property string|null $information
 * @property int $phone
 *
 * @property User $user
 */
class EmployeeProfile extends \yii\db\ActiveRecord
{
    public const SCENARIO_SIGNUP = 'signup';
    public const SCENARIO_UPDATE = 'update';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee_profile';
    }

    /**
     * Scenarios from Msa are inherited to relations
     */
    public function scenarios()
    {
        $allAttributes = ['id', 'id_user', 'name', 'surname', 'email', 'education', 'birth_date', 'courses', 'experience', 'phone', 'information'];
        return [
            self::SCENARIO_SIGNUP => $allAttributes,
            self::SCENARIO_UPDATE => $allAttributes
        ];
    }

    /**
     * List od required attributes for each scenario
     */
    public function required()
    {
        return [
            self::SCENARIO_SIGNUP => ['id_user'],
            self::SCENARIO_UPDATE => ['id_user', 'name', 'email', 'education', 'birth_date', 'phone']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [$this->required()[$this->scenario], 'required'],

            [['id_user', 'phone'], 'integer'],
            [['education', 'courses', 'experience', 'information'], 'string'],
            [['birth_date'], 'safe'],
            [['name', 'surname', 'email'], 'string', 'max' => 50],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'name' => 'Imię',
            'surname' => 'Nazwisko',
            'email' => 'Email',
            'education' => 'Wykształcenie',
            'birth_date' => 'Data urodzenia',
            'courses' => 'Kursy',
            'experience' => 'Doświadczenie',
            'information' => 'Informacje',
            'phone' => 'Telefon',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'id_user']);
    }
}