ID3
===

Simple ID3 processing - where ID3 libraries not installed/ you don't want the pain of installing a PECL library

Why?
----

I have a large collection of MP3s, many created a long time back. They are all well organised in a directory structure with (almost always) the track names in the filename.
e.g.

    Artist - Album Name/Track Name.mp3

The problem is that most modern MP3 players need [ID3](https://en.wikipedia.org/wiki/ID3) tags to organise songs, artists and albums, and I'd like to add ID3 tags to these files.

This mini project then serves a number of purposes:

1. Identify files/ albums needing ID3 tags
2. Automatically conjure-up the artist, album and track names from the directory structure
3. Add the tags to the affected files

Status
------

Work-in-progress

Set-up
------

    composer require oconnedk/id3

Testing
-------

    vendor/bin/phpunit -v -c Tests/

Coding Standard
---------------

Uses PSR2 - enforced with PHPCS, like this:

    ./vendor/bin/phpcs --config-set default_standard PSR2
    ./vendor/bin/phpcs src/ Tests/
