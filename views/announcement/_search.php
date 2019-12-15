<?

use app\models\Announcement;
use kartik\field\FieldRange;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\search\AnnouncementSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-announcement-search">
    <h2>Zaawansowane wyszukiwanie</h2>
    <? $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get'
    ]); ?>

    <div class="row">
        <?= $form->field($model, 'name', ['options' => ['class' => 'col-md-12']])->textInput(['maxlength' => true, 'placeholder' => 'Podaj nazwę...']) ?>
        <?= $form->field($model, 'place', ['options' => ['class' => 'col-md-3']])->textInput(['maxlength' => true, 'placeholder' => 'Podaj miejsce...']) ?>
        <?= $form->field($model, 'position', ['options' => ['class' => 'col-md-3'],])->widget(Select2::class, [
            'data' => Announcement::listOfPositions(),
            'options' => [
                'placeholder' => 'Wybierz...'
            ],
            'hideSearch' => true
        ]) ?>
        <div class="col-md-6">
            <?= FieldRange::widget([
                'form' => $form,
                'model' => $model,
                'label' => 'Zakres wynagrodzenia',
                'attribute1' => 'fromSalary',
                'attribute2' => 'toSalary',
                'separator' => '<i class="fas fa-arrows-alt-h px-2"></i>',
                'type' => FieldRange::INPUT_WIDGET,
                'widgetClass' => \kartik\widgets\TouchSpin::class,
                'widgetOptions1' => [
                    'pluginOptions' => [
                        'min' => 0,
                        'max' => 100000,
                    ]
                ],
                'widgetOptions2' => [
                    'pluginOptions' => [
                        'min' => 0,
                        'max' => 100000,
                    ]
                ]
            ]) ?>
        </div>
    </div>

    <hr>

    <div class="form-group text-right mt-4">
        <?= Html::submitButton('Wyszukaj', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Wyczyść', ['class' => 'btn btn-default']) ?>
    </div>

    <? ActiveForm::end(); ?>
</div>