# ZF Base

A Zend Framework Bootstrap Application for multipurpose applications.

## 1 - Installing

### 1.1 - Creating a project with Composer

```shell
composer create-project -sdev andrebian-solucoes-web/zf-base path/to/installation
```

### 1.2 - Cloning repository

Clone this repository and remove the `.git` folder before start to code.

### 1.3 - Downloading Zip

Download the zip file and remove the `.git` folder before start to code.

#### Note

When installing dependencies with composer, some questions will appear.

```shell
 - Installing doctrine/doctrine-module (dev-master 57c0ee9): Cloning 57c0ee9586 from cache

  Please select which config file you wish to inject 'DoctrineModule' into:
  [0] Do not inject
  [1] config/development.config.php.dist
  Make your selection (default is 0):0

  Remember this option for other packages of the same type? (y/N)y
```

Just select the option "0". All project dependencies are already set in `config/modules.config.php`.
Then select the option "y" to remember this decision for packages of the same type.

## 2 - Initializing the application

### 2.1 - Create a database

```mysql
CREATE SCHEMA `your_db_name` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ;
```

### 2.2 - Set database config

Copy the file `config/autoload/doctrine_orm.local.php.dist` to `config/autoload/doctrine_orm.local.php`. After this 
edit the result file and set your database configurations.

```php
# File config/autoload/doctrine_orm.local.php

return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => [
                    'host' => 'host',
                    'port' => '3306',
                    'user' => 'user',
                    'password' => 'password',
                    'dbname' => 'dbname',
                    'driverOptions' => [
                        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"
                    ]
                ]
            ]
        ]
    ],
    'dbal' => [
        'types' => [
            'datetime' => \BaseApplication\Database\Mysql\CustomDateTimeType::class
        ]
    ]
];
```

### 2.3 - Update the schema

In `composer.json` has one configured command to update schema. This command was named as 
**update-db**.

```shell
composer update-db
```

The result is something like this:

```shell
composer update-db
> doctrine-module migrations:diff
Loading configuration from the integration code of your framework (setter).
Generated new migration class to "data/DoctrineORMModule/Migrations/Version20180722171236.php" from schema differences.
> doctrine-module migrations:migrate --no-interaction
Loading configuration from the integration code of your framework (setter).
                                                                    
                    Doctrine Database Migrations                    
                                                                    

Migrating up to 20180722171236 from 0

  ++ migrating 20180722171236

     -> CREATE TABLE user_users (id INT AUTO_INCREMENT NOT NULL, role_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(60) NOT NULL, avatar LONGTEXT DEFAULT NULL, last_login DATETIME DEFAULT NULL, created DATETIME DEFAULT NULL, modified DATETIME DEFAULT NULL, active TINYINT(1) DEFAULT '1' NOT NULL, INDEX IDX_F6415EB1D60322AC (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
     -> CREATE TABLE user_roles (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created DATETIME DEFAULT NULL, modified DATETIME DEFAULT NULL, active TINYINT(1) DEFAULT '1' NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
     -> CREATE TABLE user_password_recoveries (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, token VARCHAR(255) NOT NULL, created DATETIME DEFAULT NULL, modified DATETIME DEFAULT NULL, active TINYINT(1) DEFAULT '1' NOT NULL, INDEX IDX_7F8992A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
     -> ALTER TABLE user_users ADD CONSTRAINT FK_F6415EB1D60322AC FOREIGN KEY (role_id) REFERENCES user_roles (id)
     -> ALTER TABLE user_password_recoveries ADD CONSTRAINT FK_7F8992A76ED395 FOREIGN KEY (user_id) REFERENCES user_users (id)

  ++ migrated (0.61s)

  ------------------------

  ++ finished in 0.61s
  ++ 1 migrations executed
  ++ 5 sql queries
> git add data/DoctrineORMModule/Migrations/*.php

```

### 2.4 - Initialize fixtures

Now just initialize fixtures and your application is ready to run. Use the configured command **fixtures-init**.

```shell
composer fixtures-init
> ./vendor/bin/doctrine-module orm:fixtures:load
  > purging database
  > loading [0] User\Fixture\LoadRole
  > loading [1] User\Fixture\LoadUser

```

Have fun!

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