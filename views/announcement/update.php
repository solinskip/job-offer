<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Announcement */

$this->title = 'Aktualizacja ogłoszenia: ' . $model->name;

?>
<div class="announcement-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <hr>

    <?= $this->render('_form', [
        'model' => $model
    ]) ?>
</div>
