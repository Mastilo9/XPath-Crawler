<?php

class PolovniAutomobiliWebParser extends WebParser {
    /**
     * Parse listing page and return array of data collected from listing page.
     *
     * @param string $content
     * @param string|null $uri
     *
     * @return array Array of parsed data.
     */
    public function parseListing(string $content, string $uri = null): array {

    }

    /**
     * Parse product page and return data about one or more products.
     *
     * @param string $content
     * @param string|null $uri
     *
     * @return array Array of parsed data.
     */
    public function parseProductPage(string $content, string $uri = null): array {

    }

    /**
     * Parse given content and get URL to the next page as string, or null if next page URL is not found.
     *
     * @param string $content
     * @param string|null $uri
     *
     * @return string|null String representing URL of next page.
     */
    public function parseNextPageLink(string $content, string $uri = null): ?string {

    }
}