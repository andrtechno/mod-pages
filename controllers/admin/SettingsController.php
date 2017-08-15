<?php

namespace panix\pages\controllers\admin;

use Yii;
use panix\engine\controllers\AdminController;
use panix\pages\models\SettingsForm;

class SettingsController extends AdminController {

    public function actionIndex() {
        $this->pageName = Yii::t('app', 'SETTINGS');
        $this->breadcrumbs = [
            [
                'label' => $this->module->info['name'],
                'url' => $this->module->info['url'],
            ],
            $this->pageName
        ];
        $model = new SettingsForm();
        if ($model->load(Yii::$app->request->post())) {
            $model->save();
        }
        return $this->render('index', [
                    'model' => $model
                ]);
    }

}
