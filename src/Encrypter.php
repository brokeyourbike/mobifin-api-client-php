<?php

// Copyright (C) 2021 Ivan Stasiuk <ivan@stasi.uk>.
//
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this file,
// You can obtain one at https://mozilla.org/MPL/2.0/.

namespace BrokeYourBike\Mobifin;

use phpseclib\Crypt\AES;
use BrokeYourBike\Mobifin\Interfaces\EncrypterInterface;
use BrokeYourBike\Mobifin\Interfaces\EncryptedConfigInterface;

/**
 * @author Ivan Stasiuk <ivan@stasi.uk>
 */
class Encrypter implements EncrypterInterface
{
    public const KEY_LENGTH = 128;
    public const IV = 'fdsfds85435nfdfs';

    public function encrypt(EncryptedConfigInterface $config, string $plainText): string
    {
        $worker = new AES();
        $worker->setKeyLength(self::KEY_LENGTH);
        $worker->setKey(base64_decode($config->getEncryptionKey()));
        $worker->setIV(self::IV);

        $encryptedData = $worker->encrypt($plainText);
        $hash = hash_hmac('sha1', $encryptedData, base64_decode($config->getSignKey()), true);
        return base64_encode(self::IV . $hash . $encryptedData);
    }

    public function decrypt(EncryptedConfigInterface $config, string $plainText): string
    {
        $worker = new AES();
        $worker->setKeyLength(self::KEY_LENGTH);
        $worker->setKey(base64_decode($config->getEncryptionKey()));

        $text = base64_decode($plainText);
        $iv = substr($text, 0, 16);
        $worker->setIV($iv);

        $signData = substr($text, 16, 20);
        $encryptedData = substr($text, 36);

        return $worker->decrypt($encryptedData);
    }
}
