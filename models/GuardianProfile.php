<?

namespace app\models;


use Yii;
use yii\helpers\BaseFileHelper;
use yii\web\UploadedFile;

/**
 * This is the base model class for table "guardian_profile".
 *
 * @property integer $id
 * @property integer $id_user
 * @property string $name
 * @property string $surname
 * @property string $email
 * @property integer $phone
 *
 * @property User $user
 */
class GuardianProfile extends \yii\db\ActiveRecord
{
    public $profile_image;

    public const SCENARIO_SIGNUP = 'signup';
    public const SCENARIO_UPDATE = 'update';

    /**
     * Scenarios from Msa are inherited to relations
     */
    public function scenarios()
    {
        $allAttributes = ['id', 'id_user', 'name', 'surname', 'email', 'phone'];
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
            self::SCENARIO_UPDATE => ['id_user', 'name', 'surname', 'email', 'phone']
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [$this->required()[$this->scenario], 'required'],

            [['phone'], 'integer'],
            [['name', 'surname', 'email'], 'string', 'max' => 50],

            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_user' => 'id']],

            [['profile_image'], 'file', 'skipOnEmpty' => true]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'guardian_profile';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'name' => 'Imię',
            'surname' => 'Nazwisko',
            'email' => 'Email',
            'phone' => 'Telefon kom.',
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
            $path = Yii::getAlias('@app') . '/storage/profile_images/' . Yii::$app->user->id;
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

    /**
     * Checks that current logged user is viewer his own profile
     *
     * @return bool
     */
    public function getIsOwnerProfile()
    {
        return Yii::$app->user->identity->account_type === User::GUARDIAN && Yii::$app->user->identity->guardianProfile->id === $this->id;
    }
}