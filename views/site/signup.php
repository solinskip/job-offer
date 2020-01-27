<?

use kartik\form\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

?>

<div class="row singup-form ajax-form">
    <div class="col-sm-10 offset-1">
        <? Pjax::begin(['id' => 'form-signup-pjax']) ?>

        <? $form = ActiveForm::begin([
            'id' => 'form-signup',
            'enableAjaxValidation' => true,
            'validationUrl' => Url::to(['site/validate-form', 'model' => get_class($model), 'scenario' => $model->scenario]),
            'errorCssClass' => 'text-danger',
        ]); ?>

        <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput(['autocomplete' => 'new-password']) ?>

        <? if ($model->scenario === 'signup') : ?>
            <?= $form->field($model, 'account_type')->radioList([1 => 'Pracodawca', 2 => 'Pracownik'], ['inline' => true]) ?>
            <?= $form->field($model, 'policy1')->checkbox(['label' => 'Akceptuje warunki korzystania ze strony.']) ?>
            <?= $form->field($model, 'policy2')->checkbox(['label' => 'Zgadzam się na przetwarzanie moich danych osobowych.']) ?>
        <? endif; ?>

        <hr>

        <?= Html::submitButton('Rejestracja', ['class' => 'btn float-right px-3 modal-sub']) ?>

        <? ActiveForm::end(); ?>

        <? Pjax::end() ?>
    </div>
</div>
<style>
    .form-group {
        margin: 0;
    }
</style>