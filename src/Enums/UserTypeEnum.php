<?php

// Copyright (C) 2021 Ivan Stasiuk <ivan@stasi.uk>.
//
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this file,
// You can obtain one at https://mozilla.org/MPL/2.0/.

namespace BrokeYourBike\Mobifin\Enums;

/**
 * @author Ivan Stasiuk <ivan@stasi.uk>
 */
enum UserTypeEnum: string
{
    case TRUST_ACCOUNT = '0';
    case AGENT = '1';
    case SUBSCRIBER = '2';
    case MERCHANT = '3';
    case MNO_BRANCH = '4';
    case ENTERPRISE = '5';
    case BANK = '6';
    case VENDOR = '8';
}
