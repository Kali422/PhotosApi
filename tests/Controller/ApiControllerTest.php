<?php


namespace App\Tests\Controller;


use App\Controller\ApiController;
use FOS\RestBundle\View\View;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;

class ApiControllerTest extends TestCase
{

    private $controller;

    function setUp()
    {
        $dotenv = new Dotenv(true);
        $dotenv->load('/var/www/html/Photos/PhotosApi/.env');
        $dotenv->load('/var/www/html/Photos/PhotosApi/.env.test');
        $this->controller = new ApiController();
    }

    function testGetInstagramAllPhotosTrue()
    {
        $request = new Request(['access_token' => $_ENV['IG_ACCESS_TOKEN']]);
        $response = $this->controller->getInstagramAllPhotos($request);
        self::assertInstanceOf(View::class, $response);
        self::assertEquals(200, $response->getStatusCode());
    }

    function testGetInstagramAllPhotosInvalidToken()
    {
        $request = new Request(['access_token' => '123']);
        $response = $this->controller->getInstagramAllPhotos($request);
        self::assertInstanceOf(View::class, $response);
        self::assertEquals(400, $response->getStatusCode());
    }

    function testGetInstagramAllPhotosNoToken()
    {
        $request = new Request();
        $response = $this->controller->getInstagramAllPhotos($request);
        self::assertInstanceOf(View::class, $response);
        self::assertEquals(400, $response->getStatusCode());
    }

    function testGetInstagramPhotoTrue()
    {
        $request = new Request(['access_token' => $_ENV['IG_ACCESS_TOKEN']]);
        $response = $this->controller->getInstagramPhoto($request, $_ENV['IG_MEDIA_ID']);
        self::assertInstanceOf(View::class, $response);
        self::assertEquals(200, $response->getStatusCode());
    }

    function testGetInstagramPhotoInvalidToken()
    {
        $request = new Request(['access_token' => '123']);
        $response = $this->controller->getInstagramPhoto($request, $_ENV['IG_MEDIA_ID']);
        self::assertInstanceOf(View::class, $response);
        self::assertEquals(400, $response->getStatusCode());
    }

    function testGetInstagramPhotoInvalidMedia()
    {
        $request = new Request(['access_token' => $_ENV['IG_ACCESS_TOKEN']]);
        $response = $this->controller->getInstagramPhoto($request, '123');
        self::assertInstanceOf(View::class, $response);
        self::assertEquals(400, $response->getStatusCode());
    }

    function testGetInstagramPhotoInvalidBoth()
    {
        $request = new Request(['access_token' => '123']);
        $response = $this->controller->getInstagramPhoto($request, '123');
        self::assertInstanceOf(View::class, $response);
        self::assertEquals(400, $response->getStatusCode());
    }

    function testGetInstagramPhotoNoToken()
    {
        $request = new Request();
        $response = $this->controller->getInstagramPhoto($request, $_ENV['IG_MEDIA_ID']);
        self::assertInstanceOf(View::class, $response);
        self::assertEquals(400, $response->getStatusCode());
    }

    function testGetInstagramPhotoCommentsTrue()
    {
        $request = new Request(['access_token' => $_ENV['IG_ACCESS_TOKEN']]);
        $response = $this->controller->getInstagramPhotoComments($request, $_ENV['IG_MEDIA_ID']);
        self::assertInstanceOf(View::class, $response);
        self::assertEquals(200, $response->getStatusCode());
    }

    function testGetInstagramPhotoCommentsInvalidToken()
    {
        $request = new Request(['access_token' => '123']);
        $response = $this->controller->getInstagramPhotoComments($request, $_ENV['IG_MEDIA_ID']);
        self::assertInstanceOf(View::class, $response);
        self::assertEquals(400, $response->getStatusCode());
    }

    function testGetInstagramPhotoCommentsInvalidMedia()
    {
        $request = new Request(['access_token' => $_ENV['IG_ACCESS_TOKEN']]);
        $response = $this->controller->getInstagramPhotoComments($request, '123');
        self::assertInstanceOf(View::class, $response);
        self::assertEquals(400, $response->getStatusCode());
    }

    function testGetInstagramPhotoCommentsInvalidBoth()
    {
        $request = new Request(['access_token' => '123']);
        $response = $this->controller->getInstagramPhotoComments($request, '123');
        self::assertInstanceOf(View::class, $response);
        self::assertEquals(400, $response->getStatusCode());
    }

    function testGetInstagramPhotoCommentsNoToken()
    {
        $request = new Request();
        $response = $this->controller->getInstagramPhotoComments($request, $_ENV['IG_MEDIA_ID']);
        self::assertInstanceOf(View::class, $response);
        self::assertEquals(400, $response->getStatusCode());
    }

    function testGetGooglePhotosAlbumsTrue()
    {
        $request = new Request(['access_token' => $_ENV['GP_ACCESS_TOKEN']]);
        $response = $this->controller->getGooglePhotosAlbums($request);
        self::assertInstanceOf(View::class, $response);
        self::assertEquals(200, $response->getStatusCode());
    }

    function testGetGooglePhotosAlbumsInvalidToken()
    {
        $request = new Request(['access_token' => '123']);
        $response = $this->controller->getGooglePhotosAlbums($request);
        self::assertInstanceOf(View::class, $response);
        self::assertEquals(400, $response->getStatusCode());
    }

    function testGetGooglePhotosAlbumsNoToken()
    {
        $request = new Request();
        $response = $this->controller->getGooglePhotosAlbums($request);
        self::assertInstanceOf(View::class, $response);
        self::assertEquals(400, $response->getStatusCode());
    }


    function testGetGooglePhotosPhotosInAlbumTrue()
    {
        $request = new Request(['access_token' => $_ENV['GP_ACCESS_TOKEN']]);
        $response = $this->controller->getGooglePhotosPhotosInAlbum($request, $_ENV['GP_ALBUM_ID']);
        self::assertInstanceOf(View::class, $response);
        self::assertEquals(200, $response->getStatusCode());
    }

    function testGetGooglePhotosPhotosInAlbumInvalidToken()
    {
        $request = new Request(['access_token' => '123']);
        $response = $this->controller->getGooglePhotosPhotosInAlbum($request, $_ENV['GP_MEDIA_ID']);
        self::assertInstanceOf(View::class, $response);
        self::assertEquals(400, $response->getStatusCode());
    }

    function testGetGooglePhotosPhotosInAlbumInvalidMedia()
    {
        $request = new Request(['access_token' => $_ENV['GP_ACCESS_TOKEN']]);
        $response = $this->controller->getGooglePhotosPhotosInAlbum($request, '123');
        self::assertInstanceOf(View::class, $response);
        self::assertEquals(400, $response->getStatusCode());
    }

    function testGetGooglePhotosPhotosInAlbumInvalidBoth()
    {
        $request = new Request(['access_token' => '123']);
        $response = $this->controller->getGooglePhotosPhotosInAlbum($request, '123');
        self::assertInstanceOf(View::class, $response);
        self::assertEquals(400, $response->getStatusCode());
    }

    function testGetGooglePhotosPhotosInAlbumNoToken()
    {
        $request = new Request();
        $response = $this->controller->getGooglePhotosPhotosInAlbum($request, $_ENV['GP_ALBUM_ID']);
        self::assertInstanceOf(View::class, $response);
        self::assertEquals(400, $response->getStatusCode());
    }


    function testGetGooglePhotosOnePhotoTrue()
    {
        $request = new Request(['access_token' => $_ENV['GP_ACCESS_TOKEN']]);
        $response = $this->controller->getGooglePhotosOnePhoto($request, $_ENV['GP_MEDIA_ID']);
        self::assertInstanceOf(View::class, $response);
        self::assertEquals(200, $response->getStatusCode());
    }

    function testGetGooglePhotosOnePhotoInvalidToken()
    {
        $request = new Request(['access_token' => '123']);
        $response = $this->controller->getGooglePhotosOnePhoto($request, $_ENV['GP_MEDIA_ID']);
        self::assertInstanceOf(View::class, $response);
        self::assertEquals(400, $response->getStatusCode());
    }

    function testGetGooglePhotosOnePhotoInvalidMedia()
    {
        $request = new Request(['access_token' => $_ENV['GP_ACCESS_TOKEN']]);
        $response = $this->controller->getGooglePhotosOnePhoto($request, '123');
        self::assertInstanceOf(View::class, $response);
        self::assertEquals(400, $response->getStatusCode());
    }

    function testGetGooglePhotosOnePhotoInvalidBoth()
    {
        $request = new Request(['access_token' => '123']);
        $response = $this->controller->getGooglePhotosOnePhoto($request, '123');
        self::assertInstanceOf(View::class, $response);
        self::assertEquals(400, $response->getStatusCode());
    }

    function testGetGooglePhotosOnePhotoNoToken()
    {
        $request = new Request();
        $response = $this->controller->getGooglePhotosOnePhoto($request, $_ENV['GP_MEDIA_ID']);
        self::assertInstanceOf(View::class, $response);
        self::assertEquals(400, $response->getStatusCode());
    }

    function testGetGooglePhotosAllPhotosTrue()
    {
        $request = new Request(['access_token' => $_ENV['GP_ACCESS_TOKEN']]);
        $response = $this->controller->getGooglePhotosAllPhotos($request);
        self::assertInstanceOf(View::class, $response);
        self::assertEquals(200, $response->getStatusCode());
    }

    function testGetGooglePhotosAllPhotosInvalidToken()
    {
        $request = new Request(['access_token' => '123']);
        $response = $this->controller->getGooglePhotosAllPhotos($request);
        self::assertInstanceOf(View::class, $response);
        self::assertEquals(400, $response->getStatusCode());
    }

    function testGetGooglePhotosAllPhotosNoToken()
    {
        $request = new Request();
        $response = $this->controller->getGooglePhotosAllPhotos($request);
        self::assertInstanceOf(View::class, $response);
        self::assertEquals(400, $response->getStatusCode());
    }
}