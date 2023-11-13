<?php
namespace EasyCloudRequest\VolcTos;

use EasyCloudRequest\Core\Support\Config;
use EasyCloudRequest\Core\Support\RequestBag;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use EasyCloudRequest\VolcTos\Model\HttpRequest;
use EasyCloudRequest\VolcTos\Auth\Signer as SignerTrait;

class Signer
{
    use SignerTrait;
    /**
     * request bag
     *
     * @var RequestBag
     */
    protected $requestBag;

    /**
     * config
     *
     * @var array
     */
    protected $config;

    /**
     * @param array $config
     * @return void
     */
    public function __construct(Config $config, RequestBag $requestBag)
    {
        $this->requestBag = $requestBag;
        $this->config = $config;
    }

    public function signRequest()
    {
        $httRequest = $this->prepareRequest();

        $this->sign(
            $httRequest,
            $this->requestBag->host,
            $this->config['ak'],
            $this->config['sk'],
            $this->requestBag->queryParams['token'] ?? '',
            $this->requestBag->queryParams['region'] ?? ''
        );

        return new Request(
            $this->requestBag->method,
            (string) $this->getUri($this->requestBag),
            $httRequest->headers,
            \json_encode($this->requestBag->body)
        );
    }


    private function prepareRequest()
    {
        $obj = new HttpRequest();
        $obj->method = $this->requestBag->method;
        $obj->headers = $this->requestBag->headerParams;
        $obj->queries = $this->requestBag->queryParams;
        $obj->body = $this->requestBag->body;
        $obj->body = $this->requestBag->body;

        return $obj;
    }

    protected function getUri(RequestBag $requestBag)
    {
        $uri = new Uri($requestBag->url);
        $queryParams = $requestBag->queryParams;

        if ($queryString = $uri->getQuery()) {
            parse_str($queryString, $queryParams);
            $queryParams = array_merge($queryParams, $requestBag->queryParams);
        }

        return $uri->withQuery(http_build_query($queryParams));
    }
}
