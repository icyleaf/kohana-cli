# Terminal for Kohana v3 (development)

Terminal Module is a tools like [rails](http://rubyonrails.org/) 'script/generate'.

## Requirements

* Linux **ONLY**
* PHP 5.2+
* [Kohana](http://github.com/kohana/kohana) v3.0+


## Install

Move the file named 'kohana' to Kohana application root path with `index.php` together.

## TODO

* Added the new method to exist controller
* Support params of methods in controller
* (Think more about it)

## Done

* Create Controller (support multi-methods)
* Create Controller (support extend, like Template, REST, etc)
* Create Model (support extend, like ORM, Sprig)
* Create View
* Generate all of MVC files

## Usage

Controller: classes/controller/home/template.php

     ./kohana controller home/template before index after

Controller extends REST: classes/controller/api/user.php

     #   **create**  APPPATH/classes/controller/api/user.php

     ./kohana controller api/user index update delete --i=rest

Model extends ORM: classes/model/user.php

     #   **create**  APPPATH/classes/model/user.php

     ./kohana model user --e=orm

Generate all of MVC files:

     #   **create**  APPPATH/classes/controller/topic.php
     #   **create**  APPPATH/classes/model/topic.php
     #   **create**  APPPATH/view/topic.php

     ./kohana controller topic list view update delete --i=template --e=orm --a
