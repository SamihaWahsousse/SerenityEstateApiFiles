<?php

namespace App\Controller;

use App\Entity\MediaFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;


class MediaFileController extends AbstractController
{
    public function __invoke(Request $request): MediaFile
    {        
        // Check if file is set
        $uploadedFile = $request->files->get('file');        
        if (!$uploadedFile) {
            throw new BadRequestHttpException('"file" is required');
        }

        // Check if fileType in set and if it's equal to image or file
        $fileType = $request->request->get('fileType');
        if (!$fileType) {
            throw new BadRequestHttpException('"fileType" is required');
        } else if($fileType != 'image' && $fileType != 'file') {
            throw new BadRequestHttpException('Only image or file are accepted as fileType');
        }
        
        // check if the property id id set
        $idProperty = $request->request->get('idProperty');
        if (!$idProperty) {
            throw new BadRequestHttpException('"idProperty" is required');
        }

        // Create a new mediaFile object
        $mediaFile = new MediaFile();
        $mediaFile->setFile($uploadedFile);
        $mediaFile->setFileType($fileType);
        $mediaFile->setIdProperty($idProperty);
        $mediaFile->setUpdatedAt(new \DateTimeImmutable('now'));
        // The fileUrl attribute will be set through the normalizer

        return $mediaFile;
    }
}

