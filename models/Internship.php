<?

namespace app\models;

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
 *
 * @property User $employee
 * @property User $employer
 * @property User $guardian
 * @property Announcement $announcement
 * @property InternshipDiary $internshipDiaries
 * @property Messages $messages
 * @property string $acceptedHtml
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
            [['id', 'id_employee', 'id_employer', 'id_guardian', 'id_announcement', 'id_messages', 'accepted'], 'integer']
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