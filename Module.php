<?php

namespace panix\mod\pages;

use Yii;
use panix\engine\WebModule;

class Module extends WebModule {

    public $icon = 'edit';
    public $routes = [
        'page/<url>' => 'pages/default/view'
    ];

    public function getAdminMenu() {
        return [
            'modules' => [
                'items' => [
                    [
                        'label' => Yii::t('pages/default', 'MODULE_NAME'),
                        'url' => ['/admin/pages'],
                        'icon' => $this->icon,
                    ],
                ],
            ],
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

}
