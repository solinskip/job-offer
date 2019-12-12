<?

namespace app\models;

use Yii;
use yii\helpers\BaseFileHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "employer_profile".
 *
 * @property int $id
 * @property int $id_user
 * @property string $name
 * @property string $address
 * @property string $industry
 * @property int $phone
 * @property string $email
 * @property int $fax
 * @property string|null $information
 *
 * @property User $user
 */
class EmployerProfile extends \yii\db\ActiveRecord
{
    public $profile_image;

    public const SCENARIO_SIGNUP = 'signup';
    public const SCENARIO_UPDATE = 'update';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employer_profile';
    }

    /**
     * Scenarios from Msa are inherited to relations
     */
    public function scenarios()
    {
        $allAttributes = ['id', 'id_user', 'name', 'address', 'industry', 'phone', 'email', 'fax', 'information', 'profile_image'];
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
            self::SCENARIO_UPDATE => ['id_user', 'name', 'address', 'industry', 'phone', 'email', 'fax']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [$this->required()[$this->scenario], 'required'],

            [['id_user', 'phone', 'fax'], 'integer'],
            [['information'], 'string'],
            [['email'], 'email'],
            [['name', 'address'], 'string', 'max' => 50],
            [['industry'], 'string', 'max' => 255],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_user' => 'id']],

            [['profile_image'], 'file', 'skipOnEmpty' => true]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Nazwa',
            'address' => 'Adres',
            'industry' => 'Przedsiębiorstwo',
            'phone' => 'Telefon',
            'email' => 'Email',
            'fax' => 'Fax',
            'information' => 'Informacje',
            'profile_image' => 'Zdjęcie profilowe'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'id_user']);
    }

    /**
     * Upload profile picture
     *
     * @return bool
     * @throws \yii\base\Exception
     */
    public function upload()
    {
        $profileImage = UploadedFile::getInstance($this, 'profile_image');

        if ($profileImage) {
            // Create path for save image
            $path = Yii::getAlias('@app') . '/images/profile_images/' . Yii::$app->user->id;
            // Check of end catalog path, if not exist create one
            if (!is_dir($path)) {
                BaseFileHelper::createDirectory($path, 0777, true);
            }
            // Save image under name 'profile_image.jpg'
            if ($profileImage->saveAs($path . '/profile_image.jpg')) {
                return true;
            }
            return false;
        }
        // Return true if nothing to upload
        return true;
    }
}