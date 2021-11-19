# Lesson 1: Install the project

# What you will learn
 - How to create the project structure
 - How to install packages with Composer
 - How to configure and run PHPUnit
 - How to configure and run PHP Code Sniffer
 - How to configure and run PHPStan
 - How to use a Makefile

# Lesson notes

- [Project setup](lesson_1.md#project-setup)
- [Download Composer](lesson_1.md#download-composer)
- [Configure Composer](lesson_1.md#configure-composer)
- [Run Composer](lesson_1.md#run-composer)
- [Configure PHPUnit](lesson_1.md#configure-phpunit)
- [Run PHPUnit](lesson_1.md#run-phpunit)

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

## Download Composer
In order to install the required PHP packages we need to install a PHP package manager called Composer.  This can be downloaded from [their website](https://getcomposer.org/).
Once composer has been installed you should have a `composer.phar` file the project root.
```
project/
│   composer.phar
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
│
└───.phpunit.cache/
└───config/
└───public/
└───reports/
└───tests/
└───vendor/
```

[Go to lesson index](index.md)

[Go back to readme](../../README.md)