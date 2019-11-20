<?php

namespace panix\mod\pages\controllers;

use Yii;
use panix\engine\controllers\WebController;
use panix\mod\pages\models\Pages;

class DefaultController extends WebController
{

    public function actionView($slug)
    {
        $layouts = [
            "@theme/modules/pages/views/default/html",
            "@pages/views/default/html",
        ];

        foreach ($layouts as $layout) {
            if (file_exists(Yii::getAlias($layout) . DIRECTORY_SEPARATOR . $slug . '.' . $this->view->defaultExtension)) {
                return $this->render($layout . '/' . $slug, []);
            }
        }


        $model = Pages::find()->where(['slug' => $slug])->published()->one();
        if (!$model) {
            $this->error404();
        }
        $this->pageName = $model->name;
        $this->breadcrumbs = [$this->pageName];
        $this->view->title = $this->pageName;
        return $this->render('view', ['model' => $model]);
    }

}
