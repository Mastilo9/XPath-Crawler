<?php

class WebCrawler {
    private WebParser $parser;
    private string $url;

    public function __construct(WebParser $parser, string $url) {
        $this->parser = $parser;
        $this->url = $url;
    }

    public function run(): array {
        $products = [];

        $parser = $this->getParser();
        $currentPageUrl = $this->getUrl();


    }

    /**
     * @return WebParser
     */
    public function getParser(): WebParser {
        return $this->parser;
    }

    /**
     * @param WebParser $parser
     */
    public function setParser(WebParser $parser): void {
        $this->parser = $parser;
    }

    /**
     * @return string
     */
    public function getUrl(): string {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void {
        $this->url = $url;
    }
}