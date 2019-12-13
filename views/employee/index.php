<?

/* @var $this yii\web\View */
/* @var $searchModel \app\models\search\EmployeeProfileSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */

use app\models\EmployeeProfile;
use app\models\Upload;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Profil pracownika';

?>
<div class="employer-profile-index">
    <div class="row">
        <div class="col-md-8"><h1><?= Html::encode($this->title) ?></h1></div>
        <div class="col-md-4 text-right mt-2">
            <?= Html::a('<i class="fas fa-user-edit pr-1"></i>Edycja', Url::to(['/employee/update']), [
                'class' => 'btn modal-sub'
            ]) ?>
            <?= Html::a('<i class="fas fa-lock pr-1"></i>Zmiana hasła', false, [
                'class' => 'btn modal-sub loadAjaxContent',
                'value' => Url::to(['/site/reset-password']),
                'icon' => '<i class="fas fa-lock"></i>',
                'modaltitle' => 'Zmiana hasła'
            ]) ?>
        </div>
    </div>

    <hr class="mt-1">

    <div class="row">
        <div class="col-md-5 text-center">
            <? if (Upload::fileLink('profile_images', Yii::$app->user->id, 'profile_image.jpg')) : ?>
                <img src="<?= Upload::fileLink('profile_images', Yii::$app->user->id, 'profile_image.jpg') ?>" class="profile-image" alt="">
            <? else : ?>
                <i class="fas fa-user-tie fa-10x profile-image" style="color: #343a40"></i>
            <? endif; ?>
        </div>
        <div class="col-md-7">
            <div class="row">
                <div class="col-md-12">
                    <span class="display-4"><?= Yii::$app->user->identity->employeeProfile->name ?> <?= Yii::$app->user->identity->employeeProfile->surname ?></span>
                    <hr>
                </div>
                <div class="col-md-4"><?= EmployeeProfile::instance()->getAttributeLabel('email') ?>:</div>
                <div class="col-md-8"><?= Yii::$app->user->identity->employeeProfile->email ?></div>
                <div class="col-md-4"><?= EmployeeProfile::instance()->getAttributeLabel('education') ?>:</div>
                <div class="col-md-8"><?= Yii::$app->user->identity->employeeProfile->education ?></div>
                <div class="col-md-4"><?= EmployeeProfile::instance()->getAttributeLabel('birth_date') ?>:</div>
                <div class="col-md-8"><?= Yii::$app->user->identity->employeeProfile->birth_date ?></div>
                <div class="col-md-4"><?= EmployeeProfile::instance()->getAttributeLabel('courses') ?>:</div>
                <div class="col-md-8"><?= Yii::$app->user->identity->employeeProfile->courses ?></div>
                <div class="col-md-4"><?= EmployeeProfile::instance()->getAttributeLabel('experience') ?>:</div>
                <div class="col-md-8"><?= Yii::$app->user->identity->employeeProfile->experience ?></div>
                <div class="col-md-4"><?= EmployeeProfile::instance()->getAttributeLabel('information') ?>:</div>
                <div class="col-md-8"><?= Yii::$app->user->identity->employeeProfile->information ?></div>
                <div class="col-md-4"><?= EmployeeProfile::instance()->getAttributeLabel('phone') ?>:</div>
                <div class="col-md-8"><?= Yii::$app->user->identity->employeeProfile->phone ?></div>
            </div>
        </div>
    </div>
</div>