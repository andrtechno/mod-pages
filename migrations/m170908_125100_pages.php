<?php

use yii\db\Migration;

class m170908_125100_pages extends Migration {

    public function up() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%pages}}', [
            'id' => $this->primaryKey(),
            'seo_alias' => $this->string(255)->notNull(),
            'user_id' => $this->integer(),
            'views' => $this->integer()->defaultValue(0),
            'ordern' => $this->integer(),
            'switch' => $this->boolean()->defaultValue(1),
            'created_at' => $this->integer(11)->null(),
            'updated_at' => $this->integer(11)->null(),
                ], $tableOptions);


        $this->createTable('{{%pages_translate}}', [
            'id' => $this->primaryKey(),
            'object_id' => $this->integer(),
            'language_id' => $this->string(2),
            'name' => $this->string(255),
            'text' => $this->text(),
                ], $tableOptions);


        $this->createIndex('switch', '{{%pages}}', 'switch');
        $this->createIndex('ordern', '{{%pages}}', 'ordern');
        $this->createIndex('user_id', '{{%pages}}', 'user_id');
        $this->createIndex('seo_alias', '{{%pages}}', 'seo_alias');

        $this->createIndex('object_id', '{{%pages_translate}}', 'object_id');
        $this->createIndex('language_id', '{{%pages_translate}}', 'language_id');

        if ($this->db->driverName != "sqlite") {
            $this->addForeignKey('{{%fk_pages_translate}}', '{{%pages_translate}}', 'object_id', '{{%pages}}', 'id', "CASCADE", "NO ACTION");
        }

        $columns = ['seo_alias', 'user_id', 'ordern', 'date_create'];
        $this->batchInsert('{{%pages}}', $columns, [
            ['about', 1, 1, date('Y-m-d H:i:s')],
            ['mypage', 1, 2, date('Y-m-d H:i:s')],
        ]);


        $columns = ['object_id', 'language_id', 'name', 'text'];
        $this->batchInsert('{{%pages_translate}}', $columns, [
            [1, Yii::$app->language, 'О компании', ''],
            [2, Yii::$app->language, 'Тест', ''],
        ]);
    }

    public function down() {
        if ($this->db->driverName != "sqlite") {
            $this->dropForeignKey('{{%fk_pages_translate}}', '{{%pages_translate}}');
        }
        $this->dropTable('{{%pages}}');
        $this->dropTable('{{%pages_translate}}');
    }

}
