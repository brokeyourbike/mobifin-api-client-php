<?php

// Copyright (C) 2021 Ivan Stasiuk <ivan@stasi.uk>.
//
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this file,
// You can obtain one at https://mozilla.org/MPL/2.0/.

namespace BrokeYourBike\Mobifin\Tests;

use PHPUnit\Framework\TestCase;
use BrokeYourBike\Mobifin\Interfaces\EncryptedConfigInterface;
use BrokeYourBike\Mobifin\Encrypter;

/**
 * @author Ivan Stasiuk <ivan@stasi.uk>
 */
class EncrypterTest extends TestCase
{
    /** @test */
    public function it_can_encrypt()
    {
        $mockedConfig = $this->getMockBuilder(EncryptedConfigInterface::class)->getMock();
        $mockedConfig->method('getEncryptionKey')->willReturn('ABC');
        $mockedConfig->method('getSignKey')->willReturn('DEF');

        /** @var EncryptedConfigInterface $mockedConfig */
        $this->assertInstanceOf(EncryptedConfigInterface::class, $mockedConfig);

        $encrypter = new Encrypter();
        $this->assertNotSame('data-string', $encrypter->encrypt($mockedConfig, 'data-string'));
    }
}
