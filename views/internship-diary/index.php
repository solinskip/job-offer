<?

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\InternshipDiarySearch */

/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $id_internship int */

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Dziennik stażu';

?>
<div class="internship-diary-index">
    <div class="row">
        <div class="col-md-8"><h1><?= Html::encode($this->title) ?></h1></div>
        <div class="col-md-4 text-right">
            <?= Html::a('<i class="fas fa-edit"></i> Aktualizuj', Url::to(['update', 'id_internship' => $id_internship]), ['class' => 'btn modal-sub']) ?>
        </div>
    </div>
    <hr class="mt-1">
    <? $gridColumn = [
        ['class' => 'kartik\grid\SerialColumn'],
        'description:ntext',
        'date',
        'working_hours'
    ] ?>

    <?= GridView::widget([
        'id' => 'internship-diary-grid',
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
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<i class="fas fa-book"></i> Dziennik'
        ]
    ]) ?>
</div>