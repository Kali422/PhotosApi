<?php


namespace App\Repository\Instagram;


use App\Bridge\InstagramClient;

class InstagramService
{
    /**
     * @var InstagramFactory
     */
    private $factory;
    /**
     * @var InstagramClient
     */
    private $client;

    function __construct(InstagramFactory $factory, InstagramClient $client)
    {

        $this->factory = $factory;
        $this->client = $client;
    }

    function getPhotos($access_token)
    {
        $data = $this->client->getAllData($access_token);
        if ($data != [])
        {
            $photos = $this->factory->createArrayOfPhotos($data);
            return $photos;
        }
        else return false;

    }

    function getComments($access_token, $mediaId)
    {
        $commentsRaw = $this->client->getComments($access_token, $mediaId);
        if ($commentsRaw!=[])
        {
            $comments = $this->factory->createArrayOfComments($commentsRaw->data);
            return $comments;
        }
        else return [];
    }

    function getOnePhoto($access_token, $mediaId)
    {
        $photoRaw = $this->client->getOnePhoto($access_token, $mediaId);
        if ($photoRaw != []) {
            $photo = $this->factory->createPhotoInstance($photoRaw->data);
            return $photo;
        }
        else return false;
    }



}