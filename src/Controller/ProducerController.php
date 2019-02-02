<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProducerController extends AbstractController
{
    /**
     * @Route("/producer/orders", name="list_producer_orders")
     */
    public function index()
    {
        return $this->render('home.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
