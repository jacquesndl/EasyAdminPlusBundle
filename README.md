# EasyAdminPlusBundle

EasyAdminPlusBundle is a Symfony (>4.4) bundle wrapper for the [EasyCorp/EasyAdminBundle](https://github.com/EasyCorp/EasyAdminBundle/tree/master) (2.3.x) which includes some extra features. 

## Install
 ```shell
composer require jacquesndl/easyadmin-plus-bundle
```

## Setup
The bundle provides an official recipe to help you configure the bundle

```yaml
# config/routes/jacquesndl_easy_admin_plus.yaml

jacquesndl_easy_admin_plus:
    resource: '@JacquesndlEasyAdminPlusBundle/Resources/config/routing.yaml'
    prefix: /admin
```

## Features
- Admin management to restrict access to the secure area.
- Add templates for libraries [vich/uploader-bundle](https://github.com/dustin10/VichUploaderBundle) and [greg0ire/enum](https://github.com/greg0ire/enum).

## Getting started
1. [Authentication](doc/chapter-1.md)
2. [Additional templates](doc/chapter-2.md)
