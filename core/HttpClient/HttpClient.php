<?php

namespace Core\HttpClient;

class HttpClient
{
    private $baseUri;
    private $timeout;

    public function __construct(string $baseUri, int $timeout = 10)
    {
        $this->baseUri = rtrim($baseUri, '/');
        $this->timeout = $timeout;
    }

    /**
     * @param string $uri
     * @param array $headers
     * @return string
     */
    public function get(string $uri, array $headers = []): string
    {
        return $this->request('GET', $uri, [], $headers);
    }

    /**
     * @param string $uri
     * @param array $data
     * @param array $headers
     * @return string
     */
    public function post(string $uri, array $data = [], array $headers = []): string
    {
        return $this->request('POST', $uri, $data, $headers);
    }

    /**
     * @param string $uri
     * @param array $data
     * @param array $headers
     * @return string
     */
    public function put(string $uri, array $data = [], array $headers = []): string
    {
        return $this->request('PUT', $uri, $data, $headers);
    }

    /**
     * @param string $uri
     * @param array $data
     * @param array $headers
     * @return string
     */
    public function delete(string $uri, array $data = [], array $headers = []): string
    {
        return $this->request('DELETE', $uri, [], $headers);
    }

    /**
     * @param string $uri
     * @param array $data
     * @param array $headers
     * @return string
     */
    public function patch(string $uri, array $data = [], array $headers = []): string
    {
        return $this->request('PATCH', $uri, $data, $headers);
    }

    public function request(string $method, string $uri, array $data = [], array $headers = []): string
    {
        $url = $this->baseUri . '/' . ltrim($uri, '/');

        $options = [
            'http' => [
                'method'  => $method,
                'header'  => $this->buildHeaders($headers),
                'content' => http_build_query($data),
                'timeout' => $this->timeout,
            ],
        ];

        $context = stream_context_create($options);

        //json_encode(file_get_contents($url, false, $context), true);
        return file_get_contents($url, false, $context);
    }

    private function buildHeaders(array $headers): string
    {
        $headerStrings = [];
        foreach ($headers as $name => $value) {
            $headerStrings[] = "{$name}: {$value}";
        }
        return implode("\r\n", $headerStrings);
    }
}