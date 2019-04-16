<?php

use yii\db\Schema;
use yii\db\Migration;

class m190710_122050_add_type_column_in_options extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function up()
    {
        $this->addColumn('{{%config_modules_options}}', 'type_id', $this->integer()->after('is_object'));
    }
}
