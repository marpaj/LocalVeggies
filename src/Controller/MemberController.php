<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MemberController extends AbstractController
{
    /**
     * @Route("/member/orders", name="list_member_orders")
     */
    public function index()
    {
        return $this->render('home.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
