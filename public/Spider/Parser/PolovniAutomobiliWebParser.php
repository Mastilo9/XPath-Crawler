<?php

class PolovniAutomobiliWebParser extends WebParser {

    const DEFAULT_HOST = 'https://www.polovniautomobili.com';

    public function parseListing(string $content): array {
        $listingData = [];

        $page = $this->convertStringHtmlPageToDomXPath($content);
        $products = $page->query('//div[@class="js-hide-on-filter"]/article/div[@class="textContentHolder"]/div[@class="textContent"]/h2/a[@class="ga-title"]');

        foreach ($products as $product) {
            $data = [];

            $data['link'] = self::DEFAULT_HOST . $product->getAttribute('href');
            $data['goToSinglePage'] = true;

            $listingData[] = $data;
        }

        return $listingData;
    }

    public function parseSinglePage(string $content): array {
        $productData = [];

        $page = $this->convertStringHtmlPageToDomXPath($content);

        // general info section
        $xpathGeneralInfoPath = '//div[@id="classified-content"]/div/section/section/div/div/div/div/div/div/';
        $xpathGeneralInfoLeft = 'div[@class="uk-width-large-1-2 uk-width-medium-1-1 uk-width-1-1"]/div/div';
        $xpathGeneralInfoRight = 'div[@class="uk-width-medium-1-2"]/div/div';

        $generalInfoLeft = $page->query($xpathGeneralInfoPath . $xpathGeneralInfoLeft);
        if (!empty($generalInfoLeft)) {
            $productData = array_merge($productData, $this->processInfoSection($generalInfoLeft));
        }

        $generalInfoRight = $page->query($xpathGeneralInfoPath . $xpathGeneralInfoRight);
        if (!empty($generalInfoRight)) {
            $productData = array_merge($productData, $this->processInfoSection($generalInfoRight));
        }

        // other info section
        $xpathOtherInfoPath = '//div[@id="classified-content"]/div/div[@class="js-tab-classified-content classified-content"]/section/div/div/div[@class="uk-grid js-hidden uk-margin-top"]/';
        $xpathOtherInfoLeft = 'div[@class="uk-width-medium-1-2 uk-width-1-1"]/div/div';
        $xpathOtherInfoRight = 'div[@class="uk-width-medium-1-2 uk-width-1-1"]/div/div';

        $otherInfoLeft = $page->query($xpathOtherInfoPath . $xpathOtherInfoLeft);
        if (!empty($generalInfoLeft)) {
            $productData = array_merge($productData, $this->processInfoSection($otherInfoLeft));
        }

        $otherInfoRight = $page->query($xpathOtherInfoPath . $xpathOtherInfoRight);
        if (!empty($generalInfoRight)) {
            $productData = array_merge($productData, $this->processInfoSection($otherInfoRight));
        }

        // description
        $xpathDescription = '//div[@id="classified-content"]/div/div[@class="js-tab-classified-content classified-content"]/section[@class="uk-grid uk-margin-top"]/div/div/div/div[@class="uk-width-1-1 description-wrapper"]';
        $description = $page->query($xpathDescription);
        if (!empty($description) || !$description?->length) {
            $descriptionNode = $description->item(0);

            if (!empty($descriptionNode)) {
                $descriptionText = $descriptionNode->nodeValue;

                if (!empty($descriptionText)) {
                    $productData['description'] = trim(preg_replace('/\s+/', ' ', $descriptionText));
                }
            }
        }

        // location
        $xpathLocation = '//aside[@class="table-cell side uk-hidden-medium uk-hidden-small width-320"]/section/div/div/div[@class="uk-grid uk-margin-top-remove"]/div';
        $location = $page->query($xpathLocation);
        if (!empty($location) || !$location?->length) {
            $locationNode = $location->item(0);

            if (!empty($locationNode)) {
                $locationNodeFirstChild = $locationNode->firstChild;

                if (!empty($locationNodeFirstChild)) {
                    $locationNode = $locationNode->removeChild($locationNodeFirstChild);
                }

                $locationText = $locationNode->nodeValue;
                if (!empty($locationText)) {
                    $productData['location'] = trim(preg_replace('/\s+/', ' ', $locationText));
                }
            }
        }

        // price
        $xpathPrice = '//aside[@class="table-cell side uk-hidden-medium uk-hidden-small width-320"]/div/div/div/div/div/span';
        $price = $page->query($xpathPrice);
        if (!empty($price) || !$price?->length) {
            $priceNode = $price->item(0);

            if (!empty($priceNode)) {
                $priceText = $priceNode->nodeValue;

                if (!empty($priceText)) {
                    $priceText = str_replace('€', '', $priceText);
                    $productData['price'] = trim($priceText);
                }
            }
        }

        return $productData;
    }

    public function parseNextPageLink(string $content): ?string {
        $page = $this->convertStringHtmlPageToDomXPath($content);

        $nextPage = $page->query('//a[@class="js-pagination-next"]');
        if (empty($nextPage)) {
            return null;
        }

        $nextPageNode = $nextPage->item(0);
        if (empty($nextPageNode)) {
            return null;
        }

        $nextPageHrefAttribute = $nextPageNode->getAttribute('href');
        if (empty($nextPageHrefAttribute)) {
            return null;
        }

        return self::DEFAULT_HOST . $nextPageHrefAttribute;
    }

    private function processInfoSection(DOMNodeList $infoSection): array {
        $data = [];

        foreach ($infoSection as $info) {
            $propertyName = $info->getElementsByTagName('div')->item(0)->nodeValue;
            $propertyValue = $info->getElementsByTagName('div')->item(1)->nodeValue;
            if ($propertyName === null || $propertyValue === null) {
                continue;
            }

            $propertyName = trim(str_replace(':', '', $propertyName));

            $productPropertyName = $this->mapSitePropertyNameToProductPropertyName($propertyName);

            if($productPropertyName === null) {
                continue;
            }

            $data[$productPropertyName] = trim(preg_replace('/\s+/', ' ', $propertyValue));
        }

        return $data;
    }

    private function mapSitePropertyNameToProductPropertyName(string $siteProperty): ?string {
        $siteProperty = strtolower($siteProperty);

        switch ($siteProperty) {
            case 'godište':
                $productPropertyName = 'age';
                break;
            case 'marka':
                $productPropertyName = 'brand';
                break;
            case 'karoserija':
                $productPropertyName = 'carBodyType';
                break;
            case 'boja':
                $productPropertyName = 'color';
                break;
            case 'kubikaža':
                $productPropertyName = 'cubicCapacity';
                break;
            case 'broj vrata':
                $productPropertyName = 'doorType';
                break;
            case 'emisiona klasa motora':
                $productPropertyName = 'engineEmissionClass';
                break;
            case 'snaga motora':
                $productPropertyName = 'enginePower';
                break;
            case 'gorivo':
                $productPropertyName = 'fuelType';
                break;
            case 'kilometraža':
                $productPropertyName = 'mileage';
                break;
            case 'model':
                $productPropertyName = 'model';
                break;
            case 'broj sedišta':
                $productPropertyName = 'numberOfSeats';
                break;
            case 'stanje':
                $productPropertyName = 'state';
                break;
            case 'menjač':
                $productPropertyName = 'transmissionType';
                break;
            case 'strana volana':
                $productPropertyName = 'wheelSide';
                break;
            default:
                $productPropertyName = null;
        }

        return $productPropertyName;
    }
}