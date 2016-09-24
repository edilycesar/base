<?php
require_once './vendor/autoload.php';

use \League\Csv\Reader;
use \GuzzleHttp\Client;

$guz = new \GuzzleHttp\Client();

$path = getcwd() . "/files/urls.csv";

$csvData = Reader::createFromPath($path);

$client = new Client();

foreach ($csvData as $csvRow) {
    $uri = trim($csvRow[0]);
    echo $uri;             
    
    $httpResponse = $client->get($uri);
    
    echo $httpResponse->getStatusCode() == "200" ? " OK" : " ERRO";
    
    echo PHP_EOL;
}