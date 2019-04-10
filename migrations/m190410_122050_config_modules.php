<?php

use yii\db\Schema;
use yii\db\Migration;

class m190410_122050_config_modules extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable(
            '{{%config_modules}}',
            [
                'id'=> $this->primaryKey(11),
                'name'=> $this->string(255)->notNull(),
                'namespace'=> $this->string(255)->notNull(),
                'is_bootstrap'=> $this->tinyInteger(1)->notNull(),
                'bootstrap_namespace'=> $this->string(255)->null()->defaultValue(null),
                'bootstrap_method'=> $this->string(255)->null()->defaultValue(null),
                'type'=> $this->integer(11)->notNull(),
                'status'=> $this->integer(1)->notNull(),
                'priority'=> $this->integer(11)->notNull(),
                'created_at'=> $this->integer(11)->notNull(),
                'updated_at'=> $this->integer(11)->notNull(),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%config_modules}}');
    }
}
