<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Subscription $model */
/** @var common\models\Author[] $authors */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="subscription-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'author_id')->dropDownList(\yii\helpers\ArrayHelper::map($authors, 'id', 'full_name')) ?>

    <?= $form->field($model, 'phone')->textInput([
        'placeholder' => '+7XXXXXXXXXX',
        'type' => 'tel',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton(\Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>