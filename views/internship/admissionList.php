<?

/**
 * @var Internship[] $model
 */

use app\models\Internship;
use kartik\builder\TabularForm;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

$dataProvider = new ArrayDataProvider([
    'allModels' => $model,
    'pagination' => [
        'pageSize' => -1
    ]
]);

$attributes = [
    'id' => ['type' => 'hiddenInput', 'columnOptions' => ['hidden' => true]],
    'id_employee' => [
        'type' => TabularForm::INPUT_STATIC,
        'columnOptions' => ['width' => '40%'],
        'value' => static function (Internship $model) {
            return $model->employee->employeeProfile->name . ' ' . $model->employee->employeeProfile->surname;
        }
    ],
    'id_guardian' => [
        'columnOptions' => ['width' => '40%'],
        'widgetClass' => Select2::class,
        'options' => static function (Internship $model) {
            return [
                'initValueText' => isset($model->guardian) ? $model->guardian->username : false,
                'options' => ['placeholder' => 'Wybierz...'],
                'pluginOptions' => [
                    'ajax' => [
                        'url' => Url::to(['site/ajax-list', 'type' => 'internshipGuardian']),
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                    ],
                    'allowClear' => true
                ]
            ];
        }
    ],
    'accepted' => [
        'columnOptions' => ['width' => '15%'],
        'widgetClass' => Select2::class,
        'options' => [
            'data' => [0 => 'Nie', 1 => 'Tak'],
            'options' => ['placeholder' => 'Wybierz...'],
            'hideSearch' => true
        ]
    ]
] ?>

<? $form = ActiveForm::begin(['options' => ['id' => 'internship-admission-list']]) ?>

<?= TabularForm::widget([
    'dataProvider' => $dataProvider,
    'form' => $form,
    'checkboxColumn' => false,
    'actionColumn' => false,
    'attributeDefaults' => [
        'type' => TabularForm::INPUT_WIDGET,
        'columnOptions' => ['hAlign' => GridView::ALIGN_LEFT, 'vAlign' => 'middle']
    ],
    'attributes' => $attributes,
    'gridSettings' => [
        'id' => 'internship-admission-list-grid',
        'panel' => [
            'heading' => false,
            'before' => '<h2><i class="fas fa-list"></i> Lista przyjęć</h2>',
            'footer' => false,
            'after' => false
        ]
    ]
]) ?>

<hr>

    <div class="form-group text-center pt-2">
        <?= Html::submitButton('Zapisz', ['class' => 'btn modal-sub']) ?>
    </div>

<? ActiveForm::end(); ?>