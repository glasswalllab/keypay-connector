# KeyPay PHP Wrapper
 
This package provides an integration (OAuth 2.0) to KeyPay.

[![Latest Version](https://img.shields.io/github/release/glasswalllab/keypay-connector.svg?style=flat-square)](https://github.com/glasswalllab/keypay-connector/releases)

## Installation

You can install the package via composer:

```bash
composer require glasswalllab/keypayconnector 
```

## Usage

1. Setup Web App in Microsoft Azure AD to obtain required credentials.

2. Include the following variables in your .env

```
KEYPAY_COMPANY_NAME=YOUR_COMAPNY_NAME
KEYPAY_TENANT_ID=YOUR_TENANT_ID
KEYPAY_APP_ID=YOUR_APP_ID
KEYPAY_APP_SECRET=YOUR_APP_SECRET
KEYPAY_REDIRECT_URI=YOUR_REDIRECT_URKL

KEYPAY_PROVIDER=KEYPAY
KEYPAY_SCOPES='Financials.ReadWrite.All offline_access'
KEYPAY_AUTHORITY=https://login.microsoftonline.com/
KEYPAY_AUTHORISE_ENDPOINT=/oauth2/authorize?resource=https://api.businesscentral.dynamics.com
KEYPAY_TOKEN_ENDPOINT=/oauth2/token?resource=https://api.businesscentral.dynamics.com
KEYPAY_RESOURCE=https://api.businesscentral.dynamics.com
KEYPAY_BASE_API_URL=https://wiise.api.bc.dynamics.com/v2.0/
```

3. Run **php artisan migrate** to create the api_token database table

4. Optional: Export the welcome view blade file

```
php artisan vendor:publish --provider="glasswalllab\keypayconnector\KeypayConnectorServiceProvider" --tag="views"
```

### Sample Usage (Laravel)

```php

```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email sreid@gwlab.com.au instead of using the issue tracker.