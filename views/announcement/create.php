<?

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Announcement */

$this->title = 'Utwórz ogłoszenie';

?>
<div class="announcement-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <hr>

    <?= $this->render('_form', [
        'model' => $model
    ]) ?>
</div>