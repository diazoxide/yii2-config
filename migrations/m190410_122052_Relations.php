<?php

use yii\db\Schema;
use yii\db\Migration;

class m190410_122052_Relations extends Migration
{

    public function init()
    {
       $this->db = 'db';
       parent::init();
    }

    public function safeUp()
    {
        $this->addForeignKey('fk_config_modules_options_module_id',
            '{{%config_modules_options}}','module_id',
            '{{%config_modules}}','id',
            'CASCADE','CASCADE'
         );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_config_modules_options_module_id', '{{%config_modules_options}}');
    }
}
