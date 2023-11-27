<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\Delete;
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
use App\Controller\MediaFileDeleteController;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;

#[Vich\Uploadable]
#[ApiResource(
    normalizationContext: ['groups' => ['media_file:read']],
    types: ['https://schema.org/MediaFile'],
    operations: [
        new Get(),
        new Delete(),
        new GetCollection(),
        new Post(
            controller: MediaFileController::class,
            deserialize: false,
        )
    ]
)]
#[ORM\Entity(repositoryClass: MediaFileRepository::class)]
#[ApiFilter(SearchFilter::class, properties: ['idProperty' => 'exact', 'fileType' => 'exact'])]
class MediaFile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['media_file:read'])]
    private ?int $id = null;

    #[ApiProperty(types: ['https://schema.org/contentUrl'])]
    #[Groups(['media_file:read'])]
    private ?string $fileUrl = null;

    #[ORM\Column(length: 500)]
    private ?string $filePath = null;


    #[Vich\UploadableField(mapping: "media_file", fileNameProperty: "filePath")]
    public ?File $file = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?int $idProperty = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $fileType = null;


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

    public function setFilePath(?string $filePath): static
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

    public function getIdProperty(): ?int
    {
        return $this->idProperty;
    }

    public function setIdProperty(?int $idProperty): static
    {
        $this->idProperty = $idProperty;

        return $this;
    }

    public function getFileType(): ?string
    {
        return $this->fileType;
    }

    public function setFileType(?string $fileType): static
    {
        $this->fileType = $fileType;

        return $this;
    }

    public function setFile(?File $file): static
    {
        $this->file = $file;

        return $this;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }    
}
