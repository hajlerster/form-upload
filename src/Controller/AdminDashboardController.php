<?php

namespace App\Controller;

use App\Repository\UserWithImageRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminDashboardController extends AbstractController
{

    private $userWithImageRepository;

    public function __construct(UserWithImageRepository $userWithImageRepository)
    {
        $this->userWithImageRepository = $userWithImageRepository;
    }


    #[Route('/admin/dashboard', name: 'app_admin_dashboard')]
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $query = $this->userWithImageRepository->createQueryBuilder('u')->getQuery();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            3 // Liczba wyników na stronę
        );

        return $this->render('admin_dashboard/index.html.twig', [
            'controller_name' => 'AdminDashboardController',
            'pagination' => $pagination,
        ]);
    }
}
