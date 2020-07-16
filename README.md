[![Actions Status](https://github.com/koren-software/erplybooks-api-php-client/workflows/build/badge.svg)](https://github.com/koren-software/erplybooks-api-php-client/actions)
[![Coverage Status](https://coveralls.io/repos/koren-software/erplybooks-api-php-client/badge.svg?branch=master&service=github)](https://coveralls.io/github/koren-software/erplybooks-api-php-client?branch=master)
[![Latest Stable Version](https://poser.pugx.org/koren-software/erplybooks-api-php-client/v/stable)](https://packagist.org/packages/koren-software/erplybooks-api-php-client)
[![Total Downloads](https://poser.pugx.org/koren-software/erplybooks-api-php-client/downloads)](https://packagist.org/packages/koren-software/erplybooks-api-php-client)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

# [Erply Books API](https://www.erplybooks.com/api/) PHP client

## Install

````bash
composer require koren-software/erplybooks-api-php-client
````

## Usage

```php
$token = ''; // Set your API token
$client = new Koren\ErplyBooks\Client($token);
```

### Get many
```php
$response = $client->Invoices()->get(); // Koren\ErplyBooks\Response\ItemsResponse
```

### Get by ID
```php
$response = $client->Invoices()->get(1); // Koren\ErplyBooks\Response\ItemResponse
```

### Predefined interfaces used
```php
$invoices = $client->Invoices()->get(); // Koren\ErplyBooks\Response\ItemsResponse

// Items response is iterable
foreach ($invoices as $invoice) {
    // Do something with $invoice
}

// Responses are jsonable
$json = json_decode($response); // json string of all items or item

// Responses are countable
$count = count($response); // integer (how many items were in response)
```

## Development

- `composer build` - build by running tests and all code checks
- `composer test` - run PHPUnit
- `composer format` - format code against standards
- `composer phpcs` - run PHP Codesniffer against PSR-2 standards
- `composer phpmd` - run PHP Mess Detector
- `composer docs` - generate docs with PHP Documentator (expects `apigen/apigen` installed globally cause of conflicts)
