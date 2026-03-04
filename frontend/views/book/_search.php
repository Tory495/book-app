<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\BookSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="book-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id')->label(\Yii::t('app', 'ID')) ?>

    <?= $form->field($model, 'title')->label(\Yii::t('app', 'Title')) ?>

    <?= $form->field($model, 'year')->label(\Yii::t('app', 'Year')) ?>

    <?= $form->field($model, 'description')->label(\Yii::t('app', 'Description')) ?>

    <?= $form->field($model, 'isbn')->label(\Yii::t('app', 'ISBN')) ?>

    <?php // echo $form->field($model, 'image') ?>

    <div class="form-group">
        <?= Html::submitButton(\Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(\Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
