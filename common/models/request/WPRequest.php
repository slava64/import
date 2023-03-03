<?php

namespace common\models\request;

abstract class WPRequest
{
    protected $baseUrl;
    protected $username;
    protected $password;

    protected $statusCode;
    protected $responseData;

    public function __construct($baseUrl, $username, $password)
    {
        $this->baseUrl = $baseUrl;
        $this->username = $username;
        $this->password = $password;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getResponseData()
    {
        return $this->responseData;
    }

    abstract public function init();

    protected function getBaseAuth()
    {
        return "Basic " . base64_encode($this->username . ":" . $this->password);
    }
}