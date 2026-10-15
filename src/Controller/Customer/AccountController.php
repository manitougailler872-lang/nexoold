<?php

namespace App\Controller\Customer;

use App\Entity\User;
use App\Utils\Common;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/customer')]
final class AccountController extends AbstractController
{
    #[Route('/accounts',  name: 'app_customer_accounts')]
    public function accounts(): Response
    {
        $connectedUser = $this->getUser();
        if(!$connectedUser instanceof User){
            return $this->redirectToRoute('app_logout');
        }
        return $this->render('customer/accounts.html.twig', [ 
            'accounts' => $connectedUser->getCustomer()->getAccounts()
        ]);
    }
}