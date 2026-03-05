<?php

namespace frontend\controllers;

use Yii;
use common\models\Subscription;
use yii\web\Controller;
use yii\filters\VerbFilter;

class SubscriptionController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Subscription();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->goHome();
            }
        } else {
            $model->loadDefaultValues();
        }

        $authors = $this->getAuthorService()->getAll();

        return $this->render('create', [
            'model' => $model,
            'authors' => $authors,
        ]);
    }

    protected function getAuthorService(): \common\services\author\AuthorService
    {
        return Yii::$container->get(\common\services\author\AuthorService::class);
    }
}
