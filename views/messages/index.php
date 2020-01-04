<?

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\MessagesSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */

use app\models\Messages;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Wiadomości';

?>
<div class="messages-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <hr>

    <? $gridColumn = [
        ['class' => 'kartik\grid\SerialColumn']
    ];

    if (Yii::$app->controller->action->id === 'employer-index') {
        $gridColumn[] = [
            'attribute' => 'id_user_from',
            'format' => 'raw',
            'width' => '200px',
            'value' => static function (Messages $model) {
                $readMessage = $model->isRead ? null : 'Nowa!';

                return '<div style="position: relative">
                        <div style="width: 90%">' . Html::a($model->fromUser->username, Url::to(['/employee/index', 'id' => $model->fromUser->employeeProfile->id]), ['data-pjax' => 0]) . '</div>
                        <div style="position: absolute; right: 5px; top: 0"><span class="badge badge-warning">' . $readMessage . '</span></div>
                    </div>';
            }
        ];
    }
    if (Yii::$app->controller->action->id === 'employee-index') {
        $gridColumn[] = [
            'attribute' => 'id_user_to',
            'format' => 'raw',
            'value' => static function (Messages $model) {
                return Html::a($model->toUser->username, Url::to(['/employer/index', 'id' => $model->toUser->employerProfile->id]));
            }
        ];
    }

    $gridColumn = array_merge($gridColumn, [
        [
            'attribute' => 'id_announcement',
            'value' => static function (Messages $model) {
                return $model->announcement->name;
            }
        ],
        [
            'attribute' => 'message',
            'value' => static function (Messages $model) {
                // Display only first 30 characters of message
                $beginOfMessage = substr($model->message, 0, 30);
                if (strlen($beginOfMessage) === 30) {
                    $beginOfMessage .= '...';
                }

                return $beginOfMessage;
            }
        ],
        [
            'attribute' => 'internshipRequest',
            'format' => 'raw',
            'hAlign' => 'center',
            'value' => static function (Messages $model) {
                return $model->internshipRequestHtml;
            }
        ]
    ]);

    $gridColumn = array_merge($gridColumn, [
        'created_at',
        [
            'class' => 'kartik\grid\ActionColumn',
            'header' => 'Akcje',
            'template' => '{view}',
        ]
    ]); ?>
    <?= GridView::widget([
        'id' => 'messages-list',
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
            'heading' => "<i class='fas fa-envelope'></i> " . (Yii::$app->controller->action->id === 'employee-index' ? 'Wysłane wiadomości' : 'Otrzymane wiadomości'),
        ]
    ]) ?>

</div>
