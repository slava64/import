<?php

namespace common\models\request;

use yii\httpclient\Client;
use yii\httpclient\Exception;

class CreatePostWPRequest extends WPRequest
{
    /**
     * @var array
     */
    private $requestData;

    public function setRequestData(array $requestData)
    {
        $this->requestData = $requestData;
    }

    public function init()
    {
        try {
            $client = new Client(['baseUrl' => $this->baseUrl]);
            $response = $client->createRequest()
                ->setMethod('POST')
                ->setFormat(Client::FORMAT_JSON)
                ->setHeaders(['Authorization' => $this->getBaseAuth()])
                ->setUrl('posts')
                ->setData($this->requestData)
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