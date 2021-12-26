<?php

namespace panix\mod\pages\models;

use panix\engine\traits\query\TranslateQueryTrait;
use yii\db\ActiveQuery;
use panix\engine\traits\query\DefaultQueryTrait;

class PagesQuery extends ActiveQuery {

    use DefaultQueryTrait, TranslateQueryTrait;

    public function init()
    {
        /** @var \yii\db\ActiveRecord $modelClass */
        $modelClass = $this->modelClass;
        $tableName = $modelClass::tableName();
        $this->addOrderBy(["{$tableName}.ordern" => SORT_DESC]);
        parent::init();
    }

    public function header()
    {
        /** @var \yii\db\ActiveRecord $modelClass */
        $modelClass = $this->modelClass;
        $tableName = $modelClass::tableName();
        return $this->andWhere(["{$tableName}.show_header" => 1]);
    }

    public function footer()
    {
        /** @var \yii\db\ActiveRecord $modelClass */
        $modelClass = $this->modelClass;
        $tableName = $modelClass::tableName();
        return $this->andWhere(["{$tableName}.show_footer" => 1]);
    }
    
}
