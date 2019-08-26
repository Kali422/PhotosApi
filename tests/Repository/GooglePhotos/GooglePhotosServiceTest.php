<?php


namespace App\Tests\Repository\GooglePhotos;


use App\Bridge\GooglePhotosClient;
use App\Entity\Photo;
use App\Repository\GooglePhotos\GooglePhotosFactory;
use App\Repository\GooglePhotos\GooglePhotosService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Dotenv\Dotenv;

class GooglePhotosServiceTest extends TestCase
{
    private $service;

    function setUp()
    {
        $dotenv = new Dotenv(true);
        $dotenv->load('/var/www/html/Photos/PhotosApi/.env');
        $dotenv->load('/var/www/html/Photos/PhotosApi/.env.test');
        $this->service = new GooglePhotosService(new GooglePhotosClient(), new GooglePhotosFactory());
    }

    function testGetAlbumsTrue()
    {
        $data = $this->service->getAlbums($_ENV['GP_ACCESS_TOKEN']);
        self::assertIsArray($data);
    }

    function testGetAlbumsFalse()
    {
        $data = $this->service->getAlbums($_ENV['GP_ACCESS_TOKEN'] . '123');
        self::assertIsString($data);
    }

    function testGetPhotosTrue()
    {
        $data = $this->service->getPhotos($_ENV['GP_ACCESS_TOKEN'], $_ENV['GP_ALBUM_ID']);
        self::assertIsArray($data);
    }

    function testGetPhotosInvalidToken()
    {
        $data = $this->service->getPhotos('123', $_ENV['GP_ALBUM_ID']);
        self::assertIsString($data);
    }

    function testGetPhotosInvalidMedia()
    {
        $data = $this->service->getPhotos($_ENV['GP_ACCESS_TOKEN'], '123');
        self::assertIsString($data);
    }

    function testGetPhotosInvalidBoth()
    {
        $data = $this->service->getPhotos('123', '123');
        self::assertIsString($data);
    }

    function testGetAllPhotosTrue()
    {
        $data = $this->service->getAllPhotos($_ENV['GP_ACCESS_TOKEN']);
        self::assertIsArray($data);
    }

    function testGetAllPhotosFalse()
    {
        $data = $this->service->getAllPhotos($_ENV['GP_ACCESS_TOKEN'] . '123');
        self::assertIsString($data);
    }

    function testGetOnePhotoTrue()
    {
        $data = $this->service->getOnePhoto($_ENV['GP_ACCESS_TOKEN'], $_ENV['GP_MEDIA_ID']);
        self::assertInstanceOf(Photo::class, $data);
    }

    function testGetOnePhotoInvalidToken()
    {
        $data = $this->service->getOnePhoto('123', $_ENV['GP_MEDIA_ID']);
        self::assertIsString($data);
    }

    function testGetOnePhotoInvalidMediaID()
    {
        $data = $this->service->getOnePhoto($_ENV['GP_ACCESS_TOKEN'], '123');
        self::assertIsString($data);
    }

    function testGetOnePhotoInvalidBoth()
    {
        $data = $this->service->getOnePhoto('123', '123');
        self::assertIsString($data);
    }
}