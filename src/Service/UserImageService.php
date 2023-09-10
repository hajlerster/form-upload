<?php

namespace App\Service;

use App\Entity\UserWithImage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UserImageService
{
    private $uploadsDirectory;
    private $entityManager;

    public function __construct(string $uploadsDirectory, EntityManagerInterface $entityManager)
    {
        $this->uploadsDirectory = $uploadsDirectory;
        $this->entityManager = $entityManager;
    }

    public function replaceUserImage(UserWithImage $userWithImage, ?UploadedFile $newFile): void
    {
        if ($newFile) {
            // Usuwanie starego zdjęcia
            $oldFilePath = $this->uploadsDirectory . '/' . $userWithImage->getPicture();
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }

            // Dodawanie nowego zdjęcia
            $newFileName = md5(uniqid()) . '.' . $newFile->guessExtension();
            $newFile->move($this->uploadsDirectory, $newFileName);
            $userWithImage->setPicture($newFileName);
        }

        $this->entityManager->persist($userWithImage);
        $this->entityManager->flush();
    }

    public function deleteUserImage(UserWithImage $userWithImage): void
    {
        $filePath = $this->uploadsDirectory . '/' . $userWithImage->getPicture();
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $this->entityManager->remove($userWithImage);
        $this->entityManager->flush();
    }
}