<?

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\InternshipSearch */
/* @var $modelAnnouncement app\models\Announcement */

/* @var $dataProvider yii\data\ActiveDataProvider */

use app\models\Internship;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Lista chętnych: ' . $modelAnnouncement->name;

?>
<div class="internship-willing-list-index">
    <div class="row">
        <div class="col-sm-7"><h1><?= Html::encode($this->title) ?></h1></div>
        <div class="col-md-5 text-right">
            <?= Html::a('<i class="fas fa-edit"></i> Aktualizuj', Url::to(['/internship/admission-list', 'id_announcement' => $modelAnnouncement->id]), ['class' => 'btn modal-sub']) ?>
        </div>
    </div>
    <hr class="mt-1">

    <? $gridColumn = [
        ['class' => 'kartik\grid\SerialColumn'],
        [
            'label' => 'Nazwa użytkownika',
            'format' => 'raw',
            'value' => static function (Internship $model) {
                return Html::a($model->employee->username, Url::to(['/employee/index', 'id' => $model->employee->employeeProfile->id]));
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
            'label' => 'Telefon Kom.',
            'value' => static function (Internship $model) {
                return $model->employee->employeeProfile->phone;
            }
        ],
        [
            'attribute' => 'id_guardian',
            'value' => static function (Internship $model) {
                return isset($model->guardian) ? $model->guardian->username : null;
            }
        ],
        [
            'attribute' => 'accepted',
            'format' => 'raw',
            'value' => static function (Internship $model) {
                return $model->acceptedHtml;
            },
            'hAlign' => 'center'
        ],
        [
            'label' => 'Wysłano',
            'value' => static function (Internship $model) {
                return $model->messages->created_at;
            }
        ],
        [
            'class' => 'kartik\grid\ActionColumn',
            'urlCreator' => static function ($action, Internship $model) {
                return Url::to(['/messages/' . $action, 'id' => $model->id_messages]);
            },
            'header' => 'Akcje',
            'template' => '{view}',
        ]
    ]; ?>

    <?= GridView::widget([
        'id' => 'internship-willing-list',
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
            'heading' => "<i class='fas fa-list'></i> Lista chętnych",
        ]
    ]) ?>
</div>