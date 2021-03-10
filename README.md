
# [authapp](http://authapp.erickferreira.ml)


### Simple authenticate app

#### the idea of his app is to better UNDERSTAND how authentication works


### Login

![login](https://github.com/erickferreir4/auth-app/blob/master/app/assets/imgs/authapp-login.png?raw=true)

### Register

![register](https://github.com/erickferreir4/auth-app/blob/master/app/assets/imgs/authapp-register.png?raw=true)

### Info

![Info](https://github.com/erickferreir4/auth-app/blob/master/app/assets/imgs/authapp-info.png?raw=true)

### Edit

![Edit](https://github.com/erickferreir4/auth-app/blob/master/app/assets/imgs/authapp-edit.png?raw=true)

#### This app was created, thinking about database storage with php sqlite, with a focus on LEARNING.

some techniques that were applied in the development

```
- Factory Method
    
    ConnectionFactory.php with switch in PDO


- Log

    LoggerHTML.php and LoggerTXT.php for logging transactions in /tmp
    

- Gateways

    TableDataMapper
        LoginController.php domain to LoginModel.php
        RegisterController.php domain to RegisterModel.php
        EditController.php domain to EditModel.php


- Transaction

    Transaction.php for greater control of database persistence


- Interface

    to have a contract with the following classes:

        ILogger.php for LoggerHTML.php and LoggerTXT.php
        IAssets.php for Assets.php and AssetsCdn.php
        IController.php for all controllers


- Dependency Injection

    TemplateTrait.php created the setAssets method to inject similar Assets classes
    Transaction.php created the setLogger method to inject similar logger classes
    

- Trait

    TemplateTrait.php was created to have the same methods in view controllers
    AccountTop.php was created to have the same header on the pages
    AccountTrait.php was created to have the same different control methods
    ModelTrait.php was created to have the same different control methods
    SocialTrait.php was created to have the same different control methods


- Composer

    was used together with the docker for social login libraries
    autoload is used for automatic class loading

- Docker
    
    used to create a container for the application
    
```
