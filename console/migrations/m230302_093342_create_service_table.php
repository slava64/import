<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%service}}`.
 */
class m230302_093342_create_service_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%service}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull(),
            'domain' => $this->string(50)->notNull(),
            'api_url' => $this->string(50),
            'api_username' => $this->string(50),
            'api_key' => $this->string(50),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%service}}');
    }
}
