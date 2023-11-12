<?php
// src/Serializer/MediaFileNormalizer.php
namespace App\Serializer;

use App\Entity\MediaFile;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Vich\UploaderBundle\Storage\StorageInterface;

final class MediaFileNormalizer implements NormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;
    private const ALREADY_CALLED = false;
    public function __construct(
        private StorageInterface $storage,
        private UrlGeneratorInterface $router,
    ) {
    }

    public function normalize($object, ?string $format = null, array $context = []): array|string|int|float|bool|\ArrayObject|null
    {
        // set ALREADY_CALLED to true to avoid recalling the normalizer in the same operation
        $context[self::ALREADY_CALLED] = true;

        // Set the fileUrl
        $object->setFileUrl($this->storage->resolveUri($object, 'file'));        
        $data = $this->normalizer->normalize($object, null, $context);
                
        return $data;
    }

    public function supportsNormalization($data, ?string $format = null, array $context = []): bool
    {
        if (isset($context[self::ALREADY_CALLED])) {
            return false;
        }

        // Go to normalizer only if data is of type MediaFile
        return $data instanceof MediaFile;
    }
}