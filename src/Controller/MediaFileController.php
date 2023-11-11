<?php

namespace App\Controller;

use App\Entity\MediaFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\String\Slugger\SluggerInterface;


class MediaFileController extends AbstractController
{

    public function __invoke(Request $request, SluggerInterface $slugger): MediaFile
    {
        $uploadedFile = $request->files->get('file');
        if (!$uploadedFile) {
            throw new BadRequestHttpException('"file" is required');
        }
        $fileType = $request->request->get('fileType');
        if (!$fileType) {
            throw new BadRequestHttpException('"fileType" is required');
        }
        $idProperty = $request->request->get('idProperty');
        if (!$idProperty) {
            throw new BadRequestHttpException('"idProperty" is required');
        }

        $mediaFile = new MediaFile();
        $mediaFile->file = $uploadedFile;
        $mediaFile->setFileType($fileType);
        $mediaFile->setIdProperty($idProperty);
        $mediaFile->setUpdatedAt(new \DateTimeImmutable('now'));

        return $mediaFile;
    }
}
