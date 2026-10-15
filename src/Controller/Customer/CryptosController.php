<?php

namespace App\Controller\Customer;

use App\Utils\Common;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/customer')]
final class CryptosController extends AbstractController
{
    #[Route('/cryptos',  name: 'app_customer_cryptos')]
    public function cryptos(): Response
    {
        return $this->render('customer/cryptos.html.twig', [ ]);
    }
}