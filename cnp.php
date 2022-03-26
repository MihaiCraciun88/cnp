<?php
// include 'vendor/autoload.php';
include 'src/functions.php';

if ($argc < 2) {
    echo 'Introdu CNP';
    exit(-1);
}

$cnp = $argv[1];
if (!isCnpValid($cnp)) {
    echo 'CNP invalid';
    exit(-2);
}

echo 'CNP valid';