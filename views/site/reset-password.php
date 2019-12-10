<?

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\form\ActiveForm;

?>

<div class="row reset-password-form ajax-form">
    <div class="col-sm-10 offset-1">
        <? Pjax::begin(['id' => 'form-reset-password-pjax']) ?>

        <? $form = ActiveForm::begin([
            'id' => 'form-reset-password',
            'enableAjaxValidation' => true,
            'enableClientValidation' => true,
            'validationUrl' => Url::to(['validate-form', 'model' => get_class($model)]),
            'errorCssClass' => 'text-danger',
        ]); ?>

        <?= $form->field($model, 'current_password')->passwordInput(['autofocus' => true]) ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'password_repeat')->passwordInput() ?>

        <hr>

        <?= Html::submitButton('Zapisz', ['class' => 'btn float-right px-3 modal-sub']) ?>

        <? ActiveForm::end(); ?>

        <? Pjax::end() ?>
    </div>
</div>