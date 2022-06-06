<?php

class WebCrawler {
    private WebParser $parser;
    private CurlClientService $curlClientService;
    private ProductRepository $productRepository;
    private string $url;

    public function __construct(WebParser $parser, CurlClientService $curlClientService, ProductRepository $productRepository, string $url) {
        $this->parser = $parser;
        $this->curlClientService = $curlClientService;
        $this->productRepository = $productRepository;
        $this->url = $url;
    }

    public function run(): void {
        $parser = $this->getParser();
        $currentPageUrl = $this->getUrl();
        $client = $this->getCurlClientService();
        $productRepository = $this->getProductRepository();

        $productsCount = 0;
        while ($currentPageUrl || $productsCount >= 25000) {
            try {
//                $content = $client->request($currentPageUrl, true);
                $listingContent = $client->request($currentPageUrl);
                $dataFromListingPage = $parser->parseListing($listingContent);

                foreach ($dataFromListingPage as $data) {
                    try {
                        $merged_data = $data;

                        if ($data['goToSinglePage']) {
//                            $content = $client->request($data['link'], true);
                            $content = $client->request($data['link']);
                            $dataFromSinglePage = $parser->parseSinglePage($content);

                            $merged_data = array_merge($dataFromSinglePage, $merged_data);
                        }

                        $product = $productRepository->mapDataToNewProduct($merged_data);
                        if ($product === null) {
                            continue;
                        }
                    } catch (\Throwable $e) {
                        echo $e->getMessage();

                        continue;
                    }

                    $productRepository->insertProductToDatabase($product);
                    $productsCount++;
                }

                $currentPageUrl = $parser->parseNextPageLink($listingContent);
            } catch (\Throwable $e) {
                echo $e->getMessage();

                break;
            }
        }
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
     * @return ProductRepository
     */
    public function getProductRepository(): ProductRepository {
        return $this->productRepository;
    }

    /**
     * @param ProductRepository $productRepository
     */
    public function setProductRepository(ProductRepository $productRepository): void {
        $this->productRepository = $productRepository;
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