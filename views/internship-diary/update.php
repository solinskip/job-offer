<?

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $modelInternship app\models\Internship */
/* @var $rows app\models\InternshipDiary[] */

$this->title = 'Aktualizacja dziennika: ' . ' ' . $modelInternship->announcement->name;

?>
<div class="internship-diary-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <hr class="mt-1">

    <?= $this->render('_form', [
        'rows' => $rows,
    ]) ?>
</div>