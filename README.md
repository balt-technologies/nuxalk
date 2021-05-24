# NUXALK - Check for updates based on PHP Composer files

Nuxalk is a PHP package which helps you to check for updates using your Composer
Json and Lock file. Other than Composer itself it doesn't require Composer to be
installed or to the dry run in the same project. 

Therefore you can permanently check your repos for updates.

## Installation

    composer require balt-technolgies/nuxalk

## Usage

    ./vendor/bin/nuxalk composer.json composer.lock

