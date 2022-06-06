<?php

include './Services/DatabaseService.php';
include './Services/CurlClientService.php';
include './Spider/webCrawlerCommand.php';
include './Spider/Parser/WebParser.php';
include './Spider/Parser/PolovniAutomobiliWebParser.php';
include './Spider/Crawler/WebCrawler.php';
include './Repository/ProductRepository.php';
include './Entity/Product.php';

const DB_HOST = 'mysql';
const DB_USERNAME = 'root';
const DB_PASSWORD = 'root';
const DB_DATABASE = 'webapp';

const WEB_STORE_URL_1 = 'https://www.polovniautomobili.com/auto-oglasi/pretraga';

// Report all errors except E_NOTICE
error_reporting(E_ALL & ~E_WARNING);
set_error_handler(function($errno, $errstr, $errfile, $errline ){
    if ($errno != E_WARNING) {
        throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
    }
});

$dbService = new DatabaseService(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$curlClientService = new CurlClientService();

$parser = new PolovniAutomobiliWebParser();
$productRepository = new ProductRepository($dbService);

$crawler = new WebCrawler($parser, $curlClientService, $productRepository,WEB_STORE_URL_1);

$webCrawlerCommand = new WebCrawlerCommand($crawler);
$webCrawlerCommand->run();
