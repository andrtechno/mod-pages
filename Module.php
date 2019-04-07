<?php

namespace panix\mod\pages;

use Yii;
use panix\engine\WebModule;

class Module extends WebModule
{

    public $icon = 'edit';
    public $routes = [
        'page/bot' => 'pages/default/bot',

        // 'page/<url>' => 'pages/default/view',
        'page/test/vb' => 'pages/default/viberBot',
    ];

    public function getAdminMenu()
    {
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


    public function getInfo()
    {
        return [
            'label' => Yii::t('pages/default', 'MODULE_NAME'),
            'author' => 'dev@pixelion.com.ua',
            'version' => '1.0',
            'icon' => $this->icon,
            'description' => Yii::t('pages/default', 'MODULE_DESC'),
            'url' => ['/admin/pages'],
        ];
    }

}
