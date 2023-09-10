<?php

namespace App\Controller;

use App\Entity\UserWithImage;
use App\Form\UserWithImageType;
use App\Service\DataValidatorService;
use App\Service\FileHandlerService;
use App\Service\UserImageService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserWithImageController extends AbstractController
{
    #[Route('/submit', name: 'submit', methods: ['POST'])]
    public function submit(Request $request, EntityManagerInterface $entityManager, DataValidatorService $validatorService, FileHandlerService $fileHandlerService): Response
    {

        $errors = $validatorService->validate($request);

        $file = $request->files->get('plik');
        $fileData = $fileHandlerService->validateAndUpload($file);

        if (isset($fileData['errors'])) {
            $errors = array_merge($errors, $fileData['errors']);
        }

        if (!empty($errors)) {
            return new JsonResponse(['success' => false, 'errors' => $errors], 400);
        }

        $filename = $fileData['filename'];

        $user = new UserWithImage();
        $user->setFirstName($request->request->get('imie'));
        $user->setLastName($request->request->get('nazwisko'));
        $user->setPicture($filename);

        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse(['success' => true, 'message' => 'Użytkownik został zapisany, a zdjęcie zapisane!'], 200);

    }

    #[Route('/admin/user/{id}/edit', name: 'user_with_image_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, UserWithImage $userWithImage, UserImageService $userImageService): Response
    {
        $form = $this->createForm(UserWithImageType::class, $userWithImage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newFile = $form->get('picture')->getData();
            $userImageService->replaceUserImage($userWithImage, $newFile);

            return $this->redirectToRoute('app_admin_dashboard');
        }


        return $this->render('user_with_image/edit.html.twig', [
            'userWithImage' => $userWithImage,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/user/{id}/delete', name: 'user_with_image_delete', methods: ['GET', 'POST'])]
    public function delete(Request $request, UserWithImage $userWithImage, UserImageService $userImageService): Response
    {
        if ($this->isCsrfTokenValid('delete' . $userWithImage->getId(), $request->request->get('_token'))) {
            $userImageService->deleteUserImage($userWithImage);
        }

        return new JsonResponse(['message' => 'Użytkownik został usunięty'], 200);

    }


}