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
enum TerminalTypeEnum: string
{
    case WEB_INTERFACE = '001';
    case MOBILE_ANDROID = '002';
    case USSD = '003';
    case POS = '004';
    case SMART_WATCH = '006';
    case FINGER_PRINT = '007';
    case QR_CODE = '008';
    case CHIP_AND_PIN = '009';
    case NFC = '010';
    case MOBILE_IOS = '011';
    case API = '012';
}
