<?

use app\models\Announcement;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $searchModel \app\models\search\EmployerProfileSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dodane ogłoszenia';

?>
<div class="added-announcements-list">
    <h1><?= Html::encode($this->title) ?></h1>

    <hr>
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
            'heading' => "<i class='fas fa-bullhorn'></i> Ogłoszenia"
        ]
    ]) ?>
</div>