<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileHandlerService
{
    private $uploadsDirectory;

    public function __construct(string $uploadsDirectory)
    {
        $this->uploadsDirectory = $uploadsDirectory;
    }

    public function validateAndUpload(UploadedFile $file): array
    {
        $errors = [];

        if (!$file || !$file->isValid()) {
            $errors[] = 'Nieprawidłowy plik';
            return $errors;
        }

        if ($file->getSize() > 10 * 1024 * 1024) {
            $errors[] = 'Plik jest za duży. Wrzuć plik mniejszy niż 10MB';
        }

        $mimeType = $file->getMimeType();
        if (!in_array($mimeType, ['image/jpeg', 'image/png'])) {
            $errors[] = 'Nieprawidłowy format pliku. Wybierz plik jpg lub png';
        }

        if (empty($errors)) {
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->uploadsDirectory, $filename);
            return ['filename' => $filename];
        }

        return ['errors' => $errors];
    }
}