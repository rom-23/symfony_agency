<?php

namespace App\Listener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
use App\Entity\Property;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageCacheSubscriber implements EventSubscriber
{
    private $cacheManager;

    private $uploaderHelper;

    public function __construct( CacheManager $cacheManager, UploaderHelper $uploaderHelper )
    {
        $this -> cacheManager = $cacheManager;
        $this -> uploaderHelper = $uploaderHelper;
    }

    public function getSubscribedEvents()
    {
        return array('preUpdate', 'preRemove');
    }

    public function preRemove( LifecycleEventArgs $args )
    {
        $entity = $args -> getEntity();
        if(!$entity instanceof Property) {
            return;
        }
        $this -> cacheManager -> remove( $this -> uploaderHelper -> asset( $entity, 'imageFile' ) );
    }

    public function preUpdate( PreUpdateEventArgs $args )
    {
        $entity = $args -> getEntity();
        if(!$entity instanceof Property) {
            return;
        }
        if($entity -> getImageFile() instanceof UploadedFile) {
            $this -> cacheManager -> remove( $this -> uploaderHelper -> asset( $entity, 'imageFile' ) );
        }
    }
}
