<?php

namespace panix\mod\pages\models;

use panix\mod\sitemap\behaviors\SitemapBehavior;
use Yii;
use panix\engine\db\ActiveRecord;

/**
 * This is the model class for table "pages".
 *
 * @property integer $id
 * @property string $name
 * @property string $text
 * @property integer $created_at
 * @property integer $updated_at
 */
class Pages extends ActiveRecord
{

    const route = '/admin/pages/default';
    const MODULE_ID = 'pages';
    public $translationClass = PagesTranslate::class;


    public static function find()
    {
        return new PagesQuery(get_called_class());
    }

    public function getGridColumns()
    {
        return [
            'id' => [
                'attribute' => 'id',
                'contentOptions' => ['class' => 'text-center'],
            ],
            [
                'attribute' => 'name',
                'contentOptions' => ['class' => 'text-left'],
            ],
            [
                'attribute' => 'views',
                'contentOptions' => ['class' => 'text-center'],
            ],
            [
                'attribute' => 'text',
                'format' => 'html'
            ],
            [
                'attribute' => 'created_at',
                'format' => 'raw',
                'filter' => \yii\jui\DatePicker::widget([
                    'model' => new PagesSearch(),
                    'attribute' => 'created_at',
                    'dateFormat' => 'yyyy-MM-dd',
                    'options' => ['class' => 'form-control']
                ]),
                'contentOptions' => ['class' => 'text-center'],
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->created_at, 'php:d D Y H:i:s');
                }
            ],
            [
                'attribute' => 'updated_at',
                'format' => 'raw',
                'filter' => \yii\jui\DatePicker::widget([
                    'model' => new PagesSearch(),
                    'attribute' => 'updated_at',
                    'dateFormat' => 'yyyy-MM-dd',
                    'options' => ['class' => 'form-control']
                ]),
                'contentOptions' => ['class' => 'text-center'],
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->updated_at, 'php:d D Y H:i:s');
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
    public static function tableName()
    {
        return '{{%pages}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'text', 'slug'], 'required'],
            [['name', 'slug'], 'string', 'max' => 255],
            [['name', 'slug'], 'trim'],
            [['show_header', 'show_footer'], 'boolean'],
            ['slug', '\panix\engine\validators\UrlValidator', 'attributeCompare' => 'name'],
            ['slug', 'match',
                'pattern' => '/^([a-z0-9-])+$/i',
                'message' => Yii::t('app/default', 'PATTERN_URL')
            ],
            [['updated_at', 'created_at'], 'safe'],
            //[['date_update'], 'date', 'format' => 'php:U']
            /// [['date_update'], 'date','format'=>'php:U', 'timestampAttribute' => 'date_update','skipOnEmpty'=>  true],
//[['date_update','date_create'], 'filter','filter'=>'strtotime'],
        ];
    }

    public function getUrl()
    {
        return ['/pages/default/view', 'slug' => $this->slug];
    }

    public function renderText()
    {
        if (Yii::$app->user->can('admin')) {
            \panix\ext\tinymce\TinyMceInline::widget();
        }
        return (Yii::$app->user->can('admin')) ? $this->isText('text') : $this->pageBreak('text');
    }

    public function getUser()
    {
        return $this->hasOne(Yii::$app->user->identityClass, ['id' => 'user_id']);
    }

    public function behaviors()
    {
        $b=[];
        if (Yii::$app->getModule('seo'))
            $b['seo'] = [
                'class' => '\panix\mod\seo\components\SeoBehaviorNew',
               // 'url' => $this->getUrl()
            ];

        if (Yii::$app->getModule('sitemap')) {
            $b['sitemap'] = [
                'class' => SitemapBehavior::class,
                //'batchSize' => 100,
                'scope' => function ($model) {
                    /** @var \yii\db\ActiveQuery $model */
                    $model->select(['slug', 'updated_at']);
                    $model->where(['switch' => 1]);
                },
                'dataClosure' => function ($model) {
                    /** @var self $model */
                    return [
                        'loc' => $model->getUrl(),
                        'lastmod' => $model->updated_at,
                        'changefreq' => SitemapBehavior::CHANGEFREQ_DAILY,
                        'priority' => 0.1
                    ];
                }
            ];
        }
        if (Yii::$app->hasModule('comments')) {
            $b['commentBehavior'] = [
                'class' => 'panix\mod\comments\components\CommentBehavior',
                'owner_title' => 'name',

            ];
        }
        return \yii\helpers\ArrayHelper::merge($b, parent::behaviors());
    }

}
