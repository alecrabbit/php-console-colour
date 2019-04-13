# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).


## [Unreleased]

## [0.4.0] - 2019-04-13
### Changed
 - namespace of `Terminal::class` to `AlecRabbit\Control`

## [0.3.0] - 2019-04-08
### Added
 - `Cursor::class`
### Changed
 - namespace of `Cursor::class` to `AlecRabbit\Control`
 
## [0.2.3] - 2019-04-08
### Added
 -  method `none(string $text)` in`AlecRabbit\ConsoleColour\Theme::class` 
 
## [0.2.2] - 2019-04-08
### Fixed
 - minor `TerminalInterface` fix
 
## [0.2.0] - 2019-04-04
### Added
 - `Control\Cursor::class`
 
## 0.1.0 - 2019-03-24
### Changed
 - namespace to `AlecRabbit\ConsoleColour`

### Added
 - `AlecRabbit\ConsoleColour\Theme::class` with:
      - method `italic(string $text)`
      - method `dark(string $text)`
      - method `darkItalic(string $text)`
      - method `white(string $text)`
      - method `whiteBold(string $text)`
      - method `comment(string $text)`
      - method `yellow(string $text)`
      - method `error(string $text)`
      - method `red(string $text)`
      - method `green(string $text)`
      - method `info(string $text)`
      - method `underline(string $text)`
      - method `underlineBold(string $text)`
      - method `underlineItalic(string $text)`
      
### Removed
 - `AlecRabbit\ConsoleColour\Themed::class`
 
## [0.0.4] - 2019-03-19

[Unreleased]: https://github.com/alecrabbit/php-console-colour/compare/0.4.0...HEAD
[0.2.3]: https://github.com/alecrabbit/php-console-colour/compare/0.2.2...0.2.3
[0.2.2]: https://github.com/alecrabbit/php-console-colour/compare/0.2.0-BETA.1...0.2.2
[0.2.0]: https://github.com/alecrabbit/php-console-colour/compare/0.0.4-RC2...0.2.0-BETA.1
[0.0.4]: https://github.com/alecrabbit/php-console-colour/compare/0.0.3...0.0.4-RC2
