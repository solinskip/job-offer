<?

/* @var $this yii\web\View */
/* @var $searchModel \app\models\search\EmployeeProfileSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */

/* @var $model EmployeeProfile */

use app\models\EmployeeProfile;
use app\models\Internship;
use app\models\Upload;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Profil pracownika';

?>
<div class="employer-profile-index">
    <div class="row">
        <div class="col-md-8"><h1><?= Html::encode($this->title) ?></h1></div>
        <? if ($model->isOwnerProfile) : ?>
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
                <div class="col-md-4"><?= $model->getAttributeLabel('education') ?>:</div>
                <div class="col-md-8"><?= $model->education ?></div>
                <div class="col-md-4"><?= $model->getAttributeLabel('birth_date') ?>:</div>
                <div class="col-md-8"><?= $model->birth_date ?></div>
                <div class="col-md-4"><?= $model->getAttributeLabel('courses') ?>:</div>
                <div class="col-md-8"><?= $model->courses ?></div>
                <div class="col-md-4"><?= $model->getAttributeLabel('experience') ?>:</div>
                <div class="col-md-8"><?= $model->experience ?></div>
                <div class="col-md-4"><?= $model->getAttributeLabel('information') ?>:</div>
                <div class="col-md-8"><?= $model->information ?></div>
                <div class="col-md-4"><?= $model->getAttributeLabel('phone') ?>:</div>
                <div class="col-md-8"><?= $model->phone ?></div>
            </div>
        </div>
    </div>

    <hr>

    <? $gridColumn = [
        ['class' => 'kartik\grid\SerialColumn'],
        [
            'attribute' => 'id_employer',
            'format' => 'raw',
            'value' => static function (Internship $model) {
                return Html::a($model->employer->username, Url::to(['/employer/index', 'id' => $model->employer->employerProfile->id]));

            }
        ],
        'announcement.start_date',
        'announcement.end_date',
        'announcement.position',
        'guardian.username',
        [
            'class' => 'kartik\grid\ActionColumn',
            'header' => 'Akcje',
            'urlCreator' => static function ($action, Internship $model) {
                    return Url::to(['/internship-diary/index', 'id_internship' => $model->id]);
                },
            'template' => '{view}',
        ]
    ]; ?>

    <?= GridView::widget([
        'id' => 'completed-internships',
        'dataProvider' => $dataProvider,
        'columns' => $gridColumn,
        'resizableColumns' => false,
        'hover' => true,
        'condensed' => true,
        'striped' => false,
        'headerRowOptions' => ['class' => 'break-word'],
        'panelTemplate' => '{panelHeading} {items} {pager}',
        'panelHeadingTemplate' => '{title}',
        'panel' => [
            'heading' => '<i class="fas fa-list"></i> Odbyte staże'
        ]
    ]) ?>
</div>