<?php

namespace App\Controller\Home;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/home.html.twig', [ ]);
    }

    #[Route('/services', name: 'app_services')]
    public function services(): Response
    {
        return $this->render('home/services.html.twig', [ ]);
    }

    #[Route('/investments', name: 'app_investments')]
    public function investissements(): Response
    {
        return $this->render('home/investments.html.twig', [ ]);
    }

    #[Route('/prets-et-crédits', name: 'app_loans')]
    public function credits(): Response
    {
        return $this->render('home/loans.html.twig', [ ]);
    }

    #[Route('/gestion-de-patrimoine', name: 'app_heritages')]
    public function heritages(): Response
    {
        return $this->render('home/heritage.html.twig', [ ]);
    }

    #[Route('/demander-un-pret', name: 'app_get_loans')]
    public function getLoan(): Response
    {
        return $this->render('home/get_loan.html.twig', [ ]);
    }
}
