<?php

namespace panix\mod\pages\controllers;

use Yii;
use panix\engine\controllers\WebController;
use panix\mod\pages\models\Pages;
use yii\web\NotFoundHttpException;

class DefaultController extends WebController {

    public $model;


    public function actionView($url) {
        $this->findModel($url);
        return $this->render('view', ['model' => $this->model]);
    }

    protected function findModel($url) {
        $model = Yii::$app->getModule("pages")->model("Pages");
        if (($this->model = $model::find()->where(['seo_alias' => $url])->one()) !== null) {
            return $this->model;
        } else {
            throw new NotFoundHttpException('page not found');
        }
    }

}
