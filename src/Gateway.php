<?php

namespace EasyCloudRequest\VolcTos;

use EasyCloudRequest\Core\Gateways\BaseGateway;
use EasyCloudRequest\Core\Support\RequestBag;
use EasyCloudRequest\Core\Support\Response;

class Gateway extends BaseGateway
{
    /**
     * ucloud sender
     *
     * @param $requestBag
     * @return Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \RuntimeException
     */
    public function requests(RequestBag $requestBag): Response
    {
        $signer = new Signer($this->config, $requestBag);
        $request = $signer->signRequest();
        try {
            $response = $this->getHttpClient()->send($request, $this->getBaseOptions());
            $result = $this->unwrapResponse($response);

            return new Response(200, $result);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            if ($e->hasResponse()) {
                $result = $this->unwrapResponse($e->getResponse());
                return new Response($e->getCode(), $result);
            }
            return new Response($e->getCode(), $e->getMessage());
        } catch (\Exception $e) {
            return new Response($e->getCode(), $e->getMessage());
        } catch (\Throwable $e) {
            return new Response($e->getCode(), $e->getMessage());
        }
    }
}
