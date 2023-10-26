<?php

use App\Entity\MediaFile;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class MediaFileEventSubscriber
{

    public function postRemove(MediaFile $image, LifecycleEventArgs $event)
    {
        dd($image->getFilePath());

        $image_path = $image->getFilePath(); // You may have to specify the full path to the file if it is not listed in the database.

        if (file_exists($image_path)) {
            unlink($image_path);
        }
    }
}
