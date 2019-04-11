<?php

use yii\db\Schema;
use yii\db\Migration;

class m190410_122051_config_modules_options extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable(
            '{{%config_modules_options}}',
            [
                'id'=> $this->primaryKey(11),
                'module_id'=> $this->integer(11)->notNull(),
                'app_id'=> $this->string(255)->null()->defaultValue(null),
                'name'=> $this->string(255)->notNull(),
                'value'=> $this->text()->null()->defaultValue(null),
                'is_object'=> $this->tinyInteger(1)->notNull(),
                'parent_id'=> $this->integer(11)->null()->defaultValue(null),
                'sort'=> $this->integer(11)->notNull(),
                'created_at'=> $this->integer(11)->notNull(),
                'updated_at'=> $this->integer(11)->notNull(),
            ],$tableOptions
        );
        $this->createIndex('module_id','{{%config_modules_options}}',['module_id'],false);

    }

    public function safeDown()
    {
        $this->dropIndex('module_id', '{{%config_modules_options}}');
        $this->dropTable('{{%config_modules_options}}');
    }
}
