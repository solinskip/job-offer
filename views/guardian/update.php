<?

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EmployeeProfile */

$this->title = 'Aktualizacja profilu opiekuna:' . ' ' . $model->name . ' ' . $model->surname

?>
<div class="guardian-profile-update">
    <h1><?= Html::encode($this->title) ?></h1>
    <hr>
    <?= $this->render('_form', [
        'model' => $model
    ]) ?>
</div>