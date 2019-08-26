<?php


namespace App\Tests\Repository\Instagram;


use App\Bridge\InstagramClient;
use App\Entity\Photo;
use App\Repository\Instagram\InstagramFactory;
use App\Repository\Instagram\InstagramService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Dotenv\Dotenv;

class InstagramServiceTest extends TestCase
{
    private $service;

    function setUp()
    {
        $dotenv = new Dotenv(true);
        $dotenv->load('/var/www/html/Photos/PhotosApi/.env');
        $dotenv->load('/var/www/html/Photos/PhotosApi/.env.test');
        $this->service = new InstagramService(new InstagramFactory(), new InstagramClient());
    }

    function testGetPhotosTrue()
    {
        $data = $this->service->getPhotos($_ENV['IG_ACCESS_TOKEN']);
        self::assertIsArray($data);
    }

    function testGetPhotosFalse()
    {
        $data = $this->service->getPhotos('123');
        self::assertIsString($data);
    }

    function testGetCommentsTrue()
    {
        $data = $this->service->getComments($_ENV['IG_ACCESS_TOKEN'], $_ENV['IG_MEDIA_ID']);
        self::assertIsArray($data);
    }

    function testGetCommentsInvalidToken()
    {
        $data = $this->service->getComments('123', $_ENV['IG_MEDIA_ID']);
        self::assertIsString($data);
    }

    function testGetCommentsInvalidMedia()
    {
        $data = $this->service->getComments($_ENV['IG_ACCESS_TOKEN'], '123');
        self::assertIsString($data);
    }

    function testGetCommentsInvalidBoth()
    {
        $data = $this->service->getComments('123', '123');
        self::assertIsString($data);
    }

    function testGetOnePhotoTrue()
    {
        $data = $this->service->getOnePhoto($_ENV['IG_ACCESS_TOKEN'], $_ENV['IG_MEDIA_ID']);
        self::assertInstanceOf(Photo::class, $data);
    }

    function testGetOnePhotoInvalidToken()
    {
        $data = $this->service->getOnePhoto('123', $_ENV['IG_MEDIA_ID']);
        self::assertIsString($data);
    }

    function testGetOnePhotoInvalidMedia()
    {
        $data = $this->service->getOnePhoto($_ENV['IG_ACCESS_TOKEN'], '123');
        self::assertIsString($data);
    }

    function testGetOnePhotoInvalidBoth()
    {
        $data = $this->service->getOnePhoto('123', '123');
        self::assertIsString($data);
    }

}