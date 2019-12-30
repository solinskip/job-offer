<?

use app\models\Upload;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use kartik\widgets\FileInput;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\EmployerProfile */
/* @var $form yii\widgets\ActiveForm */

?>
<div class="employer-profile-form">
    <? $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-4">
            <? $file = Upload::fileLink('profile_images', Yii::$app->user->id, 'profile_image.jpg') ?>
            <?= $form->field($model, 'profile_image', ['options' => ['class' => 'col-md-12']])->widget(FileInput::class, [
                'name' => 'profile_image',
                'options' => ['accept' => 'image'],
                'pluginOptions' => [
                    'initialPreview' => $file ? [$file] : '<i class="fas fa-user-tie fa-10x pt-4" style="color: #343a40"></i>',
                    'initialPreviewConfig' => [
                        ['key' => Yii::$app->user->id, 'extra' => ['dir' => 'profile_images', 'fileName' => 'profile_image.jpg']]
                    ],
                    'deleteUrl' => Url::to('/site/delete-file'),
                    'initialPreviewAsData' => $file ? true : false,
                    'allowedFileExtensions' => ['jpg'],
                    'dropZoneEnabled' => false,
                    'frameClass' => 'krajee-default w-95',
                    'showClose' => false,
                    'showCaption' => false,
                    'showRemove' => false,
                    'showUpload' => false,
                    'browseClass' => 'btn btn-primary btn-block',
                    'overwriteInitial' => true,
                    'browseIcon' => '<i class="fas fa-camera"></i> ',
                    'browseLabel' => 'Wybierz zdjęcie',
                    'fileActionSettings' => [
                        'showZoom' => false,
                        'showRemove' => $file ? true : false,
                        'removeIcon' => '<i class="fas fa-trash"></i>',
                        'removeClass' => 'btn btn-sm btn-kv btn-default btn-outline-secondary removeAttachment',
                    ]
                ]
            ]) ?>
        </div>
        <div class="col-md-8">
            <div class="row">
                <?= $form->field($model, 'name', ['options' => ['class' => 'col-md-12']])->textInput(['maxlength' => true, 'placeholder' => 'Imię']) ?>
                <?= $form->field($model, 'surname', ['options' => ['class' => 'col-md-12']])->textInput(['maxlength' => true, 'placeholder' => 'Nazwisko']) ?>
                <?= $form->field($model, 'birth_date', ['options' => ['class' => 'col-md-12']])->widget(DateControl::class, [
                    'saveFormat' => 'php:Y-m-d'
                ]) ?>
                <?= $form->field($model, 'phone', ['options' => ['class' => 'col-md-6']])->textInput(['placeholder' => 'Telefon kom.']) ?>
                <?= $form->field($model, 'email', ['options' => ['class' => 'col-md-6']])->textInput(['maxlength' => true, 'placeholder' => 'Email']) ?>
            </div>
        </div>


        <?= $form->field($model, 'experience', ['options' => ['class' => 'col-md-12']])->textarea(['rows' => 4]) ?>
        <?= $form->field($model, 'education', ['options' => ['class' => 'col-md-12']])->textarea(['rows' => 4]) ?>
        <?= $form->field($model, 'courses', ['options' => ['class' => 'col-md-12']])->textarea(['rows' => 4]) ?>
        <?= $form->field($model, 'information', ['options' => ['class' => 'col-md-12']])->textarea(['rows' => 4]) ?>
    </div>

    <hr>

    <div class="form-group text-right">
        <?= Html::submitButton('Zapisz', ['class' => 'btn modal-sub']) ?>
    </div>

    <? ActiveForm::end(); ?>
</div>