# Terminal for Kohana v3 (development)

Terminal Module is a tools like [rails](http://rubyonrails.org/) 'script/generate'.

## Requirements

* Linux **ONLY**
* PHP 5.2+
* [Kohana] v3.0+ (http://github.com/kohana/kohana)


## Install

Move the file named 'kohana' to Kohana application root path.

## TODO

* Create Model (support extend, like ORM, Sprig)
* Create View (Think more about it)

## Done

* Create Controller (support multi-methods)
* Create Controller (support extend, like Template, REST, etc)



## Usage

Controller: classes/controller/home/template.php

     ./kohana controller home/template before index after

REST Controller: classes/controller/api/user.php

     ./kohana controller api/user index update delete --e=rest
