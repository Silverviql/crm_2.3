<?php

use yii\db\Migration;

class m170510_145631_courier extends Migration
{
    public function up()
    {
        $this->createTable('courier',[
                'id' => $this->primaryKey(),
				'id_zakaz' => $this->integer(),
                'to' => $this->string(50),
                'date_to' => $this->datetime(),
                'from' => $this->string(50),
				'date_from' => $this->datetime(),
                'status' => $this->integer(),
                'commit' => $this->string(),
            ]);

		$this->createIndex('idx-courier-id_zakaz', 'courier', 'id_zakaz');

		$this->addForeignKey('fk-courier-id_zakaz', 'courier', 'id_zakaz', 'zakaz', 'id_zakaz');

    }

    public function down()
    {
        $this->dropTable('courier');
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
