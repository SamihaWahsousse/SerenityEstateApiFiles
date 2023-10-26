<?php

namespace App\Controller;

use App\Entity\MediaFile;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class MediaFileDeleteController extends AbstractController
{
    public function __invoke(Request $request, ManagerRegistry $doctrine): String
    {
        $entityManager = $doctrine->getManager();

        // Récupérer la propety type sélectionnée depuis la BD
        $propertyType = $entityManager->getRepository(MediaFile::class)->findOneBy(
            ['id' => 4]
        );
        dd($propertyType);

        return 'file deleted';
        /*
        dd($request);
        $uploadedFile = $request->files->get('file');
        if (!$uploadedFile) {
            throw new BadRequestHttpException('"file" is required');
        }

        $mediaFile = new MediaFile();
        $mediaFile->file = $uploadedFile;
        $mediaFile->set('');*/

        // return $mediaFile;
    }
}
