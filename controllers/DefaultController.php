<?php

namespace panix\mod\pages\controllers;

use Yii;
use panix\engine\controllers\WebController;
use panix\mod\pages\models\Pages;


class DefaultController extends WebController
{

    public function actionView($url)
    {
        $model = Pages::find()->where(['seo_alias' => $url])->one();
        if (!$model) {
            $this->error404();
        }
        $this->breadcrumbs = [$model->name];
        return $this->render('view', ['model' => $model]);
    }


}
