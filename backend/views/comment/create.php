<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var \common\models\BaseComment $model */

$this->title = 'Create BaseComment';
$this->params['breadcrumbs'][] = ['label' => 'Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
