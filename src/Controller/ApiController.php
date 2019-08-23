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
        $errorMessage = '';
        if (isset($token)) {
            $photos = $service->getPhotos($token);
            if ($photos != false) {
                return View::create($photos, Response::HTTP_OK);
            } else $errorMessage = 'Something is wrong';
        } else $errorMessage = 'Include access token';
        return View::create($errorMessage, Response::HTTP_BAD_REQUEST);
    }


    /**
     * @Rest\Get("/instagram/{photoId}")
     */
    public function getInstagramPhoto(Request $request, $photoId): View
    {
        $service = new InstagramService(new InstagramFactory(), new InstagramClient());
        $token = $request->get('access_token');
        $errorMessage = '';
        if (isset($token)) {
            $photo = $service->getOnePhoto($token, $photoId);
            if ($photo != false) {
                return View::create($photo, Response::HTTP_OK);
            } else $errorMessage = 'Something is wrong';
        } else $errorMessage = 'Include access token';
        return View::create($errorMessage, Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Rest\Get("/instagram/{photoId}/comments")
     */
    public function getInstagramPhotoComments(Request $request, $photoId)
    {
        $service = new InstagramService(new InstagramFactory(), new InstagramClient());
        $token = $request->get('access_token');
        $errorMessage = '';
        if (isset($token)) {
            $comments = $service->getComments($token, $photoId);
            return View::create($comments, Response::HTTP_OK);
        } else $errorMessage = 'Include access token';
        return View::create($errorMessage, Response::HTTP_BAD_REQUEST);
    }


    /**
     * @Rest\Get("/googlephotos/albums")
     */
    public function getGooglePhotosAlbums(Request $request): View
    {
        $service = new GooglePhotosService(new GooglePhotosClient(), new GooglePhotosFactory());
        $token = $request->get('access_token');
        $errorMessage = '';
        if (isset($token)) {
            $albums = $service->getAlbums($token);
            if ($albums != false) {
                return View::create($albums, Response::HTTP_OK);
            } else $errorMessage = 'Something is wrong';
        } else $errorMessage = 'Include access token';
        return View::create($errorMessage, Response::HTTP_BAD_REQUEST);

    }

    /**
     * @Rest\Get("/googlephotos/albums/{albumId}")
     */
    public function getGooglePhotosPhotosInAlbum(Request $request, $albumId): View
    {
        $service = new GooglePhotosService(new GooglePhotosClient(), new GooglePhotosFactory());
        $token = $request->get('access_token');
        $errorMessage = '';
        if (isset($token)) {
            $photos = $service->getPhotos($token, $albumId);
            return View::create($photos, Response::HTTP_OK);
        } else $errorMessage = 'Include access token';
        return View::create($errorMessage, Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Rest\Get("/googlephotos/photos/{photoId}")
     */
    public function getGooglePhotosOnePhoto(Request $request, $photoId): View
    {
        $service = new GooglePhotosService(new GooglePhotosClient(), new GooglePhotosFactory());
        $token = $request->get('access_token');
        $errorMessage = '';
        if (isset($token)) {
            $photo = $service->getOnePhoto($token, $photoId);
            if ($photo != false) {
                return View::create($photo, Response::HTTP_OK);
            } else $errorMessage = 'Something is wrong';
        } else $errorMessage = 'Include access token';
        return View::create($errorMessage, Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Rest\Get("/googlephotos/photos")
     */
    public function getGooglePhotosAllPhotos(Request $request): View
    {
        $service = new GooglePhotosService(new GooglePhotosClient(), new GooglePhotosFactory());
        $token = $request->get('access_token');
        $errorMessage = '';
        if (isset($token)) {
            $photos = $service->getAllPhotos($token);
            if ($photos != false) {
                return View::create($photos, Response::HTTP_OK);
            } else $errorMessage = 'Something is wrong';
        } else $errorMessage = 'Include access token';
        return View::create($errorMessage, Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Rest\Get("/all")
     */
    public function getAllPhotos(Request $request): View
    {
        $GP_service = new GooglePhotosService(new GooglePhotosClient(), new GooglePhotosFactory());
        $IG_service = new InstagramService(new InstagramFactory(), new InstagramClient());
        $igToken = $request->get('ig_access_token');
        $gpToken = $request->get('gp_access_token');
        $GP_photos = [];
        $IG_photos = [];
        if (isset($gpToken)) {
            $photos = $GP_service->getAllPhotos($gpToken);
            if ($photos != false) {
                return View::create($photos, Response::HTTP_OK);
            } else $errorMessage = 'Something is wrong';
        }
        if (isset($igToken)) {
            $photos = $IG_service->getPhotos($igToken);
            if ($photos != false) {
                return View::create($photos, Response::HTTP_OK);
            } else $errorMessage = 'Something is wrong';
        }

        return View::create(array_merge($IG_photos, $GP_photos), Response::HTTP_OK);
    }


}