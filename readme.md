GIVEu
=====
###Church Content Management System

This is a church content management with online giving system build on Lavarel Framework. Please see attached installation guide.
Other comments or concerns please email at [contact@amdtllc.com](mailto:contact@amdtllc.com)
or open a ticket [https://amdtllc.com/support](https://amdtllc.com/support).


> **Note:**
> We aim to provide this application for free and provision a marketplace for developers to create their themes and plugins that can be added to the platform.

##Installation
> **Initial setup**

> - Create a database
> - Edit your .env file
> - `composer install`
> - `php artisan migrate`

##Themes
You can create your own front-end themes and upload them via `settings > themes`.
Themes must conform to a set of predefined standards in order to be compatible with this application.

**Theme options**

- `theme()->[function]` - loads an instance of theme helper through which you can call theme functions. Replace [function] with:

    - `theme()->[option]` - same as `themeOpts()` below
    - `mainMenu()` - display main navigation bar
    - `logoNav()` - display nav-bar with or without logo. Logo image must be in */public/img/logo.png*

- `themeOpts()->[option]` - calls theme options stored in the database. Options:

 - `id (integer)`
 - `name (string)`
 - `description (text)`
 - `location (string) (path of the theme)`
 - `active (bool)`

## Official Documentation

Documentation for the framework can be found on the  [here](https://amdtllc.com)

##Future##
[ ] Plugins support

[ ]


## Contributing

Thank you for considering contributing! The contribution guide can be found in the documentation

## Security Vulnerabilities

If you discover a security vulnerability within this application, please send an e-mail to safety@amdtllc.com. All security vulnerabilities will be promptly addressed.

## License
This project is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
