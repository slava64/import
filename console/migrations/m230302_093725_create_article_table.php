<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%article}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%category}}`
 * - `{{%site}}`
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
            'site_id' => $this->integer(),
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
            'CASCADE'
        );

        // creates index for column `site_id`
        $this->createIndex(
            '{{%idx-article-site_id}}',
            '{{%article}}',
            'site_id'
        );

        // add foreign key for table `{{%site}}`
        $this->addForeignKey(
            '{{%fk-article-site_id}}',
            '{{%article}}',
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

        // drops foreign key for table `{{%site}}`
        $this->dropForeignKey(
            '{{%fk-article-site_id}}',
            '{{%article}}'
        );

        // drops index for column `site_id`
        $this->dropIndex(
            '{{%idx-article-site_id}}',
            '{{%article}}'
        );

        $this->dropTable('{{%article}}');
    }
}
