<?php

use yii\db\Migration;

class m170908_125100_init extends Migration {

    public function up() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%pages}}', [
            'id' => $this->primaryKey(),
            'seo_alias' => $this->string(255)->notNull(),
            'user_id' => $this->integer(),
            'date_create' => $this->datetime(),
            'date_update' => $this->datetime(),
            'ordern ' => $this->integer(),
            'switch' => $this->boolean()->defaultValue(1),
                ], $tableOptions);


        $this->createTable('{{%pages_translate}}', [
            'id' => $this->primaryKey(),
            'object_id' => $this->integer(),
            'language_id' => $this->string(2),
            'name' => $this->string(255),
            'text' => $this->string(255),
                ], $tableOptions);


        $this->createIndex('switch', '{{%pages}}', 'switch', 0);
        $this->createIndex('ordern', '{{%pages}}', 'ordern', 0);
        $this->createIndex('user_id', '{{%pages}}', 'user_id', 0);

        $this->createIndex('object_id', '{{%pages_translate}}', 'object_id', 0);
        $this->createIndex('language_id', '{{%pages_translate}}', 'language_id', 0);
    }

    public function down() {
        $this->dropTable('{{%pages}}');
        $this->dropTable('{{%pages_translate}}');
    }

}
