<?php


namespace App\Tests\Bridge;


use App\Bridge\InstagramClient;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Dotenv\Dotenv;

class InstagramClientTest extends TestCase
{
    private $igClient;

    function setUp()
    {
        $this->igClient = new InstagramClient();
        $dotenv = new Dotenv(true);
        $dotenv->load('/var/www/html/Photos/PhotosApi/.env.test');
        $dotenv->load('/var/www/html/Photos/PhotosApi/.env');
    }

    function testGetAllDataTrue()
    {
        $access_token = $_ENV['IG_ACCESS_TOKEN'];
        $data = $this->igClient->getAllData($access_token);
        self::assertIsArray($data->data);
    }

    function testGetAllDataFalse()
    {
        $data = $this->igClient->getAllData('123');
        self::assertIsString($data);
    }

    function testGetCommentsTrue()
    {
        $data = $this->igClient->getComments($_ENV['IG_ACCESS_TOKEN'], $_ENV['IG_MEDIA_ID']);
        self::assertIsArray($data->data);
    }

    function testGetCommentsInvalidToken()
    {
        $data = $this->igClient->getComments('123', $_ENV['IG_MEDIA_ID']);
        self::assertIsString($data);
    }

    function testGetCommentsInvalidMedia()
    {
        $data = $this->igClient->getComments($_ENV['IG_ACCESS_TOKEN'], '123');
        self::assertIsString($data);
    }

    function testGetCommentsInvalidBoth()
    {
        $data = $this->igClient->getComments('123', '456');
        self::assertIsString($data);
    }

    function testGetOnePhotoTrue()
    {
        $data = $this->igClient->getOnePhoto($_ENV['IG_ACCESS_TOKEN'], $_ENV['IG_MEDIA_ID']);
        self::assertInstanceOf(\stdClass::class, $data);
    }

    function testGetOnePhotoInvalidToken()
    {
        $data = $this->igClient->getOnePhoto('123', $_ENV['IG_MEDIA_ID']);
        self::assertIsString($data);
    }

    function testGetOntPhotoInvalidMedia()
    {
        $data = $this->igClient->getOnePhoto($_ENV['IG_ACCESS_TOKEN'], '123');
        self::assertIsString($data);
    }

    function testGetOnePhotoInvalidBoth()
    {
        $data = $this->igClient->getOnePhoto('123', '456');
        self::assertIsString($data);
    }


}