<?php

namespace App\Controller;

use App\Entity\MediaFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class MediaFileController extends AbstractController
{
    public function __invoke(Request $request): MediaFile
    {
        $uploadedFile = $request->files->get('file');
        if (!$uploadedFile) {
            throw new BadRequestHttpException('"file" is required');
        }

        $mediaFile = new MediaFile();
        $mediaFile->file = $uploadedFile;
        $mediaFile->setFileUrl('');

        return $mediaFile;
    }
}