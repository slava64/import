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
            set_time_limit(3600);

            $articles = Article::findAllArticlesWithImportIsNull($this->postData['selection']);
            if ($this->isFuture()) {
                WPImport::importFuturePosts(
                    $articles,
                    strtotime($this->postData['future_from']),
                    strtotime($this->postData['future_to'])
                );
            } else {
                WPImport::importPosts($articles);
            }
            return true;
        }
        if ($this->isImportAll()) {
            set_time_limit(3600);

            $articles = Article::findAllArticlesWithImportIsNull();
            if ($this->isFuture()) {
                WPImport::importFuturePosts(
                    $articles,
                    strtotime($this->postData['future_from']),
                    strtotime($this->postData['future_to'])
                );
            } else {
                WPImport::importPosts($articles);
            }
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

    private function isFuture() {
        return !empty($this->postData['future']);
    }
}