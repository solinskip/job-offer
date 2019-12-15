<?

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\AnnouncementSearch */

/* @var $dataProviderAnnouncement yii\data\ActiveDataProvider */
/* @var $dataProviderEmployer yii\data\ActiveDataProvider */

/* @var $dataProviderEmployee yii\data\ActiveDataProvider */

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Panel administratora';

?>
<div class="admin-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <hr>

    <?= GridView::widget([
        'id' => 'announcements-list',
        'dataProvider' => $dataProviderAnnouncement,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
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
                'hAlign' => 'center',
                'value' => static function ($model) {
                    return '<span style="font-size: 15px" class="badge badge-' . ($model->active ? 'success' : 'danger') . '">' . ($model->active ? 'Tak' : 'Nie') . '</span>';

                }
            ],
            'created_at',
            [
                'class' => 'kartik\grid\ActionColumn',
                'header' => 'Akcje',
                'width' => '85px',
                'template' => '{view} {update} {delete}',
                'urlCreator' => static function ($action, /** @noinspection PhpUnusedParameterInspection */ $model, $key) {
                    return Url::to(['/announcement/' . $action, 'id' => $key]);
                }
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
            'heading' => "<i class='fas fa-bullhorn'></i> " . 'Lista wszystkich ogłoszeń',
        ]
    ]) ?>

    <?= GridView::widget([
        'id' => 'employer-list',
        'dataProvider' => $dataProviderEmployer,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            'user.username',
            'name',
            'address',
            'industry',
            'phone',
            'email',
            'fax'
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
            'heading' => "<i class='fas fa-user'></i> " . 'Lista wszystkich pracodawców',
        ]
    ]) ?>

    <?= GridView::widget([
        'id' => 'employee-list',
        'dataProvider' => $dataProviderEmployee,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            'user.username',
            'name',
            'surname',
            'email',
            'birth_date',
            'phone'
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
            'heading' => "<i class='fas fa-user'></i> " . 'Lista wszystkich pracowników',
        ]
    ]) ?>
</div>