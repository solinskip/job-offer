<?

/* @var $this yii\web\View */

/* @var $dataProvider yii\data\ActiveDataProvider */

use app\models\Internship;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Staże';

?>
<div class="guardian">
    <h1><?= Html::encode($this->title) ?></h1>

    <hr>

    <? $gridColumn = [
        ['class' => 'kartik\grid\SerialColumn'],
        [
            'label' => 'Pracownik',
            'value' => static function (Internship $model) {
                return Html::a($model->employee->username, Url::to(['/employee/index', 'id' => $model->employee->employeeProfile->id]));
            },
            'format' => 'raw'
        ],
        [
            'label' => 'Ogłoszenie',
            'value' => static function (Internship $model) {
                return Html::a($model->announcement->name, Url::to(['/announcement/view', 'id' => $model->announcement->id]));
            },
            'format' => 'raw'
        ],
        [
            'label' => 'Nr. indexu',
            'value' => static function (Internship $model) {
                return $model->employee->employeeProfile->index_number;
            }
        ],
        [
            'label' => 'Symbol roku',
            'value' => static function (Internship $model) {
                return $model->employee->employeeProfile->symbol_of_year;
            }
        ],
        [
            'label' => 'Imię',
            'value' => static function (Internship $model) {
                return $model->employee->employeeProfile->name;
            }
        ],
        [
            'label' => 'Nazwisko',
            'value' => static function (Internship $model) {
                return $model->employee->employeeProfile->surname;
            }
        ],
        [
            'label' => 'Email',
            'value' => static function (Internship $model) {
                return $model->employee->employeeProfile->email;
            }
        ],
        [
            'label' => 'Wysłane',
            'format' => 'raw',
            'value' => static function (Internship $model) {
                return '<span style="font-size: 15px" class="badge badge-' . ($model->isSent ? 'success' : 'danger') . '">' . ($model->isSent ? 'Tak' : 'Nie') . '</span>';
            },
            'hAlign' => 'center'
        ],
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
        'id' => 'guardian-list',
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
            'heading' => "<i class='fas fa-list'></i> Zakończone staże"
        ]
    ]) ?>
</div>