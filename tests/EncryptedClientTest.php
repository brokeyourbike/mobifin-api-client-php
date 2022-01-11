<?php

// Copyright (C) 2021 Ivan Stasiuk <ivan@stasi.uk>.
//
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this file,
// You can obtain one at https://mozilla.org/MPL/2.0/.

namespace BrokeYourBike\Mobifin\Tests;

use PHPUnit\Framework\TestCase;
use BrokeYourBike\ResolveUri\ResolveUriTrait;
use BrokeYourBike\Mobifin\Interfaces\RequestInterface;
use BrokeYourBike\Mobifin\Interfaces\EncrypterInterface;
use BrokeYourBike\Mobifin\Interfaces\EncryptedConfigInterface;
use BrokeYourBike\Mobifin\Encrypter;
use BrokeYourBike\Mobifin\EncryptedClient;
use BrokeYourBike\HttpClient\HttpClientTrait;
use BrokeYourBike\HttpClient\HttpClientInterface;

/**
 * @author Ivan Stasiuk <ivan@stasi.uk>
 */
class EncryptedClientTest extends TestCase
{
    /** @test */
    public function it_implemets_http_client_interface(): void
    {
        /** @var EncryptedConfigInterface */
        $mockedConfig = $this->getMockBuilder(EncryptedConfigInterface::class)->getMock();

        /** @var EncrypterInterface */
        $mockedEncrypter = $this->getMockBuilder(EncrypterInterface::class)->getMock();

        /** @var \GuzzleHttp\ClientInterface */
        $mockedHttpClient = $this->getMockBuilder(\GuzzleHttp\ClientInterface::class)->getMock();

        $api = new EncryptedClient($mockedConfig, $mockedEncrypter, $mockedHttpClient);

        $this->assertInstanceOf(HttpClientInterface::class, $api);
        $this->assertSame($mockedConfig, $api->getConfig());
    }

    /** @test */
    public function it_uses_http_client_trait(): void
    {
        $usedTraits = class_uses(EncryptedClient::class);

        $this->assertArrayHasKey(HttpClientTrait::class, $usedTraits);
    }

    /** @test */
    public function it_uses_resolve_uri_trait(): void
    {
        $usedTraits = class_uses(EncryptedClient::class);

        $this->assertArrayHasKey(ResolveUriTrait::class, $usedTraits);
    }
}
