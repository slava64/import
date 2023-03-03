<?php

namespace common\models;
use common\models\request\CreatePostWPRequest;

class WPImport
{
    const PATH_TO_DATA = 'E:/sites';
    public static function importPosts(array $articles)
    {
        foreach ($articles as $article) {
            self::createPost($article);
        }
    }

    public static function createPost(array $article)
    {
        if (!empty($content = self::getContent($article))) {
            $requestData = [
                'status' => 'publish',
                'title' => self::mbUcfirst($article['key']),
                'content' => $content,
                'categories' => [$article['category_id']],
                //'featured_media' => '',
                //'date' => '',
            ];
            $createPost = new CreatePostWPRequest(
                $article['api_url'],
                $article['api_username'],
                $article['api_key']
            );
            $createPost->setRequestData($requestData);
            if ($createPost->init()) {
                $data = $createPost->getResponseData();
                Article::updateAll(['import_id' => $data['id']], ['id' => $article['id']]);
            }
        }
    }

   public static function getContent(array $article) {
        $pathToFile = self::PATH_TO_DATA . '/' . $article['domain'] . '/data/' . $article['key2'] . '.txt';
        if (is_file($pathToFile)) {
            return file_get_contents($pathToFile);
        }
        return '';
   }

    public static function mbUcfirst($string) {
        return mb_strtoupper(mb_substr($string, 0, 1)) . mb_substr($string, 1);
    }
}