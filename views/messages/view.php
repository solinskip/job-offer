<?

use app\models\Messages;
use app\models\Upload;
use kartik\detail\DetailView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Messages */

$this->title = 'Wiadomość';

?>
<div class="messages-view">
    <div class="row">
        <div class="col-sm-9">
            <? if (Yii::$app->user->identity->isEmployee) : ?>
                <h2><?= 'Wiadomość wysłana do: ' . ' ' . $model->toUser->username ?></h2>
            <? endif; ?>
            <? if (Yii::$app->user->identity->isEmployer) : ?>
                <h2><?= 'Wiadomość od: ' . ' ' . $model->fromUser->username ?></h2>
            <? endif; ?>
        </div>
    </div>

    <hr class="mt-0 mb-4">

    <div class="row"
         <?= DetailView::widget([
             'model' => $model,
             'attributes' => [
                 [
                     'attribute' => 'announcement',
                     'value' => $model->announcement->name
                 ],
                 'message:ntext',
                 [
                     'attribute' => 'internshipRequest',
                     'format' => 'raw',
                     'value' => $model->internshipRequestHtml
                 ],
                 'created_at',
                 [
                     'attribute' => 'attachment',
                     'format' => 'raw',
                     'value' => call_user_func(static function (Messages $model) {
                         $fileLink = Upload::fileLink('attachments', $model->id_user_from . '-' . $model->id, 'attachment.pdf');

                         return $fileLink ? Html::a('Załącznik', $fileLink, []) : 'Brak';
                     }, $model)


                 ]
             ],
             'striped' => false,
             'condensed' => true,
             'hover' => true,
         ]) ?>
</div>
</div>