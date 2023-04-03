<?php

namespace common\models;
use common\models\request\CreateMediaWPRequest;
use common\models\request\CreatePostWPRequest;

class WPImport
{
    const PATH_TO_DATA = 'E:/sites';
    public static function importPosts(array $articles)
    {
        foreach ($articles as $article) {
            self::importPost($article, time());
        }
    }

    public static function importFuturePosts(array $articles, int $dateFrom, int $dateTo)
    {
        $countArticles = count($articles);
        $countDates = floor(($dateTo - $dateFrom) / (24 * 3600));

        $period = $countDates / $countArticles;
        $dateTime = $dateFrom + $period * 24 * 3600;
        foreach ($articles as $article) {
            self::importPost($article, $dateTime);
            $dateTime = $dateTime + $period * 24 * 3600;
        }
    }

    public static function importPost(array $article, int $dateTime)
    {
        if (!empty($content = self::getContent($article))) {
            if (!empty($imagePath = self::getPathImage($article, $content))) {
                $image = self::createMedia($article, $imagePath);
            }

            $mediaId = !empty($image['id']) ? $image['id'] : 0;
            if (!empty($image['guid']['rendered'])) {
                $content = preg_replace(
                    "/<img.+?>/i",
                    '<img width="650" src="' . $image['guid']['rendered'] . '" />',
                    $content
                );
            }
            $content = preg_replace_callback(
                "/<h2>(.+?)<\/h2>/i",
                function ($matches) {
                    return '<h2>' . self::mbUcfirst(trim($matches[1])) . '</h2>';
                },
                $content
            );

            if ($post = self::createPost($article, $content, $dateTime, $mediaId)) {
                Article::updateAll([
                    'import_id' => $post['id'],
                    'link' => str_replace("%postname%", $post['generated_slug'], $post['permalink_template']),
                    'public_at' => $post['date'],
                ], ['id' => $article['id']]);
            }
        }
    }

   public static function getContent(array $article)
   {
        $pathToFile = self::PATH_TO_DATA . '/' . $article['domain'] . '/data/' . $article['key2'] . '.txt';
        if (is_file($pathToFile)) {
            return file_get_contents($pathToFile);
        }
        return '';
   }

    public static function getPathImage(array $article, string $content)
    {
        if(preg_match("/<img.+?src=\"(.+?)\"/i", $content, $matches)
            && is_file(self::PATH_TO_DATA . '/' . $article['domain'] . $matches[1])
        ) {
            return self::PATH_TO_DATA . '/' . $article['domain'] . $matches[1];
        }
        return '';
    }

    public static function createMedia(array $article, string $imagePath)
    {
        $createMedia = new CreateMediaWPRequest(
            $article['api_url'],
            $article['api_username'],
            $article['api_key']
        );
        $createMedia->setFilePath($imagePath);
        if ($createMedia->init()) {
            return $createMedia->getResponseData();
        }
        return [];
    }

    public static function createPost(
        array $article,
        string $content,
        int $dateTime,
        int $mediaId = 0
    )
    {
        $requestData = [
            'status' => $dateTime > time() ? 'future' : 'publish',
            'title' => self::mbUcfirst($article['key']),
            'content' => $content,
            'categories' => [$article['category_import_id']],
            'date' => date("Y-m-d H:i:s", $dateTime),
        ];
        if ($mediaId != 0) {
            $requestData['featured_media'] = $mediaId;
        }
        $createPost = new CreatePostWPRequest(
            $article['api_url'],
            $article['api_username'],
            $article['api_key']
        );
        $createPost->setRequestData($requestData);
        if ($createPost->init()) {
            return $createPost->getResponseData();
        }
        return [];
    }

    public static function mbUcfirst($string) {
        return mb_strtoupper(mb_substr($string, 0, 1)) . mb_substr($string, 1);
    }
}