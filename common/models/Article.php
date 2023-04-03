<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property string $key
 * @property string|null $key2
 * @property string|null $link
 * @property int|null $import_id
 * @property int|null $category_id
 * @property int|null $service_id
 * @property string|null $public_at
 *
 * @property Category $category
 * @property Service $service
 */
class Article extends Base
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['key'], 'required'],
            [['import_id', 'category_id', 'service_id'], 'integer'],
            [['key', 'key2'], 'string', 'max' => 255],
            ['link', 'string', 'max' => 2083],
            ['public_at', 'datetime', 'format' => 'Y-m-d H:i:s'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['service_id'], 'exist', 'skipOnError' => true, 'targetClass' => Service::class, 'targetAttribute' => ['service_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key' => 'Key',
            'key2' => 'Key translate',
            'link' => 'Link',
            'import_id' => 'Import ID',
            'category_id' => 'Category ID',
            'service_id' => 'Service ID',
            'category.name' => 'Category',
            'service.name' => 'Service',
            'public_at' => 'Public At'
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[Service]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getService()
    {
        return $this->hasOne(Service::class, ['id' => 'service_id']);
    }

    public static function findAllArticlesWithImportIsNull(array $ids = [])
    {
        $articlesQuery = Article::find()
            ->select("article.*, service.domain, service.api_url, service.api_username, "
                 . "service.api_key, category.import_id AS category_import_id")
            ->leftJoin("service", "service.id = article.service_id")
            ->leftJoin("category", "category.id = article.category_id")
            ->where(['is', 'article.import_id', NULL]);
        if (!empty($ids)) {
            $articlesQuery->andWhere(['in', 'article.id', $ids]);
        }
        $articles = $articlesQuery->asArray()->all();
        if ($articles) {
            return $articles;
        }
        return [];
    }
}
