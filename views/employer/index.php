<?

/* @var $this yii\web\View */
/* @var $searchModel \app\models\search\EmployerProfileSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */

use app\models\EmployerProfile;
use app\models\Upload;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Profil pracodawcy';

?>
<div class="employer-profile-index">
    <div class="row">
        <div class="col-md-8"><h1><?= Html::encode($this->title) ?></h1></div>
        <div class="col-md-4 text-right mt-2">
            <?= Html::a('<i class="fas fa-user-edit pr-1"></i>Edycja', Url::to(['/employer/update']), [
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
                    <span class="display-4"><?= Yii::$app->user->identity->employerProfile->name ?></span>
                    <hr>
                </div>
                <div class="col-md-4"><?= EmployerProfile::instance()->getAttributeLabel('address') ?>:</div>
                <div class="col-md-8"><?= Yii::$app->user->identity->employerProfile->address ?></div>
                <div class="col-md-4"><?= EmployerProfile::instance()->getAttributeLabel('industry') ?>:</div>
                <div class="col-md-8"><?= Yii::$app->user->identity->employerProfile->industry ?></div>
                <div class="col-md-4"><?= EmployerProfile::instance()->getAttributeLabel('phone') ?>:</div>
                <div class="col-md-8"><?= Yii::$app->user->identity->employerProfile->phone ?></div>
                <div class="col-md-4"><?= EmployerProfile::instance()->getAttributeLabel('email') ?>:</div>
                <div class="col-md-8"><?= Yii::$app->user->identity->employerProfile->email ?></div>
                <div class="col-md-4"><?= EmployerProfile::instance()->getAttributeLabel('fax') ?>:</div>
                <div class="col-md-8"><?= Yii::$app->user->identity->employerProfile->fax ?></div>
                <div class="col-md-4"><?= EmployerProfile::instance()->getAttributeLabel('information') ?>:</div>
                <div class="col-md-8"><?= Yii::$app->user->identity->employerProfile->information ?></div>
            </div>
        </div>
    </div>
</div>