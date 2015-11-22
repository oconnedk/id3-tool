ID3
===

The purpose of this tool is to identify media files in need of [ID3](https://en.wikipedia.org/wiki/ID3) tags and then to amend those files, adding in the necessary tags.

ID3 tags help to provide the artist name, album name, track name, running order etc of such files and are used by most modern media players. See: [ID3 tags](https://en.wikipedia.org/wiki/ID3)

[![Build Status](https://img.shields.io/travis/oconnedk/id3-tool.svg?style=flat-square)](https://travis-ci.org/oconnedk/id3-tool)

Why?
----

I have a large collection of MP3s, many created a long time back. They are all well organised in a directory structure with (almost always) the track names in the filename and the album/ artist name in the containing directory/ folder.
e.g.

    Marvin Gaye - What's Going On/Marvin Gaye - 09 Inner City Blues.mp3
    Muse - Origin of Symmetry/Muse - 01 New Born.mp3

The problem is that most modern MP3 players need ID3 tags to organise songs, artists and albums, and I'd like to add ID3 tags to these files. Otherwise you end up with albums attributed to an anonymous artist and (sometimes) the incorrect track order.

This mini project then serves a number of purposes:

1. Identify files/ albums needing ID3 tags
2. Automatically conjure-up the artist, album and track names from the directory structure
3. Add the tags to the affected files

Status
------

**Complete**

- Media discovery

**To-do**

- Media amendment (auto-tagging files where necessary)


Set-up
------

    git clone git@github.com:oconnedk/id3-tool.git
    cd id3-tool
    composer install

Usage
-----

To list albums (folders) requiring ID3 tag info:

    app/console find /path/to/your/media

e.g.

    app/console find ./Tests/Resources/mp3/

Testing
-------

    vendor/bin/phpunit -v -c Tests/


Coding Standard
---------------

Uses [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md) - enforced with [PHPCS](https://github.com/squizlabs/PHP_CodeSniffer), like this:

    ./vendor/bin/phpcs --config-set default_standard PSR2
    ./vendor/bin/phpcs src/ Tests/


Automation
----------

Automatic testing (PHPUnit) and coding standards compliance (PHPCS) covered by Travis.

[TravisCI - Build Status](https://travis-ci.org/oconnedk/id3-tool/builds)
