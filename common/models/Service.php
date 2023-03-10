<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "service".
 *
 * @property int $id
 * @property string $name
 * @property string $domain
 * @property string|null $api_url
 * @property string|null $api_username
 * @property string|null $api_key
 *
 * @property Article[] $articles
 * @property Category[] $categories
 */
class Service extends Base
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'service';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'domain'], 'required'],
            [['name', 'domain', 'api_url', 'api_username', 'api_key'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'domain' => 'Domain',
            'api_url' => 'Api Url',
            'api_username' => 'Api Username',
            'api_key' => 'Api Key',
        ];
    }

    /**
     * Gets query for [[Articles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Article::class, ['service_id' => 'id']);
    }

    /**
     * Gets query for [[Categories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::class, ['service_id' => 'id']);
    }
}
