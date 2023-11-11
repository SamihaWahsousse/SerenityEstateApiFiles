<?php
namespace App\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

class MediaFileEventSubscriber implements EventSubscriber
{

    public function getSubscribedEvents()
    {
        return [
            Events::postRemove,
        ];
    }

    public function postRemove(LifecycleEventArgs $args)
    {        
        $entity = $args->getObject();
        $image_path = $entity->getFileUrl();

        if (file_exists($image_path)) {
            unlink($image_path);
        }
    }
}