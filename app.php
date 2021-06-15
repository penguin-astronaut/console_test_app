<?php
require 'vendor/autoload.php';

try {
    $app = new Penguin\ConsoleApp\App();
    $app->run();
} catch (Exception $exception) {
    echo $exception->getMessage();
}