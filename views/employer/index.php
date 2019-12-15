<?

/* @var $this yii\web\View */
/* @var $searchModel \app\models\search\EmployerProfileSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */

use app\models\Announcement;
use app\models\EmployerProfile;
use app\models\Upload;
use kartik\grid\GridView;
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
                <div class="col-md-4">Nazwa użytkownika:</div>
                <div class="col-md-8"><span class="badge badge-info" style="font-size: 20px"><?= Yii::$app->user->identity->username ?></span></div>
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
    <div class="mt-5">
        <?= GridView::widget([
            'id' => 'added-announcement',
            'dataProvider' => $dataProvider,
            'columns' => [
                'name',
                'place',
                'position',
                [
                    'attribute' => 'salary',
                    'value' => static function ($model) {
                        return $model->salary . ' zł. brutto/mies.';
                    }
                ],
                [
                    'attribute' => 'active',
                    'format' => 'raw',
                    'value' => static function (Announcement $model) {
                        return '<span style="font-size: 18px" class="badge badge-' . ($model->active ? 'success' : 'danger') . '">' . ($model->active ? 'Tak' : 'Nie') . '</span>';
                    },
                    'hAlign' => 'center'
                ],
                'created_at',
                [
                    'class' => 'kartik\grid\ActionColumn',
                    'width' => '85px',
                    'header' => 'Akcje',
                    'template' => '{view} {update} {delete}',
                    'urlCreator' => static function ($action, /** @noinspection PhpUnusedParameterInspection */ $model, $key) {
                        return Url::to(['/announcement/' . $action, 'id' => $key]);
                    },
                    'deleteOptions' => ['role' => 'modal-remote', 'title' => 'Usuń',
                        'data-confirm' => false, 'data-method' => false, // for overide yii data api
                        'data-request-method' => 'post',
                        'data-toggle' => 'tooltip',
                        'data-confirm-title' => 'Potwierdź akcję.',
                        'data-confirm-message' => 'Czy na pewno usunąć ten rekord?'],
                ]
            ],
            'resizableColumns' => false,
            'hover' => true,
            'condensed' => true,
            'striped' => false,
            'pjax' => true,
            'pjaxSettings' => [
                'options' => [
                    'enablePushState' => false,
                    'enableReplaceState' => false
                ]
            ],
            'headerRowOptions' => ['class' => 'break-word'],
            'panelTemplate' => '{panelHeading} {items} {pager}',
            'panelHeadingTemplate' => '{title}',
            'panel' => [
                'heading' => "<i class='fas fa-bullhorn'></i> Dodane ogłoszenia"
            ]
        ]) ?>
    </div>
</div>