# Product Catalog
> My first web application created with PHP.

## General info
The Product Catalog is a simple web application that allows the administrator to manage categories, products and registered users. Regular users can add products to the clipboard and generate cost estimates in the PDF format.

<p><img src="https://i.imgur.com/TdMzlfR.png" alt="Homepage"></p>

## Technologies
* PHP 7
* AJAX
* JavaScript with jQuery
* Bootstrap 4
* MySQL

## Setup
1. Download project files directly or by cloning the repo
1. Install the project dependencies with `Composer`:
```bash
$ composer update
```
3. Use `phpMyAdmin` to import this database dump: [Database/catalog_database.sql](Database/catalog_database.sql)
1. If you create a database with a name other than `catalog_database`, set your database name in [db_config.php](db_config.php)

## Features
Administrator:
* Add/edit/delete categories
* Add/edit/delete products
* Edit/delete users
* Set slides and featured categories on the homepage 

User:
* Register / Login
* Browse products using different sorting types
* Add products to the clipboard
* Generate cost estimates in PDF format

