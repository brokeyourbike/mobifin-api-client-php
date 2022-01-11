<?php

// Copyright (C) 2021 Ivan Stasiuk <ivan@stasi.uk>.
//
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this file,
// You can obtain one at https://mozilla.org/MPL/2.0/.

namespace BrokeYourBike\Mobifin\Interfaces;

use BrokeYourBike\Mobifin\Enums\UserTypeEnum;
use BrokeYourBike\Mobifin\Enums\TerminalTypeEnum;

/**
 * @author Ivan Stasiuk <ivan@stasi.uk>
 */
interface ConfigInterface
{
    public function getUrl(): string;
    public function getPhone(): string;
    public function getUserType(): UserTypeEnum;
    public function getTerminalType(): TerminalTypeEnum;
    public function getTerminalInfo(): string;
}
