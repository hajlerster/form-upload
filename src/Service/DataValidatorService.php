<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;

class DataValidatorService
{
    public function validate(Request $request): array
    {
        $errors = [];

        $firstName = $request->request->get('imie');
        if (empty($firstName)) {
            $errors[] = 'Imię jest wymagane';
        }

        $lastName = $request->request->get('nazwisko');
        if (empty($lastName)) {
            $errors[] = 'Nazwisko jest wymagane';
        }

        return $errors;
    }
}