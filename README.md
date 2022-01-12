# mobifin-api-client

[![Latest Stable Version](https://img.shields.io/github/v/release/brokeyourbike/mobifin-api-client-php)](https://github.com/brokeyourbike/mobifin-api-client-php/releases)
[![Total Downloads](https://poser.pugx.org/brokeyourbike/mobifin-api-client/downloads)](https://packagist.org/packages/brokeyourbike/mobifin-api-client)
[![License: MPL-2.0](https://img.shields.io/badge/license-MPL--2.0-purple.svg)](https://github.com/brokeyourbike/mobifin-api-client-php/blob/main/LICENSE)

[![Maintainability](https://api.codeclimate.com/v1/badges/968d87c60b26bc79a545/maintainability)](https://codeclimate.com/github/brokeyourbike/mobifin-api-client-php/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/968d87c60b26bc79a545/test_coverage)](https://codeclimate.com/github/brokeyourbike/mobifin-api-client-php/test_coverage)
[![tests](https://github.com/brokeyourbike/mobifin-api-client-php/actions/workflows/tests.yml/badge.svg)](https://github.com/brokeyourbike/mobifin-api-client-php/actions/workflows/tests.yml)

Mobifin API Client for PHP

## Installation

```bash
composer require brokeyourbike/mobifin-api-client
```

## Usage

```php
use BrokeYourBike\Mobifin\EncryptedClient;
use BrokeYourBike\Mobifin\Interfaces\EncryptedConfigInterface;
use BrokeYourBike\Mobifin\Interfaces\EncrypterInterface;

assert($config instanceof ConfigInterface);
assert($encrypter instanceof EncrypterInterface);
assert($httpClient instanceof \GuzzleHttp\ClientInterface);

$apiClient = new Client($config, $encrypter, $httpClient);
$apiClient->getBalance();
```

## License
[Mozilla Public License v2.0](https://github.com/brokeyourbike/mobifin-api-client-php/blob/main/LICENSE)
