<?

namespace app\models;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "announcement".
 *
 * @property int $id
 * @property string $name
 * @property string $place
 * @property string $position
 * @property int|null $salary
 * @property string $responsibilities
 * @property string $description
 * @property int|null $active
 * @property string $created_at
 * @property int $created_by
 *
 * @property User $createdBy
 */
class Announcement extends \yii\db\ActiveRecord
{
    public $fromSalary;
    public $toSalary;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'announcement';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => false,
                'value' => date('Y-m-d H:i:s')
            ],
            'blameable' => [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => false,

            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'place', 'position', 'responsibilities', 'description'], 'required'],

            [['salary', 'active', 'created_by'], 'integer'],
            ['active', 'default', 'value' => 1],
            [['responsibilities', 'description'], 'string'],
            [['created_at', 'fromSalary', 'toSalary'], 'safe'],
            [['name', 'place', 'position'], 'string', 'max' => 255],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Nazwa',
            'place' => 'Miejsce',
            'position' => 'Stanowisko',
            'salary' => 'Wynagrodzenie',
            'responsibilities' => 'Obowiązki',
            'description' => 'Opis stanowiska',
            'active' => 'Aktywne',
            'created_at' => 'Data utworzenia',
            'created_by' => 'Utworzono przez',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * List of available positions
     *
     * @return array
     */
    public static function listOfPositions()
    {
        return [
            'Programista' => 'Programista',
            'Prawnik' => 'Prawnik',
            'Magazynier' => 'Magazynier',
            'Kierowca' => 'Kierowca',
            'Kierownik' => 'Kierownik'
        ];
    }
}