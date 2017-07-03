<p align="center">
<img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Talkstuff Web Backend

Ensure that for every clone you make sure to correct a bug I discovered in laravel's Illuminate\Console\GeneratorCommand.php file.

Replace the return statement for the 'qualifyClass' method to this:
return $this->getDefaultNamespace(trim($rootNamespace, '\\')).'\\'.$name;

The default one throws this error when working with Caffeinated modules:
Allowed memory size of 536870912 bytes exhausted