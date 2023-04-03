<?php

namespace common\models\request;

use yii\httpclient\Client;
use yii\httpclient\Exception;

class CreateMediaWPRequest extends WPRequest
{
    /**
     * @var string
     */
    private $filePath;

    public function setFilePath(string $path)
    {
        $this->filePath = $path;
    }

    public function init()
    {
        try {
            $client = new Client(['baseUrl' => $this->baseUrl]);
            $response = $client->createRequest()
                ->setMethod('POST')
                ->setFormat(Client::FORMAT_JSON)
                ->setHeaders(['Authorization' => $this->getBaseAuth()])
                ->setUrl('media')
                ->addFile('file', $this->filePath)
                ->send();
            $this->statusCode = $response->getStatusCode();
            $this->responseData = $response->getData();
            if ($this->statusCode == 201) {
                return true;
            }
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
        return false;
    }
}