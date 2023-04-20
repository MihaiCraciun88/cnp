<?php
// include 'vendor/autoload.php';
include 'src/functions.php';

function main(int $argc, array $argv): int
{
    if ($argc < 2) {
        echo 'Introdu CNP';
        return -1;
    }

    $cnp = $argv[1];
    if (!isCnpValid($cnp)) {
        echo 'CNP invalid';
        return -2;
    }

    echo 'CNP valid';
    return 0;
}

exit(main($argc, $argv));
