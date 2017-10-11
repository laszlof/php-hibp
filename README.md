# PHP HaveIBeenPwned.Com SDK

[![Build Status](https://travis-ci.org/laszlof/php-hibp.svg?branch=master)](https://travis-ci.org/laszlof/php-hibp)

`laszlof/php-hibp` is an SDK which allows PHP developers to easily communicate with the [API](https://haveibeenpwned.com/API/v2) provided by [HaveIBeenPwned.Com](https://haveibeenpwned.com).

## Requirements

  * PHP 7.0+

## How to install

```bash
composer require laszlof/php-hibp
```

## Usage

### Get a list of breaches for a specific acccount (username/email)
```php

use Hibp\Hibp;

$account = 'you@yourdomain.com';
$breaches = Hibp::getBreaches($account);
```

### Get a single breach by name
```php

use Hibp\Hibp;

$name = 'Adobe';
$breach = Hibp::getBreach($account);
```

### Get a list of sites that have been breached (optionally filtered by domain)
```php

use Hibp\Hibp;

$breaches = Hibp::getBreachedSites();

$domain = 'adobe.com';
$breaches = Hibp::getBreachedSites($domain);
```

### Get a list of the types of dataclasses
```php

use Hibp\Hibp;

$dataClasses = Hibp::getDataClasses();
```

### Get a list of pastes for a specific acccount (username/email)
```php

use Hibp\Hibp;

$account = 'you@yourdomain.com';
$breaches = Hibp::getPastes($account);
```

### Check if a password has been compromised.
```php

use Hibp\Hibp;

$password = 'password123';
$isCompromised = Hibp::checkPassword($password);

// Optionally check with a password that IS a hash itself.
$password_is_a_hash = '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8';
$isCompromised = Hibp::checkPassword($password_is_a_hash, true);
```

## Links

  * [HaveIBeenPwned](https://haveibeenpwned.com/)
  * [HIBP API v2](https://haveibeenpwned.com/API/v2)
  * [Google](https://www.google.com)
