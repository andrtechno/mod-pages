<?php

namespace panix\mod\pages;

use Yii;
use panix\engine\WebModule;

class Module extends WebModule {


    public $routes = [
        'page/<url>' => 'pages/default/view',
    ];

    public function getNav() {
        return [
            [
                'label' => 'Станицы',
                "url" => ['/admin/pages'],
                'icon' => 'fa-edit'
            ],
            [
                'label' => 'Настройки',
                "url" => ['/admin/pages/settings'],
                'icon' => 'fa-gear'
            ]
        ];
    }

    public function getInfo() {
        return [
            'label' => Yii::t('pages/default', 'MODULE_NAME'),
            'author' => 'andrew.panix@gmail.com',
            'version' => '1.0',
            'icon' => 'icon-edit',
            'description' => Yii::t('pages/default', 'MODULE_DESC'),
            'url' => ['/admin/pages'],
        ];
    }

    protected function getDefaultModelClasses() {
        return [
            'Pages' => 'panix\mod\pages\models\Pages',
            'PagesSearch' => 'panix\mod\pages\models\PagesSearch',
        ];
    }

}
