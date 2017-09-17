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

    public static function find() {
        return new PagesQuery(get_called_class());
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

}
