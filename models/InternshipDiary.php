<?

namespace app\models;

/**
 * This is the base model class for table "internship_diary".
 *
 * @property integer $id
 * @property integer $id_internship
 * @property string $date
 * @property string $description
 * @property integer $working_hours
 *
 * @property Internship $internship
 */
class InternshipDiary extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_internship', 'date', 'description', 'working_hours'], 'required'],
            [['id_internship', 'working_hours'], 'integer'],
            [['date'], 'safe'],
            [['description'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'internship_diary';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_internship' => 'Staż',
            'date' => 'Data',
            'description' => 'Opis',
            'working_hours' => 'Godz. pracy',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInternship()
    {
        return $this->hasOne(Internship::class, ['id' => 'id_internship']);
    }
}