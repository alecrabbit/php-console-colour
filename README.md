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

inspired by [JakubOnderka/PHP-Console-Color](https://github.com/JakubOnderka/PHP-Console-Color)

### Installation 
```bash
composer require alecrabbit/php-console-colour
```
### Themes::class
##### Usage 
```php
$themes = new Themes();
echo $themes->red('This text is red.') . PHP_EOL;
echo $themes->underlinedBold('This text is underlined and bold.') . PHP_EOL;
```
Basically methods of this class just applying corresponding escape sequences to `$text`
```php
// "\033[2;3mThis text is dark and italic.\033[0m"
$colorized = $themes->darkItalic('This text is dark and italic.')
```
##### Methods
> Note: not all methods could be listed.

```php
/**
 * @method comment(string $text)
 * @method error(string $text)
 * @method info(string $text)
 *
 * @method yellow(string $text)
 * @method red(string $text)
 * @method green(string $text)
 * @method cyan(string $text)
 * @method magenta(string $text)
 *
 * @method italic(string $text)
 * @method bold(string $text)
 * @method dark(string $text)
 * @method darkItalic(string $text)
 * @method white(string $text)
 * @method whiteBold(string $text)
 * @method underlined(string $text)
 * @method underlinedBold(string $text)
 * @method underlinedItalic(string $text)
 */
```
> Note: new methods will be added. Pull requests are welcomed.

##### Define your own themes
 * `Themes::class` [How to extend?](docs/howToExtendThemeClass.md)

### ConsoleColor::class
 
 // TODO 

### Examples
 * [using_themes_class.php](https://github.com/alecrabbit/php-console-colour/blob/master/examples/using_themes_class.php)
 
![example](https://raw.githubusercontent.com/alecrabbit/php-console-colour/master/docs/images/example_using_themes_class_output.png)

* [colour.php](https://github.com/alecrabbit/php-console-colour/blob/master/examples/colour.php)
 
![example](https://raw.githubusercontent.com/alecrabbit/php-console-colour/master/docs/images/example_colour_output.png)

> Note: actual colors depend on your terminal color scheme

[xterm-256-color Chart](https://upload.wikimedia.org/wikipedia/commons/1/15/Xterm_256color_chart.svg)
