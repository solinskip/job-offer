<?

use kartik\widgets\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Messages */
/* @var $form yii\widgets\ActiveForm */

?>
<div class="messages-form">
    <? $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'message')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'attachment')->widget(FileInput::class, [
        'name' => 'attachment',
        'options' => ['accept' => 'application/pdf'],
        'pluginOptions' => [
            'allowedFileExtensions' => ['pdf'],
            'showPreview' => false,
            'showCaption' => true,
            'showRemove' => false,
            'showUpload' => false,
            'overwriteInitial' => true,
            'browseIcon' => '<i class="fas fa-file"></i> ',
            'browseLabel' => 'Wybierz załącznik',
        ]
    ]) ?>

    <hr>
    <div class="form-group text-right">
        <?= Html::submitButton('Wyślij', ['class' => 'btn modal-sub']) ?>
    </div>

    <? ActiveForm::end(); ?>
</div>