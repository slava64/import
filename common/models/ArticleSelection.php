<?php

namespace common\models;

use common\models\request\CreatePostWPRequest;

class ArticleSelection
{
    private $postData;

    public function __construct(array $postData)
    {
        $this->postData = $postData;
    }

    public function init()
    {
        if ($this->isDelete()) {
            Article::deleteAll(['in', 'id', $this->postData['selection']]);
            return true;
        }
        if ($this->isImport()) {
            $articles = Article::findAllArticlesWithImportIsNull($this->postData['selection']);
            WPImport::importPosts($articles);

            return true;
        }
        if ($this->isImportAll()) {
            $articles = Article::findAllArticlesWithImportIsNull();
            return true;
        }
    }

    private function isDelete() {
        return !empty($this->postData['delete']) && is_array($this->postData['selection']);
    }

    private function isImport() {
        return !empty($this->postData['import']) && is_array($this->postData['selection']);
    }

    private function isImportAll() {
        return !empty($this->postData['import-all']);
    }
}