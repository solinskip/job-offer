<?

namespace app\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the base model class for table "internship".
 *
 * @property integer $id
 * @property integer $id_employee
 * @property integer $id_employer
 * @property integer $id_guardian
 * @property integer $id_announcement
 * @property integer $id_messages
 * @property integer $accepted
 * @property integer $isSent
 *
 * @property User $employee
 * @property User $employer
 * @property User $guardian
 * @property Announcement $announcement
 * @property InternshipDiary $internshipDiaries
 * @property Messages $messages
 * @property string $acceptedHtml
 * @property bool $isOwner
 * @property bool $isGuardianInternship
 */
class Internship extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_employee', 'id_employer', 'id_announcement', 'id_messages'], 'required'],
            ['isSent', 'default', 'value' => 0],
            [['id', 'id_employee', 'id_employer', 'id_guardian', 'id_announcement', 'id_messages', 'accepted', 'isSent'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'internship';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_employee' => 'Pracownik',
            'id_employer' => 'Pracodawca',
            'id_guardian' => 'Opiekun',
            'id_announcement' => 'Ogłoszenie',
            'id_messages' => 'Wiadomość',
            'accepted' => 'Przyjęty',
            'isSent' => 'Wysłany',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(User::class, ['id' => 'id_employee']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployer()
    {
        return $this->hasOne(User::class, ['id' => 'id_employer']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGuardian()
    {
        return $this->hasOne(User::class, ['id' => 'id_guardian']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnnouncement()
    {
        return $this->hasOne(Announcement::class, ['id' => 'id_announcement']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInternshipDiaries()
    {
        return $this->hasMany(InternshipDiary::class, ['id_internship' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasOne(Messages::class, ['id' => 'id_messages']);
    }

    /**
     * Checks that current logged user is owner internship
     *
     * @return bool
     */
    public function getIsOwner()
    {
        return $this->id_employee === Yii::$app->user->identity->id;
    }

    /**
     * Checks that current logged user is owner internship
     *
     * @return bool
     */
    public function getIsGuardianInternship()
    {
        return $this->id_guardian === Yii::$app->user->identity->id;
    }

    /**
     * Urls to internship depends on account type of user
     *
     * @return bool|string
     * @throws \yii\base\Exception
     */
    public static function urlInternship()
    {
        if (Yii::$app->user->isGuest
            || Yii::$app->user->identity->account_type === User::ADMINISTRATOR
            || Yii::$app->user->identity->account_type === User::EMPLOYEE) {
            return false;
        }
        if (Yii::$app->user->identity->account_type === User::EMPLOYER) {
            return Url::to(['internship/employer']);
        }
        if (Yii::$app->user->identity->account_type === User::GUARDIAN) {
            return Url::to(['internship/guardian']);
        }

        throw new \yii\base\Exception('Account type not allowed');
    }

    /**
     * Return a HTML badge with result of accepted to internship
     *
     * @return string
     */
    public function getAcceptedHtml()
    {
        return '<span style="font-size: 18px" class="badge badge-' . ($this->accepted ? 'success' : 'danger') . '">' . ($this->accepted ? 'Tak' : 'Nie') . '</span>';
    }

    /**
     * Save internships in loop
     * All surrounded transaction
     *
     * @param array $internships
     * @return bool
     * @throws \Exception
     */
    public static function saveInternship(array $internships)
    {
        if ($internships === null) {
            return false;
        }

        $transaction = self::getDb()->beginTransaction();

        try {
            foreach ($internships as $modelInternship) {
                $model = self::findOne($modelInternship['id']);
                if (!$model->load(['Internship' => $modelInternship]) || !$model->save()) {
                    $transaction->rollBack();
                }
            }
            $transaction->commit();
            return true;
        } catch (\Exception $exc) {
            $transaction->rollBack();
            throw $exc;
        }
    }
}