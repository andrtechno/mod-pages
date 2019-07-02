<?php

namespace panix\mod\pages\controllers\admin;

use Yii;
use panix\mod\pages\models\Pages;
use panix\mod\pages\models\PagesSearch;
use panix\engine\controllers\AdminController;


class DefaultController extends AdminController
{

    public function actions()
    {
        return [
            'sortable' => [
                'class' => \panix\engine\grid\sortable\Action::class,
                'modelClass' => Pages::class,
            ],
            'switch' => [
                'class' => \panix\engine\actions\SwitchAction::class,
                'modelClass' => Pages::class,
            ],
            'delete' => [
                'class' => \panix\engine\actions\DeleteAction::class,
                'modelClass' => Pages::class,
            ],
        ];
    }

    public function actionIndex()
    {
        $this->pageName = Yii::t('pages/default', 'MODULE_NAME');
        $this->buttons = [
            [
                'icon' => 'add',
                'label' => Yii::t('pages/default', 'CREATE_BTN'),
                'url' => ['create'],
                'options' => ['class' => 'btn btn-success']
            ]
        ];
        $this->breadcrumbs = [
            $this->pageName
        ];

        $searchModel = new PagesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionUpdate($id = false)
    {

        $model = Pages::findModel($id);
        $this->pageName = Yii::t('pages/default', 'CREATE_BTN');
        $this->buttons = [
            [
                'icon' => 'add',
                'label' => Yii::t('pages/default', 'CREATE_BTN'),
                'url' => ['create'],
                'options' => ['class' => 'btn btn-success']
            ]
        ];
        $this->breadcrumbs[] = [
            'label' => Yii::t('pages/default', 'MODULE_NAME'),
            'url' => ['index']
        ];
        $this->breadcrumbs[] = $this->pageName;

        $isNew = $model->isNewRecord;
        //$model->setScenario("admin");
        $post = Yii::$app->request->post();
        if ($model->load($post) && $model->validate()) {
            $model->save();
            Yii::$app->session->setFlash('success', Yii::t('app', ($isNew) ? 'SUCCESS_CREATE' : 'SUCCESS_UPDATE'));
            $redirect = (isset($post['redirect'])) ? $post['redirect'] : Yii::$app->request->url;
            if (!Yii::$app->request->isAjax)
                return $this->redirect($redirect);
        } else {

            // print_r($model->getErrors());
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }
}
