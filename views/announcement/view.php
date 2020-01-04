<?

use kartik\detail\DetailView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Announcement */

$this->title = $model->name;

?>
<div class="announcement-view">

    <div class="row">
        <div class="col-sm-7">
            <h2><?= 'Ogłoszenie: ' . $this->title ?></h2>
        </div>
        <div class="col-sm-5 text-right">
            <? if ($model->created_by === Yii::$app->user->id || Yii::$app->user->identity->isAdministrator) : ?>
                <?= Html::a('<i class="fas fa-list"></i> Lista chętnych', Url::to(['internship/willing-list', 'id_announcement' => $model->id]), ['class' => 'btn modal-sub']) ?>
                <?= Html::a('<i class="fas fa-edit"></i> Aktualizuj', Url::to(['update', 'id' => $model->id]), ['class' => 'btn modal-sub']) ?>
                <?= Html::a('<i class="fas fa-trash-alt"></i> Usuń', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Czy na pewno chcesz usunąć to ogłoszenie?',
                        'method' => 'post'
                    ]
                ]) ?>
            <? endif; ?>
            <? if (Yii::$app->user->identity->isEmployee) : ?>
                <?= Html::a('<i class="fas fa-envelope"></i> Wyślij wiadomość', false, [
                    'class' => 'btn modal-sub loadAjaxContent',
                    'value' => Url::to(['/messages/create', 'id_user_to' => $model->created_by, 'id_announcement' => $model->id]),
                    'icon' => '<i class="fas fa-envelope"></i>',
                    'modaltitle' => 'Wyślij wiadomość'
                ]) ?>
            <? endif; ?>
        </div>
    </div>

    <hr class="mt-2">

    <div class="row mt-4">
        <?= DetailView::widget([
            'model' => $model,
            'striped' => false,
            'condensed' => true,
            'hover' => true,
            'attributes' => [
                'place',
                'position',
                [
                    'attribute' => 'salary',
                    'value' => $model->salary . ' zł. brutto/mies.',

                ],
                'start_date',
                'end_date',
                'responsibilities:ntext',
                'description:ntext'
            ]
        ]) ?>
    </div>
</div>