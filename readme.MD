ID3
===

Simple ID3 processing - where ID3 libraries not installed/ you don't want the pain of installing a PECL library

Status
------

Work-in-progress

Set-up
------

    composer require oconnedk/id3

Running
-------

    php src/test.php


Testing
-------

    vendor/bin/phpunit Tests/

Coding Standard
---------------

Uses PSR2 - enforced with PHPCS, like this:

    ./vendor/bin/phpcs --config-set default_standard PSR2
    ./vendor/bin/phpcs src/
