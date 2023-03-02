<?php

namespace common\models\form;

use common\models\Article;
use common\models\Category;
use common\models\Service;
use yii\base\Model;

class ImportKeysForm extends Model
{
    public $keys;
    public $category_id;
    public $service_id;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['keys', 'category_id', 'service_id'], 'required'],
            [['category_id', 'service_id'], 'integer'],
            [['keys'], 'string'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['service_id'], 'exist', 'skipOnError' => true, 'targetClass' => Service::class, 'targetAttribute' => ['service_id' => 'id']],
        ];
    }

    public function save()
    {
        if (!$this->validate()) {
            return false;
        }
        $listKeys = $this->getListKeys();
        foreach ($listKeys as $keys) {
            $article = new Article();
            $article->key = trim($keys['key']);
            $article->key2 = trim($keys['key2']);
            $article->category_id = $this->category_id;
            $article->service_id = $this->service_id;
            $article->save();
        }
        return true;
    }

    private function getListKeys()
    {
        $newList = [];
        $listKeys = explode("\n", $this->keys);
        for ($i = 0; $i < count($listKeys); $i++) {
            list($newList[$i]['key'], $newList[$i]['key2']) = explode(";", trim($listKeys[$i]));
        }
        return $newList;
    }
}