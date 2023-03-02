<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%article}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%category}}`
 * - `{{%service}}`
 */
class m230302_093725_create_article_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%article}}', [
            'id' => $this->primaryKey(),
            'key' => $this->string(255)->notNull(),
            'key2' => $this->string(255),
            'import_id' => $this->integer(),
            'category_id' => $this->integer(),
            'service_id' => $this->integer(),
        ]);

        // creates index for column `import_id`
        $this->createIndex(
            '{{%idx-import_id}}',
            '{{%article}}',
            'import_id'
        );

        // creates index for column `category_id`
        $this->createIndex(
            '{{%idx-article-category_id}}',
            '{{%article}}',
            'category_id'
        );

        // add foreign key for table `{{%category}}`
        $this->addForeignKey(
            '{{%fk-article-category_id}}',
            '{{%article}}',
            'category_id',
            '{{%category}}',
            'id',
            'SET NULL'
        );

        // creates index for column `service_id`
        $this->createIndex(
            '{{%idx-article-service_id}}',
            '{{%article}}',
            'service_id'
        );

        // add foreign key for table `{{%service}}`
        $this->addForeignKey(
            '{{%fk-article-service_id}}',
            '{{%article}}',
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
            '{{%article}}',
        );

        // drops foreign key for table `{{%category}}`
        $this->dropForeignKey(
            '{{%fk-article-category_id}}',
            '{{%article}}'
        );

        // drops index for column `category_id`
        $this->dropIndex(
            '{{%idx-article-category_id}}',
            '{{%article}}'
        );

        // drops foreign key for table `{{%service}}`
        $this->dropForeignKey(
            '{{%fk-article-service_id}}',
            '{{%article}}'
        );

        // drops index for column `service_id`
        $this->dropIndex(
            '{{%idx-article-service_id}}',
            '{{%article}}'
        );

        $this->dropTable('{{%article}}');
    }
}
