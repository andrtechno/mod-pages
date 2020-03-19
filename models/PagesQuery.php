<?php

namespace panix\mod\pages\models;

use panix\engine\traits\query\TranslateQueryTrait;
use yii\db\ActiveQuery;
use panix\engine\traits\query\DefaultQueryTrait;

class PagesQuery extends ActiveQuery {

    use DefaultQueryTrait, TranslateQueryTrait;
}
