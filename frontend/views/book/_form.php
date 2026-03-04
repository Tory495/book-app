<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Book $model */
/** @var yii\widgets\ActiveForm $form */
/** @var string $imageUrl */
?>

<div class="book-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label(\Yii::t('app', 'Title')) ?>

    <?= $form->field($model, 'year')->input('number')->label(\Yii::t('app', 'Year')) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6])->label(\Yii::t('app', 'Description')) ?>

    <?= $form->field($model, 'isbn')->textInput(['maxlength' => true])->label(\Yii::t('app', 'ISBN')) ?>

    <?php if ($imageUrl): ?>
        <div class="current-image mt-2 mb-3">
            <span class="d-block mb-1"><?= \Yii::t('app', 'Current image') ?></span>
            <img src="<?= Html::encode($imageUrl) ?>" alt="" class="rounded border" style="max-height: 120px; max-width: 120px; object-fit: cover;">
        </div>
    <?php endif; ?>

    <?= $form->field($model, 'image')->fileInput()->label(\Yii::t('app', 'Image')) ?>

    <?= $form->field($model, 'author_ids')->widget(\kartik\select2\Select2::class, [
        'data' => \yii\helpers\ArrayHelper::map(\common\models\Author::find()->all(), 'id', 'full_name'),
        'options' => [
            'placeholder' => \Yii::t('app', 'Select authors...'),
            'multiple' => true,
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ])->label(\Yii::t('app', 'Authors')); ?>

    <div class="form-group">
        <?= Html::submitButton(\Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
