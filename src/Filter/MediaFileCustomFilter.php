<?php
namespace App\Filter;
use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\PropertyInfo\Type;

final class MediaFileCustomFilter extends AbstractFilter
{
    protected function filterProperty(string $property, $value, QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, Operation $operation = null, array $context = []): void
    {   
        // Check if the request is to get first picture for a list of properties     
        if($property === "firstPictureInProperties" && $value != NULL) {                
            // Get the first created image for each property
            $fileType = 'image';
            $queryBuilder
            ->select('o.idProperty, Min(o.id) as firstPicId, o.filePath')
            ->andWhere(sprintf('o.idProperty IN (%s) AND o.fileType = \'%s\'', $value, $fileType))            
            ->orderBy('o.idProperty')
            ->groupBy('o.idProperty');
        }        
    }
    
    public function getDescription(string $resourceClass): array
    {        
        return [];
    }
}