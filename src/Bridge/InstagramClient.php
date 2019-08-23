<?php


namespace App\Bridge;


use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;


class InstagramClient
{
    private $httpClient;

    function __construct()
    {
        $this->httpClient = HttpClient::create();
    }

    function getAllData($access_token)
    {
        $url = $_ENV['IG_MEDIA_URL'] . "?access_token=" . $access_token;
        try {
            return json_decode($this->httpClient->request("GET", $url)->getContent());
        } catch (ClientExceptionInterface | RedirectionExceptionInterface | ServerExceptionInterface | TransportExceptionInterface $e) {
            return [];
        }
    }

    function getComments($access_token, $mediaId)
    {
        $url = $_ENV['IG_ONE_MEDIA_URL'] . $mediaId . "/comments?access_token=" . $access_token;
        try {
            return json_decode($this->httpClient->request("GET", $url)->getContent());
        } catch (ClientExceptionInterface | RedirectionExceptionInterface | ServerExceptionInterface | TransportExceptionInterface $e) {
            return [];
        }
    }

    function getOnePhoto($access_token, $mediaId)
    {
        $url = $_ENV['IG_ONE_MEDIA_URL'] . $mediaId . "?access_token=" . $access_token;
        try {
            return json_decode($this->httpClient->request("GET", $url)->getContent());
        } catch (ClientExceptionInterface | RedirectionExceptionInterface | ServerExceptionInterface | TransportExceptionInterface $e) {
            return [];
        }
    }

}