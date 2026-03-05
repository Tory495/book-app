<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Author $model */

$this->title = $model->full_name;
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Authors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="author-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (\Yii::$app->user->can('updateAuthor') || \Yii::$app->user->can('deleteAuthor')): ?>
        <p>
            <?php if (\Yii::$app->user->can('updateAuthor')): ?>
                <?= Html::a(\Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?php endif; ?>
            <?php if (\Yii::$app->user->can('deleteAuthor')): ?>
                <?= Html::a(\Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => \Yii::t('app', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]) ?>
            <?php endif; ?>
        </p>
    <?php endif; ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id' => [
                'attribute' => 'id',
                'label' => \Yii::t('app', 'ID'),
            ],
            'full_name' => [
                'attribute' => 'full_name',
                'label' => \Yii::t('app', 'Full Name'),
            ],
        ],
    ]) ?>

</div>