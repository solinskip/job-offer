<?

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\BaseFileHelper;
use yii\helpers\Url;
use yii\web\UploadedFile;

/**
 * This is the base model class for table "messages".
 *
 * @property integer $id
 * @property integer $id_user_from
 * @property integer $id_user_to
 * @property integer $id_announcement
 * @property string $message
 * @property integer $isRead
 * @property string $created_at
 *
 * @property User $fromUser
 * @property User $toUser
 *
 * @property Announcement $announcement
 */
class Messages extends \yii\db\ActiveRecord
{
    public $attachment;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user_from', 'id_user_to', 'message'], 'required'],
            [['id_user_from', 'id_user_to', 'id_announcement', 'isRead'], 'integer'],
            [['message'], 'string'],
            [['created_at'], 'safe'],

            ['isRead', 'default', 'value' => 0],

            [['attachment'], 'file', 'skipOnEmpty' => true]

        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'messages';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user_from' => 'Pracownik',
            'id_user_to' => 'Pracodawca',
            'id_announcement' => 'Ogłoszenie',
            'message' => 'Wiadomość',
            'isRead' => 'Odczytana',
            'created_at' => 'Wysłano',
            'attachment' => 'Załącznik',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFromUser()
    {
        return $this->hasOne(User::class, ['id' => 'id_user_from']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToUser()
    {
        return $this->hasOne(User::class, ['id' => 'id_user_to']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnnouncement()
    {
        return $this->hasOne(Announcement::class, ['id' => 'id_announcement']);
    }

    public static function urlMessages()
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }
        if (Yii::$app->user->identity->account_type === User::ADMINISTRATOR) {
            return false;
        }
        if (Yii::$app->user->identity->account_type === User::EMPLOYER) {
            return Url::to(['messages/employer-index']);
        }
        if (Yii::$app->user->identity->account_type === User::EMPLOYEE) {
            return Url::to(['messages/employee-index']);
        }

        throw new \yii\base\Exception('Account type not allowed');
    }

    /**
     * Upload profile picture
     *
     * @return bool
     * @throws \yii\base\Exception
     */
    public function upload()
    {
        $attachment = UploadedFile::getInstance($this, 'attachment');
       
        if ($attachment) {
            // Create path for save attachment
            $path = Yii::getAlias('@storage') . '/attachments/' . Yii::$app->user->id . '-' . $this->id;
            // Check of end catalog path, if not exist create one
            if (!is_dir($path)) {
                BaseFileHelper::createDirectory($path, 0777, true);
            }
            // Save image under name 'profile_image.jpg'
            if ($attachment->saveAs($path . '/attachment.pdf')) {
                return true;
            }
            return false;
        }
        // Return true if nothing to upload
        return true;
    }

    /**
     * @inheritdoc
     * @return array mixed
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => false,
                'value' => date('Y-m-d H:i:s')
            ]
        ];
    }
}