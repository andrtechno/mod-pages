<?php

namespace panix\mod\pages;

use Yii;
use panix\engine\WebModule;
use yii\base\BootstrapInterface;

class Module extends WebModule implements BootstrapInterface
{

    public $icon = 'edit';

    public function bootstrap($app)
    {
        $app->urlManager->addRules(
            [
                'page/<slug:[0-9a-zA-Z_\-]+>/page/<page:\d+>/per-page/<per-page:\d+>' => 'pages/default/view',
                'page/<slug:[0-9a-zA-Z_\-]+>/page/<page:\d+>' => 'pages/default/view',
                'page/<slug:[0-9a-zA-Z_\-]+>' => 'pages/default/view',

            ],
            true
        );
    }

    public function getAdminMenu()
    {
        return [
            'modules' => [
                'items' => [
                    [
                        'label' => Yii::t('pages/default', 'MODULE_NAME'),
                        'url' => ['/admin/pages'],
                        'icon' => $this->icon,
                        'visible' => Yii::$app->user->can('/pages/admin/default/index') || Yii::$app->user->can('/pages/admin/default/*')
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
