[![Build Status](https://travis-ci.org/mrdejong/themer.svg)](https://travis-ci.org/mrdejong/themer)
[![Downloads](https://poser.pugx.org/mrdejong/themer/downloads.svg)](https://packagist.org/packages/mrdejong/themer)
[![License](https://poser.pugx.org/mrdejong/themer/license.svg)](https://packagist.org/packages/mrdejong/themer)

## Important update
As of today I'm rethinking Themer, how the project is going right now isn't the way I want to. It is to messy and the code ain't wunderfull. And testing is no where in side! That must change right now.

First steps will be to write a simple list with features that I want.
Second step is to delete all non required code.

The new approuch I will adapt is write test first and then the implementation. Also I will try and stick to the scrum method of working on this and feature projects.

Please be patient as I will take some time todo this.

Thanks,

Alexander.
P.S. Any spelling mistakes made while writing this is because I don't re-read it :)


## Introducing Themer!

Themer is a package that manages themes in laravel, the smart way!

### Introduction

Themer is a theme manager for laravel, which uses laravels build in view provider. This means that if you install this package your application still works, without any editions to your code.

Sure the current state of this package is 'bare bone', but I'm planing so much cool stuff this that your mouth will open!

Lets continue to the installation.

### Installation

Well this is easy, open up your composer.json file. Then find the line that starts with `"require": {` in that array add:

```json
"mrdejong/themer": "dev-master"
```

Done that? Run `composer update`

Let that do his work, when it is done we are going to do some hacky work!

You can close your composer.json file, and open up the app.php file located in `[root]/app/config/app.php` and look for this line of code:
```php
'Illuminate\View\ViewServiceProvider',
```

You want to comment that line of code, since Themer's service provider extends from the ViewServiceProvider.

Now add the following line of code to the same array as the ViewServiceProvider
```php
'Mrdejong\Themer\ThemerServiceProvider',
```

Congratulations! You have now successfully installed themer.

But wait, the configuration for themer!?
Ahh, don't worry the default configuration is good to go, but sure you want to change thing here and there run the following command:
```
php artisan config:publish mrdejong/themer
```

Later on I will take on a tour threw the configuration file!

### Notice

Since themer is in its early state of development, I'm going to add documentation as I go. For now I feel that you can go with this, the configuration file of themer is commented very well as I may say.

### Thanks

Thanks for reading this readme and  ignore my rich mistakes in this language!

Have fun with themer, and watch out for new and super cool updates!

### License
Since it is written in laravel, I will use the very same license. It is nonsense to use anything different.

Licensed under the [Mit license](http://opensource.org/licenses/MIT)
