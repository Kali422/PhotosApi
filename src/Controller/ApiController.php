<?php


namespace App\Controller;

use App\Bridge\GooglePhotosClient;
use App\Bridge\InstagramClient;
use App\Repository\GooglePhotos\GooglePhotosFactory;
use App\Repository\GooglePhotos\GooglePhotosService;
use App\Repository\Instagram\InstagramFactory;
use App\Repository\Instagram\InstagramService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class ApiController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/instagram")
     */
    public function getInstagramAllPhotos(Request $request): View
    {
        $service = new InstagramService(new InstagramFactory(), new InstagramClient());
        $token = $request->get('access_token');
        if (isset($token)) {
            $photos = $service->getPhotos($token);
            if (is_array($photos)) {
                return View::create($photos, Response::HTTP_OK);
            } else
                return View::create($photos, Response::HTTP_BAD_REQUEST);
        } else return View::create('Include access token', Response::HTTP_BAD_REQUEST);
    }


    /**
     * @Rest\Get("/instagram/{photoId}")
     */
    public function getInstagramPhoto(Request $request, $photoId): View
    {
        $service = new InstagramService(new InstagramFactory(), new InstagramClient());
        $token = $request->get('access_token');
        if (isset($token)) {
            $photo = $service->getOnePhoto($token, $photoId);
            if (false == is_string($photo)) {
                return View::create($photo, Response::HTTP_OK);
            } else
                return View::create($photo, Response::HTTP_BAD_REQUEST);
        } else return View::create('Include access token', Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Rest\Get("/instagram/{photoId}/comments")
     */
    public function getInstagramPhotoComments(Request $request, $photoId)
    {
        $service = new InstagramService(new InstagramFactory(), new InstagramClient());
        $token = $request->get('access_token');
        if (isset($token)) {
            $comments = $service->getComments($token, $photoId);
            if (is_array($comments)) {
                return View::create($comments, Response::HTTP_OK);
            } else
                return View::create($comments, Response::HTTP_BAD_REQUEST);
        } else return View::create('Include access token', Response::HTTP_BAD_REQUEST);
    }


    /**
     * @Rest\Get("/googlephotos/albums")
     */
    public function getGooglePhotosAlbums(Request $request): View
    {
        $service = new GooglePhotosService(new GooglePhotosClient(), new GooglePhotosFactory());
        $token = $request->get('access_token');
        if (isset($token)) {
            $albums = $service->getAlbums($token);
            if (is_array($albums)) {
                return View::create($albums, Response::HTTP_OK);
            } else
                return View::create($albums, Response::HTTP_BAD_REQUEST);
        } else return View::create('Include access token', Response::HTTP_BAD_REQUEST);

    }

    /**
     * @Rest\Get("/googlephotos/albums/{albumId}")
     */
    public function getGooglePhotosPhotosInAlbum(Request $request, $albumId): View
    {
        $service = new GooglePhotosService(new GooglePhotosClient(), new GooglePhotosFactory());
        $token = $request->get('access_token');
        if (isset($token)) {
            $photos = $service->getPhotos($token, $albumId);
            if (is_array($photos)) {
                return View::create($photos, Response::HTTP_OK);
            } else
                return View::create($photos, Response::HTTP_BAD_REQUEST);
        } else return View::create('Include access token', Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Rest\Get("/googlephotos/photos/{photoId}")
     */
    public function getGooglePhotosOnePhoto(Request $request, $photoId): View
    {
        $service = new GooglePhotosService(new GooglePhotosClient(), new GooglePhotosFactory());
        $token = $request->get('access_token');
        if (isset($token)) {
            $photo = $service->getOnePhoto($token, $photoId);
            if (false == is_string($photo)) {
                return View::create($photo, Response::HTTP_OK);
            } else
                return View::create($photo, Response::HTTP_BAD_REQUEST);
        } else return View::create('Include access token', Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Rest\Get("/googlephotos/photos")
     */
    public function getGooglePhotosAllPhotos(Request $request): View
    {
        $service = new GooglePhotosService(new GooglePhotosClient(), new GooglePhotosFactory());
        $token = $request->get('access_token');
        if (isset($token)) {
            $photos = $service->getAllPhotos($token);
            if (is_array($photos)) {
                return View::create($photos, Response::HTTP_OK);
            } else
                return View::create($photos, Response::HTTP_BAD_REQUEST);
        } else return View::create('Include access token', Response::HTTP_BAD_REQUEST);
    }


}