<?

use app\models\GuardianProfile;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $searchModel \app\models\search\GuardianProfileSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dodani opiekunowie';

?>
<div class="added-guardians-list">
    <div class="row">
        <div class="col-md-8"><h1><?= Html::encode($this->title) ?></h1></div>
        <div class="col-md-4 text-right">
            <?= Html::a('<i class="fas fa-user-shield pr-1"></i>Dodaj opiekuna', false, [
                'class' => 'btn modal-sub loadAjaxContent',
                'value' => Url::to(['/site/signup', 'withAccountType' => false]),
                'icon' => '<i class="fas fa-user-shield"></i>',
                'modaltitle' => 'Dodaj opiekuna'
            ]) ?>
        </div>
    </div>

    <hr class="mt-1">

    <?= GridView::widget([
        'id' => 'added-guardians',
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'user.username',
                'value' => static function (GuardianProfile $model) {
                    return Html::a($model->user->username, Url::to(['/guardian/index', 'id' => $model->id]));

                },
                'format' => 'raw',
            ],
            'name',
            'surname',
            'email',
            'phone'
        ],
        'resizableColumns' => false,
        'hover' => true,
        'condensed' => true,
        'striped' => false,
        'headerRowOptions' => ['class' => 'break-word'],
        'panelTemplate' => '{panelHeading} {items} {pager}',
        'panelHeadingTemplate' => '{title}',
        'panel' => [
            'heading' => "<i class='fas fa-user-shield'></i> Opiekunowie"
        ]
    ]) ?>
</div>