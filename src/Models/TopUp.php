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
class TopUp extends DataTransferObject
{
    #[MapFrom('ResponseCode')]
    public string $responseCode;

    #[MapFrom('ResponseDescription')]
    public string $responseDescription;

    #[MapFrom('Balance')]
    public ?float $balance;

    #[MapFrom('ConfirmationCode')]
    public ?string $confirmationCode;

    #[MapFrom('TransactionID')]
    public ?string $transactionID;

    #[MapFrom('TransactionFee')]
    public ?string $transactionFee;

    #[MapFrom('Commission')]
    public ?string $commission;

    #[MapFrom('RequestDateTime')]
    public ?string $requestDateTime;
}
