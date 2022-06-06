<?php

abstract class WebParser {
    public abstract function parseListing(string $content): array;

    public abstract function parseSinglePage(string $content): array;

    public abstract function parseNextPageLink(string $content): ?string;

    protected function convertStringHtmlPageToDomXPath(string $content): DOMXPath {
        $dom = new DOMDocument();
        $dom->loadHTML($content);

        return new DOMXPath($dom);
    }
}
