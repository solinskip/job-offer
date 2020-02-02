<?

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\InternshipDiarySearch */

/* @var $dataProvider yii\data\ActiveDataProvider */

/* @var $model \app\models\Internship */

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Dziennik stażu';

?>
<div class="internship-diary-index">
    <div class="row">
        <div class="col-md-8"><h1><?= Html::encode($this->title) ?></h1></div>
        <div class="col-md-4 text-right">
            <? if ($model->isOwner || $model->isGuardianInternship) : ?>
                <?= Html::a('<i class="fas fa-edit"></i> Aktualizuj', Url::to(['update', 'id_internship' => $model->id]), ['class' => 'btn modal-sub']) ?>
            <? endif; ?>
            <? if ($model->isGuardianInternship) : ?>
                <?= Html::a('<i class="fas fa-trash-alt"></i> Wyślij', ['/internship/sent-to-employer', 'id_internship' => $model->id], [
                    'class' => 'btn btn-primary',
                    'data' => [
                        'confirm' => 'Czy na pewno chcesz wysłać dziennik?',
                        'method' => 'post'
                    ]
                ]) ?>
            <? endif; ?>
        </div>
    </div>
    <hr class="mt-1">
    <? $gridColumn = [
        ['class' => 'kartik\grid\SerialColumn'],
        [
            'attribute' => 'description'
        ],
        [
            'attribute' => 'date',
            'pageSummary' => static function ($summary, $data) {
                return 'Zakres: ' . min($data) . ' - ' . max($data);
            }
        ],
        [
            'attribute' => 'working_hours',
            'pageSummary' => static function ($summary) {
                return "Suma: {$summary} godz.";
            }
        ]
    ] ?>

    <?= GridView::widget([
        'id' => 'internship-diary-grid',
        'dataProvider' => $dataProvider,
        'columns' => $gridColumn,
        'resizableColumns' => false,
        'showPageSummary' => true,
        'hover' => true,
        'condensed' => true,
        'striped' => false,
        'headerRowOptions' => ['class' => 'break-word'],
        'panelTemplate' => '{panelHeading} {items} {pager}',
        'panelHeadingTemplate' => '{title}',
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<i class="fas fa-book"></i> Dziennik'
        ]
    ]) ?>
</div>