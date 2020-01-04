<?

use app\models\Announcement;
use kartik\datecontrol\DateControl;
use kartik\widgets\Select2;
use kartik\widgets\SwitchInput;
use kartik\widgets\TouchSpin;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Announcement */
/* @var $form yii\widgets\ActiveForm */

?>
<div class="announcement-form">
    <? $form = ActiveForm::begin(); ?>

    <div class="row">
        <?= $form->field($model, 'name', ['options' => ['class' => 'col-md-12']])->textInput(['maxlength' => true, 'placeholder' => 'Podaj nazwę...']) ?>
        <?= $form->field($model, 'place', ['options' => ['class' => 'col-md-4']])->textInput(['maxlength' => true, 'placeholder' => 'Podaj miejsce...']) ?>
        <?= $form->field($model, 'position', ['options' => ['class' => 'col-md-4'],])->widget(Select2::class, [
            'data' => Announcement::listOfPositions(),
            'options' => [
                'placeholder' => 'Wybierz...'
            ]
        ]) ?>
        <?= $form->field($model, 'salary', ['options' => ['class' => 'col-md-4']])->widget(TouchSpin::class, [
            'options' => [
                'placeholder' => 'Podaj wynagrodzenie...'
            ],
            'pluginOptions' => [
                'min' => 0,
                'max' => 100000,
                'postfix' => 'zł',
                'buttondown_class' => 'btn btn-primary',
                'buttonup_class' => 'btn btn-primary',
                'buttondown_txt' => '<i class="fa fa-minus"></i>',
                'buttonup_txt' => '<i class="fa fa-plus"></i>'
            ]
        ]) ?>
        <?= $form->field($model, 'start_date', ['options' => ['class' => 'col-md-6']])->widget(DateControl::class, [
            'saveFormat' => 'php:Y-m-d'
        ]) ?>
        <?= $form->field($model, 'end_date', ['options' => ['class' => 'col-md-6']])->widget(DateControl::class, [
            'saveFormat' => 'php:Y-m-d'
        ]) ?>
        <?= $form->field($model, 'responsibilities', ['options' => ['class' => 'col-md-12']])->textarea(['rows' => 6, 'placeholder' => 'Podaj obowiązki...']) ?>
        <?= $form->field($model, 'description', ['options' => ['class' => 'col-md-12']])->textarea(['rows' => 6, 'placeholder' => 'Podaj opis stanowiska...']) ?>
        <? if (!$model->isNewRecord) : ?>
            <?= $form->field($model, 'active', ['options' => ['class' => 'col-md-12 text-center']])->widget(SwitchInput::class, [
                'pluginOptions' => [
                    'onText' => 'Tak',
                    'offText' => 'Nie'
                ]]) ?>
        <? endif; ?>
    </div>

    <hr>

    <div class="form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? 'Utwórz' : 'Aktualizuj', ['class' => 'btn modal-sub']) ?>
    </div>

    <? ActiveForm::end(); ?>
</div>