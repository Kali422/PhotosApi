<?php


namespace App\Repository\GooglePhotos;


use App\Bridge\GooglePhotosClient;

class GooglePhotosService
{

    /**
     * @var GooglePhotosClient
     */
    private $client;
    /**
     * @var GooglePhotosFactory
     */
    private $factory;

    function __construct(GooglePhotosClient $client, GooglePhotosFactory $factory)
    {
        $this->client = $client;
        $this->factory = $factory;
    }

    function getAlbums($access_token)
    {
        $albumsJson = $this->client->getAlbums($access_token);
        if ($albumsJson != []){
            return $this->factory->createAlbums($albumsJson->albums);
        }
        else return false;
    }

    function getPhotos($access_token,$albumId)
    {
        $photosJson = $this->client->getPhotosFromAlbum($access_token,$albumId);
        if ($photosJson!=[]) {
            return $this->factory->createArrayOfPhotos($photosJson);
        }
        else return [];

    }

    function getAllPhotos($access_token)
    {
        $photosJson = $this->client->getAllPhotos($access_token);
        if ($photosJson!=[]) {
            return $this->factory->createArrayOfPhotos($photosJson);
        }
        else return false;
    }

    function getOnePhoto($access_token, $mediaId)
    {
        $photoJson = $this->client->getOnePhoto($access_token, $mediaId);
        if ($photoJson!=[]) {
            return $this->factory->createPhoto($photoJson);
        }
        else return false;
    }

}