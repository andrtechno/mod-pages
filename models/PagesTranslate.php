<?php

namespace panix\mod\pages\models;

use yii\db\ActiveRecord;

class PagesTranslate extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%pages_translate}}';
    }

}
