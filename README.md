# PHP Console Colour

[![PHP Version](https://img.shields.io/packagist/php-v/alecrabbit/php-console-colour.svg)](https://php.net/)
[![Build Status](https://travis-ci.com/alecrabbit/php-console-colour.svg?branch=master)](https://travis-ci.com/alecrabbit/php-console-colour)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/alecrabbit/php-console-colour/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/alecrabbit/php-console-colour/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/alecrabbit/php-console-colour/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/alecrabbit/php-console-colour/?branch=master)
[![Total Downloads](https://poser.pugx.org/alecrabbit/php-console-colour/downloads)](https://packagist.org/packages/alecrabbit/php-console-colour)

[![Latest Stable Version](https://poser.pugx.org/alecrabbit/php-console-colour/v/stable)](https://packagist.org/packages/alecrabbit/php-console-colour)
[![Latest Version](https://img.shields.io/packagist/v/alecrabbit/php-console-colour.svg)](https://packagist.org/packages/alecrabbit/php-console-colour)
[![Latest Unstable Version](https://poser.pugx.org/alecrabbit/php-console-colour/v/unstable)](https://packagist.org/packages/alecrabbit/php-console-colour)

[![License](https://poser.pugx.org/alecrabbit/php-console-colour/license)](https://packagist.org/packages/alecrabbit/php-console-colour)
<!--[![Average time to resolve an issue](http://isitmaintained.com/badge/resolution/alecrabbit/php-console-colour.svg)](http://isitmaintained.com/project/alecrabbit/php-console-colour "Average time to resolve an issue")-->
<!--[![Percentage of issues still open](http://isitmaintained.com/badge/open/alecrabbit/php-console-colour.svg)](http://isitmaintained.com/project/alecrabbit/php-console-colour "Percentage of issues still open")-->

based on [JakubOnderka/PHP-Console-Color](https://github.com/JakubOnderka/PHP-Console-Color)

changes related to usage in docker container on Linux systems

```dockerfile
...
    environment:
      DOCKER_TERM: "$TERM"  # Pass $TERM var to container
...
```

### Terminal::class
```php
    /**
     * @return bool
     */
    public function supportsColor(): bool;

    /**
     * @return bool
     */
    public function supports256Color(): bool;

    /**
     * @param bool $recheck
     * @return int
     */
    public function width(bool $recheck = false): int;

    /**
     * @param bool $recheck
     * @return int
     */
    public function height(bool $recheck = false): int;
```
### Theme::class
##### Usage 
```php
    $theme = new Theme();
    echo $theme->red('This text is red.') . PHP_EOL;
    echo $theme->underlineBold('This text is underlined and bold.') . PHP_EOL;
```
##### Methods
```php
/**
 * @method italic(string $text)
 * @method dark(string $text)
 * @method darkItalic(string $text)
 * @method white(string $text)
 * @method whiteBold(string $text)
 * @method comment(string $text)
 * @method yellow(string $text)
 * @method error(string $text)
 * @method red(string $text)
 * @method green(string $text)
 * @method info(string $text)
 * @method underline(string $text)
 * @method underlineBold(string $text)
 * @method underlineItalic(string $text)
 */
```
> Note: new methods will be added.
##### Add your own methods
 [How to extend `Theme::class`](docs/howToExtendThemeClass.md)

