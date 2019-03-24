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

