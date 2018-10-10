<?php

use yii\db\Migration;

class m170524_074403_notification extends Migration
{
	public function up()
    {
        $this->createTable('notification',[
                'id' => $this->primaryKey(),
                'id_user' => $this->integer(),
				'name' => $this->string(50),
				'id_zakaz' => $this->integer(),
				'category' => $this->integer(),
				'srok' => $this->datetime(),
				'active' => $this->integet(),
            ]);

		$this->createIndex('idx-notification-id_user', 'notification', 'id_user');
		$this->createIndex('idx-notification-id_zakaz', 'notification', 'id_zakaz');

		$this->addForeignKey('fk-notification-user', 'notification', 'id_user', 'user', 'id');
		$this->addForeignKey('fk-notification-zakaz', 'notification', 'id_zakaz', 'zakaz', 'id_zakaz');
    }

    public function down()
    {
        $this->dropTable('tovar');
    }
}
