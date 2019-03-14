<?php

namespace panix\mod\pages\controllers;

use Yii;
use panix\engine\controllers\WebController;
use panix\mod\pages\models\Pages;
use Viber\Bot;
use Viber\Api\Sender;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Viber\Client;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class DefaultController extends WebController
{

    public function actionView2($url)
    {
        $model = Pages::find()->where(['seo_alias' => $url])->one();
        if (!$model) {
            $this->error404();
        }
        $this->breadcrumbs = [$model->name];
        return $this->render('view', ['model' => $model]);
    }


    public function behaviors2()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                //'only' => ['index', 'viber'],
                'rules' => [
                    [
                        //разрешить гостям
                        'actions' => ['login','index'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        //разрешить зарегистрированным
                        'actions' => ['view', 'index','update'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [

                    'index' => ['POST'],
                ],
            ],
        ];
    }
    public function beforeAction($action) {
        if($action->id === 'webHook' || $action->id === 'bot' || $action->id === 'WebHook'){
            Yii::$app->controller->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }
    public function actionWebHook(){

        $apiKey = '48ac2da20027d4dc-e81fc2486fe80d0d-e99790255b8e5e0b';
        $webhookUrl = 'https://pixelion.com.ua/page/bot'; // for exmaple https://my.com/bot.php

        try {
            $client = new Client([ 'token' => $apiKey ]);
            $result = $client->setWebhook($webhookUrl);
            echo "Success!\n";
        } catch (Exception $e) {
            echo "Error: ". $e->getMessage() ."\n";
        }
        Yii::$app->end();
    }

    public function actionBot(){
        $this->enableCsrfValidation = false;
        Yii::$app->request->enableCsrfValidation = false;
        $apiKey = '48ac2da20027d4dc-e81fc2486fe80d0d-e99790255b8e5e0b';
        $botSender = new Sender([
            'name' => 'Reply bot',
            'avatar' => 'https://pixelion.com.ua/favicon.ico',
        ]);

        try {
            $bot = new Bot([ 'token' => $apiKey ]);
            echo $bot->onText('|.*|s', function ($event) use ($bot) {
                    // .* - match any symbols (see PCRE)
                    $bot->getClient()->sendMessage(
                        (new \Viber\Api\Message\Text())
                            ->setSender($botSender)
                            ->setReceiver($event->getSender()->getId())
                            ->setText("Hi!")
                    );
                })->run();
            Yii::$app->end();
        } catch (Exception $e) {
            // todo - log errors
        }
    }


}
