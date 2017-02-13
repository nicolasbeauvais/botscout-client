# PHP client for the BotScout.com API

[![Latest Version on Packagist](https://img.shields.io/packagist/v/nicolasbeauvais/botscout-client.svg?style=flat-square)](https://packagist.org/packages/nicolasbeauvais/botscout-client)
[![Build Status](https://img.shields.io/travis/nicolasbeauvais/botscout-client/master.svg?style=flat-square)](https://travis-ci.org/nicolasbeauvais/botscout-client)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/7218d7e0-4de5-453e-8b52-beb4044540db.svg?style=flat-square)](https://insight.sensiolabs.com/projects/7218d7e0-4de5-453e-8b52-beb4044540db)
[![Quality Score](https://img.shields.io/scrutinizer/g/nicolasbeauvais/botscout-client.svg?style=flat-square)](https://scrutinizer-ci.com/g/nicolasbeauvais/botscout-client)
[![Total Downloads](https://img.shields.io/packagist/dt/nicolasbeauvais/botscout-client.svg?style=flat-square)](https://packagist.org/packages/nicolasbeauvais/botscout-client)

![bs_logo_full](https://cloud.githubusercontent.com/assets/2951704/22866541/8c6ddd80-f178-11e6-8a94-ded54a0b109a.gif)

Protect your website against automated scripts using the [botscout.com](http://botscout.com/) API. 

## Installation

You can install the package via composer:

``` bash
composer require nicolasbeauvais/botscout-client
```

You also need an api key from [botscout.com](http://botscout.com/getkey.htm)

## Usage

You must pass a Guzzle client and an api key to the constructor of NicolasBeauvais\BotScout:

``` php
$client = new \GuzzleHttp\Client();

$botscout = new NicolasBeauvais\BotScout($client, 'api-key');
```

### Multi

Test matches all parameters at once.

```php
$response = $botscout->multi($name, $mail, $ip);
```

### All

Test matches a single item against all fields in the botscout database.

```php
$response = $botscout->all($name);
$response = $botscout->all($email);
```

### Name

Test matches a name.

```php
$response = $botscout->name($name);
```

### Mail

Test matches an email.

```php
$response = $botscout->mail($mail);
```

### IP

Test matches an IP.

```php
$response = $botscout->ip($ip);
```

### Response

```php
// Return false if the email has a match in the botscout database
$response->isValid();

// Return true if the email has a match in the botscout database
$response->getMatched();
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email nicolasbeauvais1@gmail.com instead of using the issue tracker.

## Credits

- [Nicolas Beauvais](https://github.com/nicolasbeauvais)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
