# Lesson 1: Install the project

# What you will learn
 - How to create the project structure
 - How to install packages with Composer
 - How to configure and run PHPUnit
 - How to configure and run PHP Code Sniffer
 - How to configure and run PHPStan
 - How to use a Makefile

# Lesson sections

1. [Project setup](lesson_1.md#project-setup)
2. [Download Composer](lesson_1.md#download-composer)
3. [Configure Composer](lesson_1.md#configure-composer)
4. [Run Composer](lesson_1.md#run-composer)
5. [Configure PHPUnit](lesson_1.md#configure-phpunit)
6. [Run PHPUnit](lesson_1.md#run-phpunit)
7. [Configure PHP Code Sniffer](lesson_1.md#configure-php-code-sniffer)
8. [Run PHP Code Sniffer](lesson_1.md#run-php-code-sniffer)
9. [Configure PHPStan](lesson_1.md#configure-phpstan)
10. [Run PHPStan](lesson_1.md#run-phpstan)

## Project setup
Create a new folder called `project`
Inside this folder create the following subdirectories

```
project/
└───config/
└───public/
└───reports/
└───tests/
```

If you intend on storing the project in a git repository you will need the following `.gitignore` file in the project directory
```
.idea
.phpunit.cache
vendor
reports
!reports/.gitkeep
```
A single PHP file will be used to hold common functions.  Create a file called `common.php` in the project route.  For now this will be an empty PHP file so just include the following:
```php
<?php

```
## Download Composer
In order to install the required PHP packages we need to install a PHP package manager called Composer.  This can be downloaded from [their website](https://getcomposer.org/).
Once composer has been installed you should have a `composer.phar` file the project root.
```
project/
│   composer.phar
│   common.php
│
└───config/
└───public/
└───reports/
└───tests/
```

## Configure Composer
Create a `composer.json` file in the project root and include `phpunit/phpunit`, `phpstan/phpstan`, `squizlabs/php_codesniffer` with the versions shown below

```json
{
  "name": "mycourse/course-php-login",
  "description": "How To Code Well Course: PHP Login",
  "type": "project",
  "require-dev": {
    "phpunit/phpunit": "^9.5",
    "phpstan/phpstan": "^1.1",
    "squizlabs/php_codesniffer": "^3.6"
  },
  "authors": [
    {
      "name": "My Name",
      "email": "my@email.address.com"
    }
  ],
  "minimum-stability": "stable"
}
```

```
project/
│   composer.phar
│   composer.json
│   common.php
│
└───config/
└───public/
└───reports/
└───tests/
```
## Run Composer

Run the following command in the terminal to install the composer packages.
```bash
composer.phar install
```
This will create a vendor directory in the project root that contains the required packages. This command will also create a `composer.lock` file which contains meta information about the packages that have been installed
```
project/
│   composer.phar
│   composer.json
│   composer.lock
│   common.php
│
└───config/
└───public/
└───reports/
└───tests/
└───vendor/
```

## Configure PHPUnit
1. Run the following command in a terminal
```bash
./vendor/bin/phpunit --generate-configuration
```
2. Press enter and accept all the defaults.  This will create the file `phpunit.xml` in the root directory.
3. Open the `phpunit.xml` file in a code editor.  
4. Change the following
```xml
<testsuites>
    <testsuite name="default">
        <directory>tests</directory>
    </testsuite>
</testsuites>
```
to 
```xml
<testsuites>
    <testsuite name="default">
        <directory>reports/coverage</directory>
    </testsuite>
</testsuites>
```
This will change the folder for test coverage.

## Run PHPUnit
Let's test if PHPUnit has been configured. Run the following command
```bash
./vendor/bin/phpunit
```
You should see a similar output to the following:
```bash
PHPUnit 9.5.10 by Sebastian Bergmann and contributors.

Runtime:       PHP 8.0.12
Configuration: /path/to/course/course-php-login/project/phpunit.xml

No tests executed!
```

You should also see a folder called `.phpunit.cache` in the project root
```
project/
│   composer.phar
│   composer.json
│   composer.lock
│   common.php
│
└───.phpunit.cache/
└───config/
└───public/
└───reports/
└───tests/
└───vendor/
```
## Configure PHP Code Sniffer
To ensure that our code conforms to good coding standards we need to configure the PHP Code Sniffer.
Create a xml file called `coding_standard.xml` in the project root and include the following.
```xml
<?xml version="1.0"?>
<ruleset name="course">
    <description>Course coding standard.</description>
    <rule ref="PSR2" />
</ruleset>
```
This will ensure that we are following the PSR2 coding standard. We can add other rules to the ruleset if we want to. 

## Run PHP Code Sniffer
To make sure the PHP Code Sniffer works lets try it against our blank project.
Run the following command:
```bash
./vendor/bin/phpcs --standard=coding_standard.xml common.php tests public config
```
If it works then no error or output will be reported

The PHP Code Sniffer also comes with a command that will automatically fix any linting errors for use.  This command is called `phpcbf`. To run `phpcbf` enter the following in the terminal and press enter:
```bash
./vendor/bin/phpcbf --standard=coding_standard.xml common.php tests public config
```
You should see the following output:
```bash
No fixable errors were found

Time: 72ms; Memory: 6MB
```
## Configure PHPStan
To configure PHPStan add the following `phpstan.neon` to the project root:
```yaml
parameters:
	level: 9
	paths:
		- config
		- tests
		- public
		- common.php
```

## Run PHPStan
Let's run PHPStan to make sure it is set up correctly. Run the following command:
```bash
./vendor/bin/phpstan
```
Your output should be similar to the following

```bash
Note: Using configuration file /path/to/code/course/course-php-login/project/phpstan.neon.
 0/0 [▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓] 100%

                                                                                                                        
 [OK] No errors                                                                                                         
                                                                                                                        
```

[Go to lesson index](index.md)

[Go back to readme](../../README.md)