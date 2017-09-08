[![Build Status](https://img.shields.io/travis/CakeDC/cakephp-forum/master.svg?style=flat-square)](https://travis-ci.org/CakeDC/cakephp-forum)
[![Coverage Status](https://img.shields.io/coveralls/CakeDC/cakephp-forum.svg?style=flat-square)](https://coveralls.io/r/CakeDC/cakephp-forum?branch=master)
[![License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](LICENSE)

# Forum plugin for CakePHP

## Installation

You can install this plugin into your CakePHP application using [composer](http://getcomposer.org).

The recommended way to install composer packages is:

## Database setup

Run migrations:
```$bash
bin/cake migrations migrate --plugin=CakeDC/Forum
```

Seed database:
```$bash
bin/cake migrations seed --seed=EverythingSeed --plugin=CakeDC/Forum
```
