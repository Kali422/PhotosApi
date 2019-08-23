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
        $dotenv = new Dotenv();
        $dotenv->load('/var/www/html/Photos/PhotosApi/.env.test');
        $dotenv->load('/var/www/html/Photos/PhotosApi/.env');
    }

    function testGetAllDataTrue()
    {
        $access_token = $_ENV['IG_ACCESS_TOKEN'];
        $data = $this->igClient->getAllData($access_token);
        self::assertArrayHasKey();
    }

    function testGetAllDataFalse()
    {
        $data = $this->igClient->getAllData('123');
    }

}