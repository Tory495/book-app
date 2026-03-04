<?php

use yii\helpers\Html;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\Author[] $authors */
/** @var int $targetYear */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = \Yii::t('app', 'Top 10 Authors') . ' ' . $targetYear;
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Authors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="author-top-filter mb-4">
    <div class="card card-body bg-light">
        <!-- Форма GET-запросом, чтобы можно было делиться ссылкой на отчет -->
        <?= Html::beginForm(['author/top-authors'], 'get', ['class' => 'row g-3 align-items-center']) ?>
            <div class="col-auto">
                <label for="year-input" class="col-form-label"><strong><?= \Yii::t('app', 'Select year:') ?></strong></label>
            </div>

            <div class="col-auto">
                <?= Html::input('number', 'year', $targetYear, [
                    'id' => 'year-input',
                    'class' => 'form-control',
                    'min' => 1900,
                    'max' => date('Y'),
                    'step' => 1,
                    'required' => true
                ]) ?>
            </div>
            
            <div class="col-auto">
                <?= Html::submitButton(\Yii::t('app', 'Search top 10'), ['class' => 'btn btn-primary']) ?>
            </div>
            
            <div class="col-auto">
                <?= Html::a(\Yii::t('app', 'Reset'), ['top-authors'], ['class' => 'btn btn-outline-secondary']) ?>
            </div>

        <?= Html::endForm() ?>
    </div>
</div>


<div class="top-authors-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'full_name',
            [
                'attribute' => 'books_count',
                'label' => \Yii::t('app', 'Books count'),
                'value' => function($model) {
                    return $model->books_count ?: 0;
                }
            ],
        ],
    ]); ?>


</div>
