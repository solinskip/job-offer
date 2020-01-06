<?

/* @var $this yii\web\View */
/* @var $searchModel \app\models\search\GuardianProfileSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */

use app\models\EmployeeProfile;
use app\models\Upload;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Profil opiekuna';

?>
<div class="guardian-profile-index">
    <div class="row">
        <div class="col-md-8"><h1><?= Html::encode($this->title) ?></h1></div>
        <? if ($model->isOwnerProfile) : ?>
            <div class="col-md-4 text-right mt-2">
                <?= Html::a('<i class="fas fa-user-edit pr-1"></i>Edycja', Url::to(['/guardian/update']), [
                    'class' => 'btn modal-sub'
                ]) ?>
                <?= Html::a('<i class="fas fa-lock pr-1"></i>Zmiana hasła', false, [
                    'class' => 'btn modal-sub loadAjaxContent',
                    'value' => Url::to(['/site/reset-password']),
                    'icon' => '<i class="fas fa-lock"></i>',
                    'modaltitle' => 'Zmiana hasła'
                ]) ?>
            </div>
        <? endif; ?>
    </div>

    <hr class="mt-1">

    <div class="row">
        <div class="col-md-5 text-center">
            <? if (Upload::fileLink('profile_images', $model->user->id, 'profile_image.jpg')) : ?>
                <img src="<?= Upload::fileLink('profile_images', $model->user->id, 'profile_image.jpg') ?>" class="profile-image" alt="">
            <? else : ?>
                <i class="fas fa-user-tie fa-10x profile-image" style="color: #343a40"></i>
            <? endif; ?>
        </div>
        <div class="col-md-7">
            <div class="row">
                <div class="col-md-12">
                    <span class="display-4"><?= $model->name ?> <?= $model->surname ?></span>
                    <hr>
                </div>
                <div class="col-md-4">Nazwa użytkownika:</div>
                <div class="col-md-8"><span class="badge badge-info" style="font-size: 20px"><?= $model->user->username ?></span></div>
                <div class="col-md-4"><?= $model->getAttributeLabel('email') ?>:</div>
                <div class="col-md-8"><?= $model->email ?></div>
                <div class="col-md-4"><?= $model->getAttributeLabel('phone') ?>:</div>
                <div class="col-md-8"><?= $model->phone ?></div>
            </div>
        </div>
    </div>
</div>