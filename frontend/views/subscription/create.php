<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Subscription $model */

$this->title = \Yii::t('app', 'Subscribe');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subscription-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'authors' => $authors,
    ]) ?>

</div>
