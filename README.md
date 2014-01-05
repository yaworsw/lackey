# Lackey

PHP task runner

[![Latest Stable Version](https://poser.pugx.org/lackey/lackey/v/stable.png)](https://packagist.org/packages/lackey/lackey)
[![Total Downloads](https://poser.pugx.org/lackey/lackey/downloads.png)](https://packagist.org/packages/lackey/lackey)

[![Build Status](https://travis-ci.org/yaworsw/lackey.png?branch=master)](https://travis-ci.org/yaworsw/lackey?branch=master)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/yaworsw/lackey/badges/quality-score.png?s=190a197fc9680ced91d47dee2c4522d9bf28f308)](https://scrutinizer-ci.com/g/yaworsw/lackey/)
[![Code Coverage](https://scrutinizer-ci.com/g/yaworsw/lackey/badges/coverage.png?s=d54e01a2d6358c2eed91d47106328099b7409320)](https://scrutinizer-ci.com/g/yaworsw/lackey/)
[![Dependencies Status](https://depending.in/yaworsw/lackey.png)](http://depending.in/yaworsw/lackey)

## Installing

Make sure you have `~/.composer/vendor/bin/` in your path.

Install lackey globally.

    composer global require lackey/lackey

Add lackey to your project's `composer.json` file.

    {
        "require-dev": {
            "lackey/lackey": "0.1.1"
        }
    }

Update the project's dependencies.

    composer update

## Lackeyfile

The Lackeyfile is where all of your project's lackey tasks are defined.  In the root of your project create a file named `Lackeyfile.php`.

Use this project's [Lackeyfile](Lackeyfile.php) as a guide on how to define lackey tasks.

[![Bitdeli Badge](https://d2weczhvl823v0.cloudfront.net/yaworsw/lackey/trend.png)](https://bitdeli.com/free "Bitdeli Badge")
