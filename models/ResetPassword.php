<?

namespace app\models;

use Yii;
use yii\base\Model;

class ResetPassword extends Model
{
    public $current_password;
    public $password;
    public $password_repeat;

    public function rules()
    {
        return [
            [['current_password', 'password', 'password_repeat'], 'required', 'message' => '{attribute} nie może pozostać bez wartości.'],
            [['current_password'], 'validatePassword'],
            ['password', 'compare', 'compareAttribute' => 'password_repeat'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'current_password' => 'Obecne hasło',
            'password' => 'Nowe hasło',
            'password_repeat' => 'Powtórz nowe hasło',
        ];
    }

    
    public function resetPassword()
    {
        if ($this->validate()) {
            Yii::$app->user->identity->setPassword($this->password);
            if (Yii::$app->user->identity->save()){
                return true;
            }
        }

        return false;
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     */
    public function validatePassword($attribute)
    {
        if (!$this->hasErrors() && !Yii::$app->user->identity->validatePassword($this->current_password)) {
            $this->addError($attribute, 'Nieprawidłowe hasło.');
        }
    }
}