<?php


namespace App\Bridge;


use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class GooglePhotosClient
{
    private $httpClient;

    function __construct()
    {
        $this->httpClient = HttpClient::create();
    }

    function getAlbums($access_token)
    {
        $url = $_ENV['GP_ALBUMS_URL'] . "?access_token=" . $access_token;
        try {
            return json_decode($this->httpClient->request("GET", $url)->getContent());
        } catch (ClientExceptionInterface | RedirectionExceptionInterface | ServerExceptionInterface | TransportExceptionInterface $e) {
            return $e->getMessage();
        }
    }

    function getPhotosFromAlbum($access_token, $albumId, $page_token = null)
    {
        $dataAll = [];
        do {
            $url = $_ENV['GP_MEDIA_URL'] . ":search?access_token=" . $access_token;
            try {
                $dataRaw = $this->httpClient->request("POST", $url, [
                    'body' => [
                        'albumId' => $albumId,
                        'pageSize' => 100,
                        'pageToken' => $page_token
                    ]
                ])->getContent();
            }
            catch (ClientExceptionInterface | RedirectionExceptionInterface | ServerExceptionInterface | TransportExceptionInterface $e)
            {
                return $e->getMessage();
            }
            $data = json_decode($dataRaw);
            if (isset($data->mediaItems)) {
                $dataAll = array_merge($dataAll, $data->mediaItems);
            }
            if (isset($data->nextPageToken)) {
                $page_token = $data->nextPageToken;
            } else $page_token = null;
        } while ($page_token != null);

        return $dataAll;
    }

    function getAllPhotos($access_token, $page_token = null)
    {
        $dataAll = [];
        do {
            $url = $_ENV['GP_MEDIA_URL'] . "?access_token=" . $access_token . "&pageToken=" . $page_token . "&pageSize=100";
            try {
                $dataRaw = $this->httpClient->request("GET", $url)->getContent();
            }
            catch (ClientExceptionInterface | RedirectionExceptionInterface | ServerExceptionInterface | TransportExceptionInterface $e)
            {
                return $e->getMessage();
            }
            $data = json_decode($dataRaw);
            if (isset($data->mediaItems)) {
                $dataAll = array_merge($dataAll, $data->mediaItems);
            }
            if (isset($data->nextPageToken)) {
                $page_token = $data->nextPageToken;
            } else $page_token = null;
        } while ($page_token != null);

        return $dataAll;
    }

    public function getOnePhoto($access_token, $id)
    {
        $url = $_ENV['GP_MEDIA_URL'] . "/" . $id . "?access_token=" . $access_token;
        try {
            return json_decode($this->httpClient->request("GET", $url)->getContent());
        } catch (ClientExceptionInterface | RedirectionExceptionInterface | ServerExceptionInterface | TransportExceptionInterface $e) {
            return $e->getMessage();
        }
    }
}