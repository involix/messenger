<div align="center">
    <a href="https://travis-ci.org/ker0x/messenger" title="Build">
        <img src="https://img.shields.io/travis/ker0x/messenger.svg?style=for-the-badge" alt="Build">
    </a>
    <a href="https://scrutinizer-ci.com/g/ker0x/messenger/" title="Coverage">
        <img src="https://img.shields.io/scrutinizer/coverage/g/ker0x/messenger.svg?style=for-the-badge" alt="Coverage">
    </a>
    <a href="https://scrutinizer-ci.com/g/ker0x/messenger/" title="Code Quality">
        <img src="https://img.shields.io/scrutinizer/g/ker0x/messenger.svg?style=for-the-badge" alt="Code Quality">
    </a>
    <a href="https://php.net" title="PHP Version">
        <img src="https://img.shields.io/badge/php-%3E%3D%207.3-8892BF.svg?style=for-the-badge" alt="PHP Version">
    </a>
    <a href="https://packagist.org/packages/involix/messenger" title="Downloads">
        <img src="https://img.shields.io/packagist/dt/involix/messenger.svg?style=for-the-badge" alt="Downloads">
    </a>
    <a href="https://packagist.org/packages/involix/messenger" title="Latest Stable Version">
        <img src="https://img.shields.io/packagist/v/involix/messenger.svg?style=for-the-badge" alt="Latest Stable Version">
    </a>
    <a href="https://packagist.org/packages/involix/messenger" title="License">
        <img src="https://img.shields.io/packagist/l/involix/messenger.svg?style=for-the-badge" alt="License">
    </a>
</div>

# Messenger

A PHP library to interact with [Facebook Messenger Platform](https://www.messenger.com/)

## Installation

You can install Messenger using Composer:

```
composer require involix/messenger
```

You will then need to:
* run ``composer install`` to get these dependencies added to your vendor directory
* add the autoloader to your application with this line: ``require('vendor/autoload.php');``

## Basic usage

```php
use Involix\Messenger\Messenger;

$messenger = new Messenger($appSecret, $verifyToken, $pageToken)
$messenger->send()->message(<USER_ID>, 'Hello world!');
```

## Advance usage

Please, refer to the [wiki](https://github.com/ker0x/messenger/wiki) to learn how to use this library

## Features

### API

- [x] Broadcast (deprecated)
- [x] Code (deprecated)
- [x] Insights
- [x] Nlp
- [x] Persona
- [x] Profile
- [x] Send
- [x] Tag
- [x] Thread
- [x] User
- [x] Webhook

### Templates

- [x] Airline Boarding Pass
- [x] Airline Check In
- [x] Airline Itinerary
- [x] Airline Update
- [x] Buttons
    - [x] Account Link
    - [x] Account Unlink
    - [x] Nested (deprecated)
    - [x] Payment
    - [x] Phone Number
    - [x] Postback
    - [x] Share (deprecated)
    - [x] Web Url
- [x] Generic
- [x] List (deprecated)
- [x] Media
- [x] Receipt

### Callback

- [x] Account Linking
- [x] AppRoles
- [x] Checkout Update
- [x] Delivery
- [x] GamePlay
- [x] Message
- [x] Message Echo
- [x] Optin
- [x] PassThreadControl
- [x] Payment
- [x] Policy Enforcement
- [x] Postback
- [x] Pre Checkout
- [x] Read
- [x] Reaction
- [x] Referral
- [x] RequestThreadControl
- [x] TakeThreadControl
