<?php

include './Services/DatabaseService.php';
include './Services/CurlClientService.php';
include './Spider/webCrawlerCommand.php';
include './Spider/Parser/WebParser.php';
include './Spider/Parser/PolovniAutomobiliWebParser.php';
include './Spider/Crawler/WebCrawler.php';

const DB_HOST = 'mysql';
const DB_USERNAME = 'root';
const DB_PASSWORD = 'root';
const DB_DATABASE = 'webapp';

const WEB_STORE_URL_1 = 'https://www.polovniautomobili.com/';

$dbService = new DatabaseService(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$curlClientService = new CurlClientService();

$parser = new PolovniAutomobiliWebParser();
$crawler = new WebCrawler($parser, $curlClientService, WEB_STORE_URL_1);

$webCrawlerCommand = new WebCrawlerCommand($dbService, $crawler);
$webCrawlerCommand->run();


phpinfo();
