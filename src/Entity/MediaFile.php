<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Operation;
use App\Repository\MediaFileRepository;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Controller\MediaFileController;

#[Vich\Uploadable]
#[ApiResource(
    normalizationContext: ['groups' => ['media_file:read']], 
    types: ['https://schema.org/MediaFile'],
    operations: [
        new Get(),
        new GetCollection(),
        new Post(
            controller: MediaFileController::class, 
            deserialize: false, 
            // validationContext: ['groups' => ['Default', 'media_file_create']], 
            /*
            openapi: new Model\Operation(
                requestBody: new Model\RequestBody(
                    content: new \ArrayObject([
                        'multipart/form-data' => [
                            'schema' => [
                                'type' => 'object', 
                                'properties' => [
                                    'file' => [
                                        'type' => 'string', 
                                        'format' => 'binary'
                                    ]
                                ]
                            ]
                        ]
                    ])
                )
            )*/
        )
    ]
)]
#[ORM\Entity(repositoryClass: MediaFileRepository::class)]
class MediaFile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 500)]
    #[ApiProperty(types: ['https://schema.org/contentUrl'])]
    #[Groups(['media_file:read'])]
    private ?string $fileUrl = null;

    #[ORM\Column(length: 500)]
    private ?string $filePath = null;


    #[Vich\UploadableField(mapping: "media_file", fileNameProperty: "filePath")]
    // #[Assert\NotNull(groups: ['media_file_create'])]
    public ?File $file = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;    


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFileUrl(): ?string
    {
        return $this->fileUrl;
    }

    public function setFileUrl(string $fileUrl): static
    {
        $this->fileUrl = $fileUrl;

        return $this;
    }

    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    public function setFilePath(string $filePath): static
    {
        $this->filePath = $filePath;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
