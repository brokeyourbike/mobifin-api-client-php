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
class GetProductDetails extends DataTransferObject
{
    #[MapFrom('ResponseCode')]
    public string $responseCode;

    #[MapFrom('ResponseDescription')]
    public string $responseDescription;

    #[MapFrom('ProductList.ProductID')]
    public ?array $productId;

    #[MapFrom('ProductList.ProductName')]
    public ?array $productName;

    #[MapFrom('ProductList.ProductCode')]
    public ?array $productCode;

    #[MapFrom('ProductList.ProductType')]
    public ?array $productType;

    #[MapFrom('ProductList.Description')]
    public ?array $description;

    #[MapFrom('ProductList.IsProductActive')]
    public ?array $isProductActive;

    #[MapFrom('ProductList.ProductDenominationList')]
    public ?array $productDenominationList;

    #[MapFrom('ProductList.VendorProductID')]
    public ?array $vendorProductID;

    #[MapFrom('ProductList.OperatorID')]
    public ?array $operatorID;

    #[MapFrom('ProductList.OperatorName')]
    public ?array $operatorName;
}
