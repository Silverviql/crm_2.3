<?php

use yii\db\Migration;

class m170510_145528_custom extends Migration
{
    public function up()
    {
        $this->createTable('custom',[
                'id' => $this->primaryKey(),
                'id_user' => $this->integer(),
                'tovar' => $this->string(50),
                'number' => $this->integer(),
                'date' => $this->timestamp(),
                'action' => $this->tynyint(4),
                'date_end' => $this->datetime(),
            ]);

		$this->createIndex('idx-custom-id_user', 'custom', 'id_user');

		$this->addForeignKey('fk-custom-user', 'custom', 'id_user', 'user', 'id');
    }

    public function down()
    {
        $this->dropTable('custom');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
