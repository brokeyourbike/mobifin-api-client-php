<?php

// Copyright (C) 2021 Ivan Stasiuk <ivan@stasi.uk>.
//
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this file,
// You can obtain one at https://mozilla.org/MPL/2.0/.

namespace BrokeYourBike\Mobifin\Models;

use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Attributes\MapFrom;

/**
 * @author Ivan Stasiuk <ivan@stasi.uk>
 */
class ValidateActivationOTP extends DataTransferObject
{
    #[MapFrom('ResponseCode')]
    public string $responseCode;

    #[MapFrom('ResponseDescription')]
    public string $responseDescription;

    #[MapFrom('ActivationRequestID')]
    public ?string $activationRequestID;

    #[MapFrom('ActivationCode')]
    public ?string $activationCode;

    #[MapFrom('CountryCode3Char')]
    public ?string $countryCode;

    #[MapFrom('CurrencyCode3Char')]
    public ?string $currencyCode;
}
