<?php

namespace App\Services;

use Exception;
use GuzzleHttp\Client;

class FileCloudService
{
    protected $httpClient;

    public function __construct()
    {
        $this->httpClient = new Client();
    }

    public function storeFile(array $data, string $path, $endpoint = 'image')
    {
        try {
            $response = $this->httpClient->request('POST', env('URL_API_FILES') . '/api/upload/' . $endpoint, [
                'multipart' => [
                    $data,
                    [
                        'name' => 'path',
                        'contents' => $path
                    ]
                ]
            ]);
            $res = json_decode($response->getBody()->getContents());

            if (!$res?->$endpoint) {
                return $res;
            }

            return $res->$endpoint;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function destroyFile($path, $endpoint = 'image')
    {
        try {
            $this->httpClient->request('DELETE', env('URL_API_FILES') . '/api/upload/' . $endpoint . '?path' . $path);
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
