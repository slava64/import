<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%category}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%site}}`
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
            'site_id' => $this->integer(),
        ]);

        // creates index for column `import_id`
        $this->createIndex(
            '{{%idx-import_id}}',
            '{{%category}}',
            'import_id'
        );

        // creates index for column `site_id`
        $this->createIndex(
            '{{%idx-category-site_id}}',
            '{{%category}}',
            'site_id'
        );

        // add foreign key for table `{{%site}}`
        $this->addForeignKey(
            '{{%fk-category-site_id}}',
            '{{%category}}',
            'site_id',
            '{{%site}}',
            'id',
            'CASCADE'
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

        // drops foreign key for table `{{%site}}`
        $this->dropForeignKey(
            '{{%fk-category-site_id}}',
            '{{%category}}'
        );

        // drops index for column `site_id`
        $this->dropIndex(
            '{{%idx-category-site_id}}',
            '{{%category}}'
        );

        $this->dropTable('{{%category}}');
    }
}
