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

    public function actionTest()
    {
        $action = Yii::$app->request->post('action');
        $selection = (array)Yii::$app->request->post('selection');
        print_r($selection);
        die;
        foreach ($selection as $id) {

        }
    }

    public function actionIndex()
    {
        $this->pageName = Yii::t('pages/default', 'MODULE_NAME');
        $this->buttons = [
            [
                'icon' => 'icon-add',
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
                'icon' => 'icon-add',
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


        //$model->setScenario("admin");
        $post = Yii::$app->request->post();
        if ($model->load($post) && $model->validate()) {
            $model->save();
            if (Yii::$app->request->post('redirect', 1)) {
                Yii::$app->session->addFlash('success', \Yii::t('app', 'SUCCESS_CREATE'));
                return Yii::$app->getResponse()->redirect(['/admin/pages']);
            }
        } else {

            // print_r($model->getErrors());
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }
}
