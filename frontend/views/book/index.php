<?php

use common\models\Book;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\BookSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = \Yii::t('app', 'Books');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(\Yii::t('app', 'Create Book'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id' => [
                'attribute' => 'id',
                'label' => \Yii::t('app', 'ID'),
            ],
            'title' => [
                'attribute' => 'title',
                'label' => \Yii::t('app', 'Title'),
            ],
            'year' => [
                'attribute' => 'year',
                'label' => \Yii::t('app', 'Year'),
            ],
            'description' => [
                'attribute' => 'description',
                'label' => \Yii::t('app', 'Description'),
            ],
            'isbn' => [
                'attribute' => 'isbn',
                'label' => \Yii::t('app', 'ISBN'),
            ],
            //'image',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Book $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
