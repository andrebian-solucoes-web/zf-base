# ZF Base

A Zend Framework Bootstrap Application for multipurpose applications.

## Installing

### Creating a project with Composer

```shell
composer create-project --stability="dev" andrebian-solucoes-web/zf-base path/to/installation
```

### Cloning repository

Clone this repository and remove the `.git` folder before start to code.

### Downloading Zip

Download the zip file and remove the `.git` folder before start to code.

## What this project does?
A set of common features to turn the development faster. 




## Which features were included?

### BaseApplication Module

#### Assets: Form Elements

- NameField
- SaveButton
- FilterName

> Avoid to write these elements every time.


#### Mysql Custom Types

- CustomDateTime


#### Filters

- CurrencyToFloat
- DateTime
- FloatVal


#### Helpers

- LicensePlateFormatter - at the moment only for brazilian cars
- PhoneFormatter - at the moment only for brazilian phone numbers
- PriceFormatter - at the moment only for BRL


#### Mail

An e-mail wrapper. Easily send transactional e-mails.


#### Validators

- NameAndLastName


#### View Helpers

- BrazilianStateHelper - Easily populate forms with Brazilian States
- JsonDecode - Decode json data in views. Useful for twig templates
- Slugify - Generates slugs by a given string
- Zap Loading - A Customizable WhatsApp Web loading clone


### User Module

#### Assets

- Session Default namespace


#### Auth

- Customizable Auth Adapter


#### Fixtures

- First Role (admin)
- First Registered User as admin


#### Helper

- UserIdentity - fetch the authenticated user data in session


#### View Helper

- UserIdentity - one more view helper to fetch the authenticated user data in session



## Running tests

`composer test`

 
## License

[MIT](LICENSE)  
 
## Contributing