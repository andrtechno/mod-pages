<?php

namespace panix\mod\pages\models;

use Yii;
use app\models\User;
use panix\engine\behaviors\TranslateBehavior;
use panix\mod\pages\models\PagesTranslate;
use panix\mod\pages\models\PagesQuery;

/**
 * This is the model class for table "pages".
 *
 * @property integer $id
 * @property string $name
 */
class Pages extends \panix\engine\db\ActiveRecord {

    const route = '/admin/pages/default';
    const MODULE_ID = 'pages';

    public static function find() {
        return new PagesQuery(get_called_class());
    }

    public function getGridColumns() {
        return [
            'id',
            'name',
            [
                'attribute' => 'views',

                'contentOptions' => ['class' => 'text-center'],
            ],
            [
                'attribute' => 'text',
                'format' => 'html'
            ],
            [
                'attribute' => 'date_create',
                'format' => 'raw',
                'filter' => \yii\jui\DatePicker::widget([
                    'model' => new PagesSearch(),
                    'attribute' => 'date_create',
                    'dateFormat' => 'yyyy-MM-dd',
                    'options' => ['class' => 'form-control']
                ]),
                'contentOptions' => ['class' => 'text-center'],
                'value' => function($model) {
                    return Yii::$app->formatter->asDatetime($model->date_create, 'php:d D Y H:i:s');
                }
            ],
                    [
                'attribute' => 'date_update',
                'format' => 'raw',
                'filter' => \yii\jui\DatePicker::widget([
                    'model' => new PagesSearch(),
                    'attribute' => 'date_update',
                    'dateFormat' => 'yyyy-MM-dd',
                    'options' => ['class' => 'form-control']
                ]),
                'contentOptions' => ['class' => 'text-center'],
                'value' => function($model) {
                    return Yii::$app->formatter->asDatetime($model->date_update, 'php:d D Y H:i:s');
                }
            ],
            'DEFAULT_CONTROL' => [
                'class' => 'panix\engine\grid\columns\ActionColumn',
            ],
            'DEFAULT_COLUMNS' => [
                ['class' => 'panix\engine\grid\columns\CheckboxColumn'],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%pages}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'text', 'seo_alias'], 'required'],
            [['name', 'seo_alias'], 'string', 'max' => 255],
            [['date_update', 'date_create'], 'safe'],
                //[['date_update'], 'date', 'format' => 'php:U']
                /// [['date_update'], 'date','format'=>'php:U', 'timestampAttribute' => 'date_update','skipOnEmpty'=>  true],
//[['date_update','date_create'], 'filter','filter'=>'strtotime'],
        ];
    }
    public function renderText(){
        return (Yii::$app->user->can('admin'))?$this->isText('text'):$this->pageBreak('text');
    }
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getTranslations() {
        return $this->hasMany(PagesTranslate::className(), ['object_id' => 'id']);
    }

    public function transactions() {
        return [
            self::SCENARIO_DEFAULT => self::OP_INSERT | self::OP_UPDATE,
        ];
    }

    public function behaviors() {
        return \yii\helpers\ArrayHelper::merge([
                    'translate' => [
                        'class' => TranslateBehavior::className(),
                        'translationAttributes' => [
                            'name',
                            'text'
                        ]
                    ],
                        ], parent::behaviors());
    }

}
