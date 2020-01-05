<?

use kartik\widgets\ActiveForm;
use mootensai\components\JsBlock;
use yii\helpers\Html;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $rows app\models\InternshipDiary[] */
/* @var $form yii\widgets\ActiveForm */

JsBlock::widget(['viewFile' => '_script', 'pos' => View::POS_HEAD,
    'viewParams' => [
        'class' => 'InternshipDiary',
        'relID' => 'internship-diary'
    ]
]); ?>

<div id="internship-diary">
    <? $form = ActiveForm::begin(['options' => ['id' => 'internship-diary-form']]) ?>

    <div id="add-internship-diary">
        <?= $this->render('_formInternshipDiary', ['rows' => $rows, 'form' => $form]) ?>
    </div>

    <hr>
    <div class="form-group text-center pt-2">
        <?= Html::submitButton('Zapisz', ['id' => 'te', 'class' => 'btn modal-sub']) ?>
    </div>
    <? ActiveForm::end(); ?>
</div>