<?php

namespace panix\mod\pages\models;

use Yii;
use app\models\User;
use panix\engine\grid\sortable\SortableGridBehavior;
use panix\engine\behaviors\TranslateBehavior;
use panix\mod\pages\models\PagesTranslate;

/**
 * This is the model class for table "pages".
 *
 * @property integer $id
 * @property string $name
 */
class Pages extends \panix\engine\db\ActiveRecord {

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

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'seo_alias' => 'Seo alias',
            'text' => 'Text',
        ];
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

    /*
      public function behaviors() {
      return \yii\helpers\ArrayHelper::merge([
      // 'seo' => [
      //    'class' => 'pistol88\seo\behaviors\SeoFields',
      //],
      'timestamp' => [
      'class' => \yii\behaviors\TimestampBehavior::className(),
      'createdAtAttribute' => 'date_create',
      'updatedAtAttribute' => 'date_update',
      //'value' => new \yii\db\Expression('NOW()'),

      //'value' => new \yii\db\Expression('CURRENT_TIMESTAMP()'),
      'value' => new \yii\db\Expression('UTC_TIMESTAMP()'),
      'attributes' => [
      \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => 'date_create',
      \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => 'date_update',
      ],
      // 'value' => function() { return date('U'); },// unix timestamp
      ],
      ],parent::behaviors());
      }
     */
}
