<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\EmployerProfile */

$this->title = 'Create Employer Profile';
$this->params['breadcrumbs'][] = ['label' => 'Employer Profile', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employer-profile-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
