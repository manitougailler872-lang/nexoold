<?php

namespace App\Controller\Customer;

use App\Utils\Common;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/customer')]
final class InvestmentController extends AbstractController
{
    private const PER_PAGE = 6;

    #[Route('/investments',  name: 'app_customer_investments')]
    public function investments(): Response
    {
        return $this->render('customer/investments.html.twig', [ ]);
    }
}