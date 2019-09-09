## Installing and configuring

Install using composer:

```sh
$ composer require seasofthpyosithu/gmo-payment
```

If you are using a Laravel version **less than 5.5** you **need to add** the provider on `config/app.php`:

```php
'providers' => [
    // ...
     Seasofthpyosithu\GmoPayment\GmoPaymentServiceProvider::class,
],
```

If you want you can use the [facade](http://laravel.com/docs/facades). Add the reference in `config/app.php` to your aliases array.

```php
'RemittanceApi' => Seasofthpyosithu\GmoPayment\Facades\RemittanceApi::class
```

## Configuration

Gmo Payment requires connection configuration. To get started, you'll need to publish all vendor assets:

```bash
$ php artisan vendor:publish --provider="Seasofthpyosithu\GmoPayment\GmoPaymentServiceProvider"
```

## Usage
- [`Create Account`](#create-bank-account)
- [`Update Account`](#update-bank-account)
- [`Delete Account`](#delete-bank-account)
- [`Search Account`](#search-bank-account)
- [`Create Deposit`](#create-deposit)
- [`Cancel Deposit`](#cancel-deposit)
- [`Search Deposit`](#search-deposit)
- [`Create Mail Deposit`](#create-mail-deposit)
- [`Cancel Mail Deposit`](#cancel-mail-deposit)
- [`Search Mail Deposit`](#search-mail-deposit)
- [`Check Balance`](#check-balance)


```php
use Seasofthpyosithu\GmoPayment\Facades\RemittanceApi;
```

### `Create bank account`
```php
RemittanceApi::accountRegistration(
    'bank00000', // bank id
    '0001', // bank code
    '813', // branch code
    AccountType::NORMAL, // account type
    'An Yutzy', // account name
    '0012345', // account number
    AccountMethod::CREATE, // method
);
```

### `Update bank account`
```php
RemittanceApi::accountRegistration(
    'bank00000', // bank id
    '0001', // bank code
    '813', // branch code
    AccountType::NORMAL, // account type
    'An Yutzy', // account name
    '0012345', // account number
    AccountMethod::UPDATE, // method
);
```

### `Delete bank account`
```php
RemittanceApi::deleteAccount(
    'bank00000', // bank id
);
```

### `Search bank account`
```php
RemittanceApi::accountSearch(
    'bank00000', // bank id
);
```

### `Create deposit`
```php
RemittanceApi::depositRegistration(
    'dep00000', // deposit id
    DepositMethod::CREATE // method CREATE or CANCEL
    'bank00000', // bank id
    1000 // amount
);
```

### `Cancel deposit`
```php
RemittanceApi::depositRegistration(
    'dep00000', // deposit id
    DepositMethod::CANCEL // method CREATE or CANCEL
);
```

### `Search deposit`
```php
RemittanceApi::depositSearch(
    'dep00000', // deposit id
);
```

### `Create mail deposit`
```php
RemittanceApi::mailDepositRegistration(
    'dep00000', // deposit id
    DepositMethod::CREATE // method CREATE or CANCEL
    'anyutzy@demo.com', // mail address
    'anyutzy@demo.com' // shop mail address
    'An Yutzy', // account name
    '20170503' // Expire
    1000 // amount
);
```


### `Cancel mail deposit`
```php
RemittanceApi::mailDepositRegistration(
    'dep00000', // deposit id
    DepositMethod::CANCEL // method CREATE or CANCEL
);
```

### `Search mail deposit`
```php
RemittanceApi::mailDepositSearch(
    'dep00000', // deposit id
);
```

### `Check balance`
```php
RemittanceApi::balanceSearch();
```
