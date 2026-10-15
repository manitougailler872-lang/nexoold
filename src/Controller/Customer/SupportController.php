<?php

namespace App\Controller\Customer;

use App\Utils\Common;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/customer')]
final class SupportController extends AbstractController
{
    private const PER_PAGE = 6;
    #[Route('/support',  name: 'app_customer_support')]
    public function support(): Response
    {
        return $this->render('customer/support.html.twig', [ ]);
    }
}