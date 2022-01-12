<?php

// Copyright (C) 2021 Ivan Stasiuk <ivan@stasi.uk>.
//
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this file,
// You can obtain one at https://mozilla.org/MPL/2.0/.

namespace BrokeYourBike\Mobifin;

use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\ClientInterface;
use BrokeYourBike\ResolveUri\ResolveUriTrait;
use BrokeYourBike\Mobifin\Models\Response;
use BrokeYourBike\Mobifin\Models\GetBalance;
use BrokeYourBike\Mobifin\Interfaces\RequestInterface;
use BrokeYourBike\Mobifin\Interfaces\EncrypterInterface;
use BrokeYourBike\Mobifin\Interfaces\EncryptedConfigInterface;
use BrokeYourBike\HttpEnums\HttpMethodEnum;
use BrokeYourBike\HttpClient\HttpClientTrait;
use BrokeYourBike\HttpClient\HttpClientInterface;

/**
 * @author Ivan Stasiuk <ivan@stasi.uk>
 */
class EncryptedClient implements HttpClientInterface
{
    use HttpClientTrait;
    use ResolveUriTrait;

    private EncryptedConfigInterface $config;
    private EncrypterInterface $encrypter;

    public function __construct(EncryptedConfigInterface $config, EncrypterInterface $encrypter, ClientInterface $httpClient)
    {
        $this->config = $config;
        $this->encrypter = $encrypter;
        $this->httpClient = $httpClient;
    }

    public function getConfig(): EncryptedConfigInterface
    {
        return $this->config;
    }

    public function getBalance(RequestInterface $request): GetBalance
    {
        $response = $this->performRequest(HttpMethodEnum::POST, 'securerest', [
            'MethodName' => 'GetBalance',
            'ActivationCode' => $this->config->getActivationCode(),
            'RequestUniqueID' => $request->getId(),
            'RequestIP' => $request->getIp(),
        ]);

        return new GetBalance($this->decode($this->config, $this->encrypter, $response));
    }

    public function getProductDetails(RequestInterface $request, int $serviceType, int $systemModuleId, int $systemServiceId): ResponseInterface
    {
        return $this->performRequest(HttpMethodEnum::POST, 'securerest', [
            'MethodName' => 'GetProductDetails',
            'ActivationCode' => $this->config->getActivationCode(),
            'ProductID' => null,
            'SystemModuleID' => $systemModuleId,
            'SystemServiceID' => $systemServiceId,
            'ProductServiceType' => $serviceType,
            'RequestUniqueID' => $request->getId(),
            'RequestIP' => $request->getIp(),
        ]);
    }

    public function topUp(RequestInterface $request, string $productCode, string $phoneNumber, float $amount): ResponseInterface
    {
        return $this->performRequest(HttpMethodEnum::POST, 'securerest', [
            'MethodName' => 'TopUp',
            'ActivationCode' => $this->config->getActivationCode(),
            'ProductCode' => $productCode,
            'TxReference' => $phoneNumber,
            'Amount' => $amount,
            'ANI' => $phoneNumber,
            'MPin' => $this->config->getMpin(),
            'RequestUniqueID' => $request->getId(),
            'RequestIP' => $request->getIp(),
        ]);
    }

    /**
     * @param HttpMethodEnum $method
     * @param string $uri
     * @param array<mixed> $data
     * @return ResponseInterface
     */
    private function performRequest(HttpMethodEnum $method, string $uri, array $data): ResponseInterface
    {
        $encryptedData = $this->encrypter->encrypt($this->config, (string) \json_encode($data, JSON_FORCE_OBJECT));

        $options = [
            \GuzzleHttp\RequestOptions::HEADERS => [
                'Accept' => 'application/json',
            ],
            \GuzzleHttp\RequestOptions::BODY => "ActivationCode={$this->config->getActivationCode()}&Data={$encryptedData}",
        ];

        $uri = (string) $this->resolveUriFor($this->config->getUrl(), $uri);
        return $this->httpClient->request($method->value, $uri, $options);
    }

    private function decode(EncryptedConfigInterface $config, EncrypterInterface $encrypter, ResponseInterface $response): array
    {
        $r = new Response($response);
        $decrypted = $encrypter->decrypt($config, $r->data);
        return \json_decode($decrypted, true);
    }
}
