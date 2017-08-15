<?php

namespace app\system\modules\pages\models;

use Yii;
use panix\engine\WebModel;
use app\models\User;
use panix\engine\grid\sortable\SortableGridBehavior;

/**
 * This is the model class for table "pages".
 *
 * @property integer $id
 * @property string $name
 */
class Pages extends WebModel {

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
            [['name', 'seo_alias'], 'string', 'max' => 255]
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

    public function behaviors() {
        return [
            'dnd_sort' => [
                'class' => SortableGridBehavior::className(),
                'sortableAttribute' => 'ordern'
                ],
        ];
    }

}
