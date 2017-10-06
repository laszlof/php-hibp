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

$hibp = new Hibp\Hibp();

$account = 'you@yourdomain.com';
$breaches = $hibp->getBreaches($account);
```

### Get a single breach by name
```php

$hibp = new Hibp\Hibp();

$name = 'Adobe';
$breach = $hibp->getBreach($account);
```

### Get a list of sites that have been breached (optionally filtered by domain)
```php

$hibp = new Hibp\Hibp();

$breaches = $hibp->getBreachedSites();

$domain = 'adobe.com';
$breaches = $hibp->getBreachedSites($domain);
```

### Get a list of the types of dataclasses
```php

$hibp = new Hibp\Hibp();

$dataClasses = $hibp->getDataClasses();
```

### Get a list of pastes for a specific acccount (username/email)
```php

$hibp = new Hibp\Hibp();

$account = 'you@yourdomain.com';
$breaches = $hibp->getPastes($account);
```

### Check if a password has been compromised.
```php

$hibp = new Hibp\Hibp();

$password = 'password123';
$isCompromised = $hibp->checkPassword($password);

// Optionally check with a password that IS a hash itself.
$password_is_a_hash = '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8';
$isCompromised = $hibp->checkPassword($password_is_a_hash, true);
```

## Links

  * [HaveIBeenPwned](https://haveibeenpwned.com/)
  * [HIBP API v2](https://haveibeenpwned.com/API/v2)
  * [Google](https://www.google.com)
