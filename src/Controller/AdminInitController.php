<?php

namespace App\Controller;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

// Jeśli twój użytkownik ma inną przestrzeń nazw, dostosuj ten import.


class AdminInitController extends AbstractController
{
    private UserPasswordHasherInterface $passwordHasher;
    private EntityManagerInterface $entityManager;


    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    #[Route('/init-admin', name: 'app_admin_init')]
    public function index(): Response
    {
        $entityManager = $this->entityManager;

        //check if admin user already exists
        $admin = $entityManager->getRepository(User::class)->findOneBy(['username' => 'admin']);
        if ($admin) {
            return new Response('Admin użytkownik już istnieje!');
        }

        $admin = new User();
        $admin->setUsername('admin');
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'MichalRusin!23'));
        $admin->setRoles(['ROLE_ADMIN']);

        $entityManager->persist($admin);
        $entityManager->flush();

        return new Response('Admin użytkownik został utworzony!');
    }
}
