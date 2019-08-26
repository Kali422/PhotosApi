<?php


namespace App\Tests\Bridge;


use App\Bridge\GooglePhotosClient;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Dotenv\Dotenv;

class GooglePhotosClientTest extends TestCase
{
    private $client;

    function setUp()
    {
        $dotenv = new Dotenv(true);
        $dotenv->load('/var/www/html/Photos/PhotosApi/.env');
        $dotenv->load('/var/www/html/Photos/PhotosApi/.env.test');
        $this->client = new GooglePhotosClient();
    }

    function testGetAlbumsTrue()
    {
        $albums = $this->client->getAlbums($_ENV['GP_ACCESS_TOKEN']);
        self::assertIsArray($albums->albums);
    }

    function testGetAlbumsFalse()
    {
        $error = $this->client->getAlbums($_ENV['GP_ACCESS_TOKEN'] . '123');
        self::assertIsString($error);
    }

    function testGetPhotosFromAlbumTrue()
    {
        $data = $this->client->getPhotosFromAlbum($_ENV['GP_ACCESS_TOKEN'], $_ENV['GP_ALBUM_ID']);
        self::assertIsArray($data);
    }

    function testGetPhotosFromAlbumInvalidToken()
    {
        $data = $this->client->getPhotosFromAlbum('123', $_ENV['GP_ALBUM_ID']);
        self::assertIsString($data);
    }

    function testGetPhotosFromAlbumInvalidId()
    {
        $data = $this->client->getPhotosFromAlbum($_ENV['GP_ACCESS_TOKEN'], '123');
        self::assertIsString($data);
    }

    function testGetPhotosFromAlbumInvalidBoth()
    {
        $data = $this->client->getPhotosFromAlbum('123', '123');
        self::assertIsString($data);
    }

    function testGetOnePhotoTrue()
    {
        $data = $this->client->getOnePhoto($_ENV['GP_ACCESS_TOKEN'], $_ENV['GP_MEDIA_ID']);
        self::assertInstanceOf(\stdClass::class, $data);
    }

    function testGetOnePhotoInvalidToken()
    {
        $data = $this->client->getOnePhoto('123', $_ENV['GP_MEDIA_ID']);
        self::assertIsString($data);
    }

    function testGetOnePhotoInvalidID()
    {
        $data = $this->client->getOnePhoto($_ENV['GP_ACCESS_TOKEN'], '123');
        self::assertIsString($data);
    }

    function testGetOnePhotoInvalidBoth()
    {
        $data = $this->client->getOnePhoto('123', '123');
        self::assertIsString($data);
    }

}