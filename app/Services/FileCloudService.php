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

    public function storeFile(array $data, string $path)
    {
        try {
            $response = $this->httpClient->request('POST', env('URL_API_FILES') . '/api/upload/image', [
                'multipart' => [
                    $data,
                    [
                        'name' => 'path',
                        'contents' => $path
                    ]
                ]
            ]);
            $res = json_decode($response->getBody()->getContents());
            return $res->image;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function destroyFile($path) {
        try {
            $this->httpClient->request('DELETE', env('URL_API_FILES') . '/api/upload/image?path' . $path);
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
