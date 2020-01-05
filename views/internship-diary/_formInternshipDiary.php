<?

/* @var $rows app\models\InternshipDiary[] */

use kartik\builder\TabularForm;
use kartik\datecontrol\DateControl;
use kartik\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;

$dataProvider = new ArrayDataProvider([
    'allModels' => $rows,
    'modelClass' => \app\models\InternshipDiary::class,
    'pagination' => [
        'pageSize' => -1
    ]
]); ?>


<?= TabularForm::widget([
    'dataProvider' => $dataProvider,
    'form' => $form,
    'formName' => 'InternshipDiary',
    'checkboxColumn' => false,
    'actionColumn' => false,
    'attributeDefaults' => [
        'type' => TabularForm::INPUT_WIDGET,
        'columnOptions' => ['hAlign' => GridView::ALIGN_LEFT, 'vAlign' => 'middle']
    ],
    'attributes' => [
        'id' => ['type' => 'hiddenInput', 'columnOptions' => ['hidden' => true]],
        'description' => [
            'type' => 'textInput',
            'label' => 'a',
            'columnOptions' => ['width' => '60%'],
        ],
        'date' => [
            'columnOptions' => ['width' => '20%'],
            'widgetClass' => DateControl::class,
            'options' => static function () {
                return [
                    'saveFormat' => 'php:Y-m-d'
                ];
            }
        ],
        'working_hours' => [
            'type' => TabularForm::INPUT_TEXT,
            'columnOptions' => ['width' => '20%'],
        ],
        'del' => [
            'type' => 'raw',
            'label' => '',
            'columnOptions' => ['width' => '20px'],
            'value' => static function ($model, $key) {
                return Html::a('<i class="far fa-trash-alt fa-2x"></i>', '#', [
                    'title' => 'Usuń',
                    'onClick' => "delRowInternshipDiary({$key}); return false;",
                    'id' => 'internship-diary-del-btn'
                ]);
            }
        ]
    ],
    'gridSettings' => [
        'id' => 'internship-diary-grid',
        'panel' => [
            'heading' => false,
            'before' => '<h2><i class="fas fa-list"></i> Dziennik stażu</h2>',
            'footer' => false,
            'after' => Html::button('<i class="fas fa-plus"></i> Dodaj wiersz', [
                'type' => 'button',
                'id' => 'addRow',
                'class' => 'btn btn-primary kv-batch-create',
                'onClick' => 'addRowInternshipDiary()'
            ])
        ]
    ]
]) ?>