<?

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property int $id
 * @property int $id_employer
 * @property string $username
 * @property int $account_type, 0 => administrator, 1 => employer, 2 => employee, 3 => guardian
 * @property string $password_hash
 * @property int $created_at
 * @property int $updated_at
 * @property int $logged_at
 *
 * @property User $idEmployer
 * @property EmployerProfile $employerProfile
 * @property EmployeeProfile $employeeProfile
 * @property GuardianProfile $guardianProfile
 * @property bool $isAdministrator
 * @property bool $isEmployer
 * @property bool $isEmployee
 * @property bool $isGuardian
 */
class User extends ActiveRecord implements IdentityInterface
{
    public const ADMINISTRATOR = 0;
    public const EMPLOYER = 1;
    public const EMPLOYEE = 2;
    public const GUARDIAN = 3;

    public static function tableName()
    {
        return '{{%user}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function rules()
    {
        return [
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Nazwa użytkownika',
            'account_type' => 'Typ konta',
            'password_hash' => 'Hasło',
            'created_at' => 'Utworzony',
            'updated_at' => 'Ostatnia modyfikacja',
            'logged_at' => 'Ostatnie logowanie'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEmployer()
    {
        return $this->hasOne(__CLASS__, ['id' => 'id_employer']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployerProfile()
    {
        return $this->hasOne(EmployerProfile::class, ['id_user' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeProfile()
    {
        return $this->hasOne(EmployeeProfile::class, ['id_user' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGuardianProfile()
    {
        return $this->hasOne(GuardianProfile::class, ['id_user' => 'id']);
    }

    /**
     * Return url to profile, depends on current login user is employer or employee
     *
     * @return bool|string
     * @throws \yii\base\Exception
     */
    public static function urlProfile()
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }

        if (Yii::$app->user->identity->attributes['account_type'] === self::ADMINISTRATOR) {
            return Url::to(['/admin/index']);
        }
        if (Yii::$app->user->identity->attributes['account_type'] === self::EMPLOYER) {
            return Url::to(['/employer/index']);
        }
        if (Yii::$app->user->identity->attributes['account_type'] === self::EMPLOYEE) {
            return Url::to(['/employee/index']);
        }
        if (Yii::$app->user->identity->attributes['account_type'] === self::GUARDIAN) {
            return Url::to(['/guardian/index']);
        }

        throw new \yii\base\Exception('Account type not allowed');
    }

    /**
     * Checks that current logged user is employer
     *
     * @return bool
     */
    public function getIsAdministrator() {
        return Yii::$app->user->identity->account_type === self::ADMINISTRATOR;
    }

    /**
     * Checks that current logged user is employer
     *
     * @return bool
     */
    public function getIsEmployer() {
        return Yii::$app->user->identity->account_type === self::EMPLOYER;
    }

    /**
     * Checks that current logged user is employee
     *
     * @return bool
     */
    public function getIsEmployee() {
        return Yii::$app->user->identity->account_type === self::EMPLOYEE;
    }

    /**
     * Checks that current logged user is employee
     *
     * @return bool
     */
    public function getIsGuardian() {
        return Yii::$app->user->identity->account_type === self::GUARDIAN;
    }

    /**
     * FInd user by username
     *
     * @param $username
     * @return User|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * @param $password
     * @throws \yii\base\Exception
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }
}
