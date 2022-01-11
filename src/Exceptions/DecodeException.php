<?php

// Copyright (C) 2021 Ivan Stasiuk <ivan@stasi.uk>.
//
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this file,
// You can obtain one at https://mozilla.org/MPL/2.0/.

namespace BrokeYourBike\Mobifin\Exceptions;

use Psr\Http\Message\ResponseInterface;

/**
 * @author Ivan Stasiuk <ivan@stasi.uk>
 */
final class DecodeException extends \RuntimeException
{
    public static function noData(ResponseInterface $response): self
    {
        $className = $response::class;
        return new static("No `Data` fields in the response `{$response->getBody()}`");
    }
}
