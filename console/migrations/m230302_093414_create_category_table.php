<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%category}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%service}}`
 */
class m230302_093414_create_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%category}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull(),
            'import_id' => $this->integer(),
            'service_id' => $this->integer(),
        ]);

        // creates index for column `import_id`
        $this->createIndex(
            '{{%idx-import_id}}',
            '{{%category}}',
            'import_id'
        );

        // creates index for column `service_id`
        $this->createIndex(
            '{{%idx-category-service_id}}',
            '{{%category}}',
            'service_id'
        );

        // add foreign key for table `{{%service}}`
        $this->addForeignKey(
            '{{%fk-category-service_id}}',
            '{{%category}}',
            'service_id',
            '{{%service}}',
            'id',
            'SET NULL'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops index for column `import_id`
        $this->dropIndex(
            '{{%idx-import_id}}',
            '{{%category}}'
        );

        // drops foreign key for table `{{%service}}`
        $this->dropForeignKey(
            '{{%fk-category-service_id}}',
            '{{%category}}'
        );

        // drops index for column `service_id`
        $this->dropIndex(
            '{{%idx-category-service_id}}',
            '{{%category}}'
        );

        $this->dropTable('{{%category}}');
    }
}
