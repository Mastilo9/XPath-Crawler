<?php

class WebCrawlerCommand {
    private WebCrawler $crawler;

    public function __construct(WebCrawler $crawler) {
        $this->crawler = $crawler;
    }

    public function run(): void {
        // fetch and process products
        $crawler = $this->getCrawler();
        $crawler->run();
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
