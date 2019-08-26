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
        if (isset($data->data))
        {
            $photos = $this->factory->createArrayOfPhotos($data);
            return $photos;
        }
        else return $data;

    }

    function getComments($access_token, $mediaId)
    {
        $commentsRaw = $this->client->getComments($access_token, $mediaId);
        if (isset($commentsRaw->data))
        {
            $comments = $this->factory->createArrayOfComments($commentsRaw->data);
            return $comments;
        }
        else return $commentsRaw;
    }

    function getOnePhoto($access_token, $mediaId)
    {
        $photoRaw = $this->client->getOnePhoto($access_token, $mediaId);
        if (isset($photoRaw->data)) {
            $photo = $this->factory->createPhotoInstance($photoRaw->data);
            return $photo;
        }
        else return $photoRaw;
    }



}