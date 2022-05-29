<?php

class WebCrawlerCommand {
    private DatabaseService $dbService;
    private WebCrawler $crawler;

    public function __construct(DatabaseService $dbService, WebCrawler $crawler) {
        $this->dbService = $dbService;
        $this->crawler = $crawler;
    }

    public function run(): void {
        $products = [];

        // fetch and process products
        $crawler = $this->getCrawler();
        $products = $crawler->run();



        $a = 1;
    }

    /**
     * @return DatabaseService
     */
    public function getDbService(): DatabaseService {
        return $this->dbService;
    }

    /**
     * @param DatabaseService $dbService
     */
    public function setDbService(DatabaseService $dbService): void {
        $this->dbService = $dbService;
    }

    /**
     * @return WebCrawler
     */
    public function getCrawler(): WebCrawler {
        return $this->crawler;
    }

    /**
     * @param WebCrawler $crawler
     */
    public function setCrawler(WebCrawler $crawler): void {
        $this->crawler = $crawler;
    }
}
