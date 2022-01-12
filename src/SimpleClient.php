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
use BrokeYourBike\Mobifin\Models\ValidateActivationOTP;
use BrokeYourBike\Mobifin\Models\Response;
use BrokeYourBike\Mobifin\Models\GenerateActivationOTP;
use BrokeYourBike\Mobifin\Interfaces\RequestInterface;
use BrokeYourBike\Mobifin\Interfaces\ConfigInterface;
use BrokeYourBike\HttpEnums\HttpMethodEnum;
use BrokeYourBike\HttpClient\HttpClientTrait;
use BrokeYourBike\HttpClient\HttpClientInterface;

/**
 * @author Ivan Stasiuk <ivan@stasi.uk>
 */
class SimpleClient implements HttpClientInterface
{
    use HttpClientTrait;
    use ResolveUriTrait;

    private ConfigInterface $config;

    public function __construct(ConfigInterface $config, ClientInterface $httpClient)
    {
        $this->config = $config;
        $this->httpClient = $httpClient;
    }

    public function getConfig(): ConfigInterface
    {
        return $this->config;
    }

    public function generateActivationOTP(RequestInterface $request): GenerateActivationOTP
    {
        $response = $this->performRequest(HttpMethodEnum::POST, 'selfregistration', [
            'MethodName' => 'GenerateActivationOTP',
            'RequestUniqueID' => $request->getId(),
            'Phone' => $this->config->getPhone(),
            'UserType' => $this->config->getUserType()->value,
            'TerminalType' => $this->config->getTerminalType()->value,
            'TerminalInfo' => $this->config->getTerminalInfo(),
        ]);

        return new GenerateActivationOTP($this->decode($response));
    }

    public function validateActivationOTP(RequestInterface $request, string $otpRequestId, string $otpCode): ValidateActivationOTP
    {
        $response = $this->performRequest(HttpMethodEnum::POST, 'selfregistration', [
            'MethodName' => 'ValidateActivationOTP',
            'RequestUniqueID' => $request->getId(),
            'Phone' => $this->config->getPhone(),
            'UserType' => $this->config->getUserType(),
            'TerminalType' => $this->config->getTerminalType(),
            'TerminalInfo' => $this->config->getTerminalInfo(),
            'OTPRequestID' => $otpRequestId,
            'OTP' => $otpCode,
        ]);

        return new ValidateActivationOTP($this->decode($response));
    }

    /**
     * @param HttpMethodEnum $method
     * @param string $uri
     * @param array<mixed> $data
     * @return ResponseInterface
     */
    private function performRequest(HttpMethodEnum $method, string $uri, array $data): ResponseInterface
    {
        $options = [
            \GuzzleHttp\RequestOptions::HEADERS => [
                'Accept' => 'application/json',
            ],
            \GuzzleHttp\RequestOptions::BODY => 'Data='.json_encode($data),
        ];

        $uri = (string) $this->resolveUriFor($this->config->getUrl(), $uri);
        return $this->httpClient->request($method->value, $uri, $options);
    }

    private function decode(ResponseInterface $response): ?array
    {
        $r = new Response($response);
        return \json_decode($r->data, true);
    }
}
