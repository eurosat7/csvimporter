# csvimporter

This repository is for learning purposes.

I use it on reddit to show people tricks and pitfalls.

## focus

This are the things I would like to point you to:

- composer autoloader
- Constructor Injection only
- complete Type Declarations
- config as DTO (no parsing)
- obey to standards (like per-cs 2.0)
- qa tooling (rector, phpcpd, phpmd, phpstan, psalm)
- non blocking php sessions with memcached
- generic building of mysqli prepared statements
- composition with interfaces (DatabaseHandler&HasTransaction)
- basic docker setup
- using make (Makefile)

## pre requisites

First: Please do not use windows. This will make your life easier.

I suggest Ubuntu 22. It can boot from an usb stick.

You need to have the following installed on your machine:

- git
- docker
- docker-compose
- make
- composer

Use google if you do not know how to install them on your os.

You also should have a capable (!) editor. Choose one:

- PhpStorm - the leading IDE, very capable, you can get a free trial. Prefered by backend developers.
- VS Code - lacks a bit but is still very good. and it is free. :) Prefered by frontend developers. 

If you want to use edit or vim oder nodepad++ or sublimetext - fine! You will be slow and almost blind.

And please: Have a mouse with a thumb button. This is very important as it allows you to jump back in code: 
It is like undo for your cursor position, but it does not change code at all.

## installing

You open a terminal (aka "shell") and git clone this repository while being in your working dir.

    git clone https://github.com/eurosat7/csvimporter.git

A subfolder named "csvimporter" will be created. Enter that subfolder. 
 
Open your editor on that folder.

Look into "Makefile" if you want to know what "make" can do.

Run "make" or "make install".

There will be output. Read it!

