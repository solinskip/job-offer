<?php

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\AnnouncementSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */

use app\models\Announcement;
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;

$this->title = 'Ogłoszenia';

?>
<div class="announcement-index">
    <div class="row mt-3">
        <div class="col-md-6">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="col-md-6 text-right">
            <? if (Yii::$app->user->identity->isEmployer) : ?>
                <?= Html::a('<i class="far fa-plus-square"></i> Utwórz ogłoszenie', ['create'], ['class' => 'btn btn-success']) ?>
            <? endif; ?>
            <?= Html::a('<i class="fas fa-filter"></i> Wyszukiwanie', '#', ['class' => 'btn btn-info search-button']) ?>
        </div>
    </div>

    <hr class="mt-0 mb-5">

    <div class="search-form mb-5" style="display:none">
        <?= $this->render('_search', ['model' => $searchModel]) ?>
    </div>

    <? Pjax::begin(['id' => 'list-view-pjax', 'timeout' => 5000, 'enablePushState' => false, 'enableReplaceState' => false]); ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => function (Announcement $model) {
            return $this->render('item', ['model' => $model]);
        },
        'separator' => '<hr>',
        'summary' => false
    ]) ?>

    <? Pjax::end() ?>
</div>
<script>
    $('.search-button').click(function () {
        $('.search-form').toggle(1000);
        return false;
    });

    if ($('#announcementsearch-name').val() !== ''
        || $('#announcementsearch-place').val() !== ''
        || $('#announcementsearch-position').val() !== ''
        || $('#announcementsearch-fromsalary').val() !== ''
        || $('#announcementsearch-tosalary').val() !== ''
    ) {
        $('.search-form').show();
    }
</script>