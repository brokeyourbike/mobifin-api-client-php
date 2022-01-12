<?php

// Copyright (C) 2021 Ivan Stasiuk <ivan@stasi.uk>.
//
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this file,
// You can obtain one at https://mozilla.org/MPL/2.0/.

namespace BrokeYourBike\Mobifin\Tests;

use Psr\Http\Message\ResponseInterface;
use BrokeYourBike\Mobifin\Models\TopUp;
use BrokeYourBike\Mobifin\Models\GetBalance;
use BrokeYourBike\Mobifin\Interfaces\RequestInterface;
use BrokeYourBike\Mobifin\Interfaces\EncrypterInterface;
use BrokeYourBike\Mobifin\Interfaces\EncryptedConfigInterface;
use BrokeYourBike\Mobifin\EncryptedClient;

/**
 * @author Ivan Stasiuk <ivan@stasi.uk>
 */
class TopupTest extends TestCase
{
    private string $activationCode = '132465';
    private string $encryptionKey = 'ABC';
    private string $signKey = 'DEF';

    /** @test */
    public function it_can_prepare_request(): void
    {
        $mockedConfig = $this->getMockBuilder(EncryptedConfigInterface::class)->getMock();
        $mockedConfig->method('getUrl')->willReturn('https://api.example/');
        $mockedConfig->method('getActivationCode')->willReturn($this->activationCode);
        $mockedConfig->method('getEncryptionKey')->willReturn($this->encryptionKey);
        $mockedConfig->method('getSignKey')->willReturn($this->signKey);

        $mockedEncrypter = $this->getMockBuilder(EncrypterInterface::class)->getMock();
        $mockedEncrypter->method('encrypt')->willReturn('encrypted');
        $mockedEncrypter->method('decrypt')->willReturn('{
            "ResponseCode":"000",
            "ResponseDescription":"Txn Successful",
            "Balance":"99980.000000",
            "ConfirmationCode":"20171206091723",
            "TransactionID":"5378 ",
            "TransactionInfo":"{\"TransactionId\":\"091723\",\"OperatorCode\":\"20171206\"}",
            "RequestDateTime":"2017-12-06 09:17:22",
            "TransactionFee":"0.10",
            "Commission":"0.10"
        }');

        $request = $this->getMockBuilder(RequestInterface::class)->getMock();
        $request->method('getId')->willReturn('1');
        $request->method('getIp')->willReturn('127.0.0.1');

        $mockedResponse = $this->getMockBuilder(ResponseInterface::class)->getMock();
        $mockedResponse->method('getStatusCode')->willReturn(200);
        $mockedResponse->method('getBody')
            ->willReturn('{
                "Data": "some-decrypted-string"
            }');

        /** @var \Mockery\MockInterface $mockedClient */
        $mockedClient = \Mockery::mock(\GuzzleHttp\Client::class);
        $mockedClient->shouldReceive('request')->withArgs([
            'POST',
            'https://api.example/securerest',
            [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Accept' => 'application/json',
                ],
                \GuzzleHttp\RequestOptions::BODY => "ActivationCode={$this->activationCode}&Data=encrypted"
            ],
        ])->once()->andReturn($mockedResponse);

        /**
         * @var EncryptedConfigInterface $mockedConfig
         * @var EncrypterInterface $mockedEncrypter
         * @var \GuzzleHttp\Client $mockedClient
         * */
        $api = new EncryptedClient($mockedConfig, $mockedEncrypter, $mockedClient);

        /** @var RequestInterface $request */
        $response = $api->topUp($request, 'PRODUCT01', '12345678', 10.00);

        $this->assertInstanceOf(TopUp::class, $response);
    }
}
