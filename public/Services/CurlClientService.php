<?php

class CurlClientService {
    private array $proxyList = [
        '',
    ];

    public function getNextProxy(): string {
        return $this->proxyList[array_rand($this->proxyList)];
    }

    public function request(string $url, bool $useProxy = false): string {
        $max_try_count = 10;

        do {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);

            if ($useProxy) {
                $nextProxy = $this->getNextProxy();
                curl_setopt($ch, CURLOPT_PROXY, $nextProxy);
            }

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);

            $result =   curl_exec($ch);
            curl_close($ch);

            if ($result) {
                return $result;
            }
        } while ($max_try_count--);

        return '';
    }
}
