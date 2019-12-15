<? /** @var $model \app\models\Announcement */

use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="row">
    <div class="col-md-6 title-announcement"><?= Html::a($model->name, Url::to(['announcement/view', 'id' => $model->id]), []) ?></div>
    <div class="col-md-6 text-right"><span class="badge badge-dark"> <?= $model->created_at?></span></div>
    <div class="col-md-12 company-name-announcement"><?=$model->createdBy->employerProfile->name ?></div>
    <div class="col-md-3"><i class="fas fa-map-marker-alt"></i> <?=$model->place ?></div>
    <div class="col-md-6"><i class="fas fa-hand-holding-usd"></i> <?=$model->salary ?> zł. brutto/mies.</div>
    <div class="col-md-12"><i class="fas fa-user"></i> <?=$model->position ?></div>
</div>