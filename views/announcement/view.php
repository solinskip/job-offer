<?

use kartik\detail\DetailView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Announcement */

$this->title = $model->name;

?>
<div class="announcement-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'Ogłoszenie: ' . $this->title ?></h2>
        </div>
        <div class="col-sm-3 text-right pr-0">
            <?= Html::a('<i class="fas fa-edit"></i> Aktualizuj', ['update', 'id' => $model->id], ['class' => 'btn modal-sub']) ?>
            <?= Html::a('<i class="fas fa-trash-alt"></i> Usuń', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Czy na pewno chcesz usunąć to ogłoszenie?',
                    'method' => 'post'
                ]
            ]) ?>
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
                'responsibilities:ntext',
                'description:ntext',
                [
                    'attribute' => 'active',
                    'format' => 'raw',
                    'value' => '<span style ="font-size: 18px" class="badge badge-' . ($model->active ? 'success' : 'danger') . '">' . ($model->active ? 'Tak' : 'Nie') . '</span>',
                ]
            ]
        ]) ?>
    </div>
</div>