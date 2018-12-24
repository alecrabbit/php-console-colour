<?php
/**
 * User: alec
 * Date: 12.10.18
 * Time: 15:12
 */
require_once __DIR__ . '/../vendor/autoload.php';


use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;
use Symfony\Component\VarDumper\Dumper\ContextProvider\CliContextProvider;
use Symfony\Component\VarDumper\Dumper\ContextProvider\SourceContextProvider;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Symfony\Component\VarDumper\Dumper\ServerDumper;
use Symfony\Component\VarDumper\VarDumper;

// snippet
if (!defined('APP_DEBUG')) {
    define('APP_DEBUG', true);
}

// snippet
if (defined('APP_DEBUG') && APP_DEBUG ) {
    if (!defined('DEBUG_DUMP_EXCEPTION')) {
        define('DEBUG_DUMP_EXCEPTION', false); // change to 'true' to dump exception message and trace
    }
    if (!defined('DEBUG_DUMP_EXCEPTION_CLASS')) {
        define('DEBUG_DUMP_EXCEPTION_CLASS', false); // change to 'true' to dump exception class
    }
}

$cloner = new VarCloner();
$fallbackDumper = \in_array(\PHP_SAPI, array('cli', 'phpdbg')) ? new CliDumper() : new HtmlDumper();
$dumper = new ServerDumper('tcp://127.0.0.1:9912', $fallbackDumper, array(
    'cli' => new CliContextProvider(),
    'source' => new SourceContextProvider(),
));

VarDumper::setHandler(function ($var) use ($cloner, $dumper) {
    $dumper->dump($cloner->cloneVar($var));
});