<?php


namespace app\resources;


class Request
{

    public static function fetch(string $method, string $url, array $body = [], array $headers = []) : string
    {
        $context = stream_context_create([
            'http' => [
                'method' => $method,
                'header' => implode('\r\n', $headers),
                'content' => http_build_query($body),
                'ignore_errors' => true,
            ]
        ]);

        return file_get_contents($url, false, $context);
    }
}