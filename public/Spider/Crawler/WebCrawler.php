<?php

class WebCrawler {
    private WebParser $parser;
    private CurlClientService $curlClientService;
    private string $url;

    public function __construct(WebParser $parser, CurlClientService $curlClientService, string $url) {
        $this->parser = $parser;
        $this->curlClientService = $curlClientService;
        $this->url = $url;
    }

    public function run(): array {
        $products = [];

        $parser = $this->getParser();
        $currentPageUrl = $this->getUrl();
        $client = $this->getCurlClientService();

        while ($currentPageUrl) {
            try {
//                $content = $client->request($currentPageUrl, true);
                $content = $client->request($currentPageUrl);
                $dataFromListingPage = $parser->parseListing($content, $currentPageUrl);

            } catch (\Exception $e) {
                break;
            }

        }

        $a = 1;


        return $products;
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
     * @return CurlClientService
     */
    public function getCurlClientService(): CurlClientService {
        return $this->curlClientService;
    }

    /**
     * @param CurlClientService $curlClientService
     */
    public function setCurlClientService(CurlClientService $curlClientService): void {
        $this->curlClientService = $curlClientService;
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