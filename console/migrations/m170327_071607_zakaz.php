<?php

use yii\db\Migration;

class m170327_071607_zakaz extends Migration
{
    public function up()
    {
        $this->createTable('zakaz',[
                'id_zakaz' => $this->primaryKey(),
                'srok' => $this->date(),
                'minut' => $this->time(),
                'id_sotrud' => $this->integer(),
                'sotrud_name' => $this->string(50),
                'prioritet' => $this->string(36),
                'status' => $this->integer(),
                'action' => $this->integer(),
                'id_tovar' => $this->integer(),
                'oplata' => $this->integer(),
                'fact_oplata' => $this->integer(),
                'number' => $this->integer(),
                'data' => $this->date(),
                'description' => $this->string(100),
                'information' => $this->string(500),
                'img' => $this->string(100),
                'maket' => $this->string(50),
				'time' => $this->integer(),
                'statusDesign' => $this->integer(),
                'data_start_disain' => $this->datetime(),
                'name' => $this->string(50),
                'phone' => $this->integer(11),
                'email' => $this->string(50),
                'comment' => $this->text(),
                'id_shipping' => $this->integer(),
            ]);

		$this->createIndex('idx-zakaz-id_sotrud', 'zakaz', 'id_sotrud');
		$this->createIndex('idx-zakaz-id_tovar', 'zakaz', 'id_tovar');
		$this->createIndex('idx-zakaz-id_shipping', 'zakaz', 'id_shipping');

        $this->addForeignKey('zakaz_ibfk_2', 'zakaz', 'id_tovar', 'tovar', 'id', 'CASCADE');
        $this->addForeignKey('zakaz_ibfk_4', 'zakaz', 'id_sotrud', 'user', 'id', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('zakaz');
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
