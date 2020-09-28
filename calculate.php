<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\Calculator as Calculator;

if (PHP_SAPI != "cli") {
    exit;
}
if ($argc==1 || $argc == 2 && $argv[1] == '-h') {
    ?>
    This is a command line PHP script with one option.

    Usage:
    <?php echo $argv[0]."\n\n"; ?>
    '-h' - help

    Argument - expression, like "(2+2)^2+2*2"

<?php } else {
    $calculator = new Calculator();
    $calculator->debug = count($argv) > 2 && $argv[2] == '--debug';
    if (count($argv) > 1) {
        $calculator->calculate($argv[1]);
    }
}